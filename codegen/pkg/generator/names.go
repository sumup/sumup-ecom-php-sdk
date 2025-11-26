package generator

import (
	"strings"

	"github.com/iancoleman/strcase"
	"github.com/pb33f/libopenapi/datamodel/high/base"
)

func schemaClassName(schema *base.SchemaProxy) string {
	if schema == nil {
		return ""
	}

	if ref := schema.GetReference(); ref != "" {
		name := strings.TrimPrefix(ref, "#/components/schemas/")
		name = strings.ReplaceAll(name, ".", "_")
		name = strings.ReplaceAll(name, "-", "_")
		return strcase.ToCamel(name)
	}

	if schema.Schema() != nil && schema.Schema().Title != "" {
		return strcase.ToCamel(schema.Schema().Title)
	}

	return "Model"
}

func normalizeTagKey(tag string) string {
	tag = strings.TrimSpace(strings.ToLower(tag))
	if tag == "" {
		return "default"
	}
	return tag
}

func sanitizeTagName(tag string) string {
	tag = strings.TrimSpace(tag)
	tag = strings.ReplaceAll(tag, "-", " ")
	tag = strings.ReplaceAll(tag, "_", " ")
	if tag == "" {
		return "Default"
	}
	return strcase.ToCamel(tag)
}
