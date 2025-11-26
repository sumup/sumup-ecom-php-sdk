package generator

import (
	"log/slog"
	"slices"
	"strings"

	"github.com/pb33f/libopenapi/datamodel/high/base"
	v3 "github.com/pb33f/libopenapi/datamodel/high/v3"
)

type schemaUsage struct {
	schema *base.SchemaProxy
	tags   map[string]struct{}
}

func (g *Generator) collectSchemaUsage() map[string]*schemaUsage {
	usage := make(map[string]*schemaUsage)

	if g.spec == nil || g.spec.Paths == nil {
		return usage
	}

	for path, pathItem := range g.spec.Paths.PathItems.FromOldest() {
		for method, op := range pathItem.GetOperations().FromOldest() {
			c := make(schemaProxyCollection, 0, 16)
			c.collectSchemasInResponse(op)
			c.collectSchemasInParams(op)
			c.collectSchemasInRequest(op)

			for _, schema := range c {
				if schema == nil {
					continue
				}

				if schema.GetReference() == "" {
					continue
				}

				name := schemaClassName(schema)
				entry, ok := usage[name]
				if !ok {
					entry = &schemaUsage{
						schema: schema,
						tags:   make(map[string]struct{}),
					}
					usage[name] = entry
				}

				if len(op.Tags) == 0 {
					slog.Warn("operation without tags; skipping schema assignment",
						slog.String("path", path),
						slog.String("method", method),
						slog.String("schema", name),
					)
					continue
				}

				for _, tag := range op.Tags {
					entry.tags[normalizeTagKey(tag)] = struct{}{}
				}
			}
		}
	}

	return usage
}

func (g *Generator) assignSchemasToTags(usage map[string]*schemaUsage) (map[string][]*base.SchemaProxy, map[string]string) {
	result := make(map[string][]*base.SchemaProxy)
	namespaceBySchema := make(map[string]string)

	for schemaName, info := range usage {
		tagNames := make([]string, 0, len(info.tags))
		for tag := range info.tags {
			tagNames = append(tagNames, tag)
		}

		targetTag := sharedTagKey
		if len(tagNames) == 1 {
			targetTag = tagNames[0]
		}

		result[targetTag] = append(result[targetTag], info.schema)
		namespaceBySchema[schemaName] = g.namespaceForTag(targetTag)
	}

	for tag := range result {
		slices.SortFunc(result[tag], func(a, b *base.SchemaProxy) int {
			return strings.Compare(schemaClassName(a), schemaClassName(b))
		})
	}

	return result, namespaceBySchema
}

type schemaProxyCollection []*base.SchemaProxy

func (c *schemaProxyCollection) collectSchemasInResponse(op *v3.Operation) {
	if op == nil || op.Responses == nil || op.Responses.Codes.Len() == 0 {
		return
	}

	for _, response := range op.Responses.Codes.FromOldest() {
		if response.Content == nil {
			continue
		}

		for _, mediaType := range response.Content.FromOldest() {
			c.collectReferencedSchemas(mediaType.Schema)
		}
	}
}

func (c *schemaProxyCollection) collectSchemasInParams(op *v3.Operation) {
	if op == nil {
		return
	}

	for _, param := range op.Parameters {
		c.collectReferencedSchemas(param.Schema)
	}
}

func (c *schemaProxyCollection) collectSchemasInRequest(op *v3.Operation) {
	if op == nil || op.RequestBody == nil {
		return
	}

	for _, mediaType := range op.RequestBody.Content.FromOldest() {
		c.collectReferencedSchemas(mediaType.Schema)
	}
}

func (c *schemaProxyCollection) collectReferencedSchemas(schema *base.SchemaProxy) {
	if schema == nil {
		return
	}

	spec := schema.Schema()
	if spec == nil {
		return
	}

	if slices.Contains(spec.Type, "object") {
		for _, prop := range spec.Properties.FromOldest() {
			c.collectReferencedSchemas(prop)
		}
	}

	if slices.Contains(spec.Type, "array") && spec.Items != nil {
		c.collectReferencedSchemas(spec.Items.A)
	}

	for _, one := range spec.AnyOf {
		c.collectReferencedSchemas(one)
	}

	for _, one := range spec.AllOf {
		c.collectReferencedSchemas(one)
	}

	for _, one := range spec.OneOf {
		c.collectReferencedSchemas(one)
	}

	if !slices.Contains(*c, schema) {
		*c = append(*c, schema)
	}
}
