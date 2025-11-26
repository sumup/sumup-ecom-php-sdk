package generator

import (
	"bytes"
	"fmt"
	"log/slog"
	"maps"
	"os"
	"path/filepath"
	"slices"
	"strings"

	"github.com/pb33f/libopenapi/datamodel/high/base"
	v3 "github.com/pb33f/libopenapi/datamodel/high/v3"
)

const (
	sharedTagKey         = "__shared"
	sharedTagDisplayName = "Shared"
	sharedTagNamespace   = "SumUp\\Shared"
)

// Config defines generator options.
type Config struct {
	// Out is the output directory.
	Out string
}

// Generator orchestrates the SDK generation.
type Generator struct {
	cfg Config

	spec *v3.Document

	tagLookup map[string]*base.Tag

	// schemasByTag maps normalized tag names to schemas they own.
	schemasByTag map[string][]*base.SchemaProxy

	// schemaNamespaces tracks where a schema is defined so we can reference it.
	schemaNamespaces map[string]string

	operationsByTag map[string][]*operation
}

// New creates a new Generator instance.
func New(cfg Config) *Generator {
	return &Generator{
		cfg: cfg,
	}
}

// Load ingests the OpenAPI spec and prepares it for code generation.
func (g *Generator) Load(spec *v3.Document) error {
	if spec == nil {
		return fmt.Errorf("nil spec")
	}

	g.spec = spec
	g.tagLookup = make(map[string]*base.Tag)
	for _, tag := range spec.Tags {
		if tag == nil {
			continue
		}
		g.tagLookup[normalizeTagKey(tag.Name)] = tag
	}

	usage := g.collectSchemaUsage()
	g.schemasByTag, g.schemaNamespaces = g.assignSchemasToTags(usage)
	g.operationsByTag = g.collectOperations()

	return nil
}

// Build generates the SDK in the configured destination.
func (g *Generator) Build() error {
	if g.spec == nil {
		return fmt.Errorf("missing specs: call Load to load the specs first")
	}

	tagKeys := slices.Collect(maps.Keys(g.schemasByTag))
	slices.Sort(tagKeys)

	for _, tagKey := range tagKeys {
		if len(g.schemasByTag[tagKey]) == 0 {
			continue
		}

		if err := g.writeTagModels(tagKey, g.schemasByTag[tagKey]); err != nil {
			return err
		}
	}

	slog.Info("models generated", slog.Int("tags", len(tagKeys)))

	if err := g.writeServices(); err != nil {
		return err
	}

	if err := g.writeSumUpClass(); err != nil {
		return err
	}

	return nil
}

func (g *Generator) writeTagModels(tagKey string, schemas []*base.SchemaProxy) error {
	tagName := g.displayTagName(tagKey)
	namespace := g.namespaceForTag(tagKey)

	dir := filepath.Join(g.cfg.Out, "SumUp", tagName)
	if err := os.MkdirAll(dir, os.ModePerm); err != nil {
		return fmt.Errorf("create tag directory: %w", err)
	}

	filename := filepath.Join(dir, fmt.Sprintf("%s.php", tagName))
	f, err := os.OpenFile(filename, os.O_CREATE|os.O_WRONLY|os.O_TRUNC, 0o644)
	if err != nil {
		return fmt.Errorf("open %q: %w", filename, err)
	}
	defer func() {
		_ = f.Close()
	}()

	var buf bytes.Buffer
	buf.WriteString("<?php\n\ndeclare(strict_types=1);\n\n")
	fmt.Fprintf(&buf, "namespace %s;\n\n", namespace)

	for idx, schema := range schemas {
		className := schemaClassName(schema)
		classCode := g.buildPHPClass(className, schema, namespace)
		buf.WriteString(classCode)
		if idx < len(schemas)-1 {
			buf.WriteString("\n")
		}
	}

	if _, err := f.Write(buf.Bytes()); err != nil {
		return fmt.Errorf("write file %q: %w", filename, err)
	}

	slog.Info("generated models file",
		slog.String("tag", tagName),
		slog.String("namespace", namespace),
		slog.String("file", filename),
		slog.Int("classes", len(schemas)),
	)

	return nil
}

func (g *Generator) buildPHPClass(name string, schema *base.SchemaProxy, currentNamespace string) string {
	var buf strings.Builder
	description := ""
	if schema.Schema() != nil {
		description = schema.Schema().Description
	}

	if description != "" {
		buf.WriteString("/**\n")
		for _, line := range strings.Split(description, "\n") {
			line = strings.TrimSpace(line)
			if line == "" {
				buf.WriteString(" *\n")
				continue
			}
			buf.WriteString(" * ")
			buf.WriteString(line)
			buf.WriteString("\n")
		}
		buf.WriteString(" */\n")
	}

	fmt.Fprintf(&buf, "class %s\n{\n", name)

	properties := g.schemaProperties(schema, currentNamespace)
	if len(properties) == 0 {
		buf.WriteString("}\n")
		return buf.String()
	}

	for _, prop := range properties {
		propCode := g.renderProperty(prop)
		buf.WriteString(propCode)
	}

	buf.WriteString("}\n")
	return buf.String()
}

func (g *Generator) displayTagName(tagKey string) string {
	if tagKey == sharedTagKey {
		return sharedTagDisplayName
	}

	if tag, ok := g.tagLookup[tagKey]; ok && tag != nil && tag.Name != "" {
		return sanitizeTagName(tag.Name)
	}

	return sanitizeTagName(tagKey)
}

func (g *Generator) namespaceForTag(tagKey string) string {
	if tagKey == sharedTagKey {
		return sharedTagNamespace
	}

	tagName := g.displayTagName(tagKey)
	return fmt.Sprintf("SumUp\\%s", tagName)
}
