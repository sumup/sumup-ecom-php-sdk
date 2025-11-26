package generator

import (
	"fmt"
	"slices"
	"strings"

	"github.com/iancoleman/strcase"
	"github.com/pb33f/libopenapi/datamodel/high/base"
)

type phpProperty struct {
	Name           string
	SerializedName string
	Type           string
	DocType        string
	Optional       bool
	Description    string
}

func (g *Generator) schemaProperties(schema *base.SchemaProxy, currentNamespace string) []phpProperty {
	spec := schema.Schema()
	if spec == nil || spec.Properties == nil {
		return nil
	}

	required := make(map[string]struct{}, len(spec.Required))
	for _, name := range spec.Required {
		required[name] = struct{}{}
	}

	props := make([]phpProperty, 0, spec.Properties.Len())
	for propName, propSchema := range spec.Properties.FromOldest() {
		prop := phpProperty{
			Name:           phpPropertyName(propName),
			SerializedName: propName,
			Optional:       true,
		}
		if _, ok := required[propName]; ok {
			prop.Optional = false
		}

		if propSchema != nil && propSchema.Schema() != nil {
			prop.Description = propSchema.Schema().Description
		}

		prop.Type, prop.DocType = g.resolvePHPType(propSchema, currentNamespace)

		props = append(props, prop)
	}

	return props
}

func phpPropertyName(name string) string {
	name = strings.TrimSpace(name)
	name = strings.ReplaceAll(name, "[]", "List")
	name = strings.ReplaceAll(name, ".", "_")
	name = strings.ReplaceAll(name, "-", "_")
	name = strings.ReplaceAll(name, " ", "_")
	if name == "" {
		name = "field"
	}

	name = strcase.ToLowerCamel(name)
	if phpReservedWords[name] {
		return name + "Value"
	}

	return name
}

var phpReservedWords = map[string]bool{
	"abstract":  true,
	"array":     true,
	"callable":  true,
	"class":     true,
	"const":     true,
	"default":   true,
	"function":  true,
	"global":    true,
	"interface": true,
	"new":       true,
	"private":   true,
	"protected": true,
	"public":    true,
	"static":    true,
	"string":    true,
	"int":       true,
	"float":     true,
	"bool":      true,
	"self":      true,
	"parent":    true,
	"trait":     true,
	"namespace": true,
}

func (g *Generator) renderProperty(prop phpProperty) string {
	var b strings.Builder

	b.WriteString("    /**\n")
	if prop.Description != "" {
		for _, line := range strings.Split(prop.Description, "\n") {
			line = strings.TrimSpace(line)
			if line == "" {
				continue
			}
			b.WriteString("     * ")
			b.WriteString(line)
			b.WriteString("\n")
		}
	}
	b.WriteString("     *\n")
	docType := prop.DocType
	if prop.Optional {
		if !strings.Contains(docType, "null") {
			docType += "|null"
		}
	}
	fmt.Fprintf(&b, "     * @var %s\n", docType)
	b.WriteString("     */\n")

	propertyType := prop.Type
	if prop.Optional && propertyType != "mixed" && !strings.HasPrefix(propertyType, "?") {
		propertyType = "?" + propertyType
	}

	if propertyType == "" {
		propertyType = "mixed"
	}

	if prop.Optional {
		fmt.Fprintf(&b, "    public %s $%s = null;\n\n", propertyType, prop.Name)
	} else {
		fmt.Fprintf(&b, "    public %s $%s;\n\n", propertyType, prop.Name)
	}

	return b.String()
}

func (g *Generator) resolvePHPType(schema *base.SchemaProxy, currentNamespace string) (string, string) {
	if schema == nil {
		return "mixed", "mixed"
	}

	if ref := schema.GetReference(); ref != "" {
		name := schemaClassName(schema)
		namespace := g.schemaNamespaces[name]
		if namespace == "" {
			return name, name
		}

		typeName := name
		if namespace != currentNamespace {
			typeName = fmt.Sprintf("\\%s\\%s", namespace, name)
		}

		return typeName, typeName
	}

	spec := schema.Schema()
	if spec == nil {
		return "mixed", "mixed"
	}

	if len(spec.Enum) > 0 {
		return "string", "string"
	}

	switch {
	case hasSchemaType(spec, "string"):
		return "string", "string"
	case hasSchemaType(spec, "integer"):
		return "int", "int"
	case hasSchemaType(spec, "number"):
		return "float", "float"
	case hasSchemaType(spec, "boolean"):
		return "bool", "bool"
	case hasSchemaType(spec, "array"):
		itemDoc := "mixed"
		if spec.Items != nil && spec.Items.A != nil {
			_, itemDoc = g.resolvePHPType(spec.Items.A, currentNamespace)
		}
		return "array", itemDoc + "[]"
	case hasSchemaType(spec, "object"):
		return "array", "array"
	default:
	}

	if len(spec.OneOf) > 0 || len(spec.AnyOf) > 0 || len(spec.AllOf) > 0 {
		return "mixed", "mixed"
	}

	return "mixed", "mixed"
}

func hasSchemaType(schema *base.Schema, typ string) bool {
	if schema == nil {
		return false
	}
	return slices.Contains(schema.Type, typ)
}
