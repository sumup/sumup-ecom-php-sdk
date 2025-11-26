package generator

import (
	"fmt"
	"log/slog"
	"slices"
	"strings"

	"github.com/iancoleman/strcase"
	v3 "github.com/pb33f/libopenapi/datamodel/high/v3"

	"github.com/sumup/sumup-ecom-php-sdk/codegen/pkg/extension"
)

type operation struct {
	ID          string
	Summary     string
	Description string
	Method      string
	Path        string
	PathParams  []operationParam
	HasQuery    bool
	HasBody     bool
	Deprecated  bool
}

type operationParam struct {
	OriginalName string
	VarName      string
	Description  string
}

func (g *Generator) collectOperations() map[string][]*operation {
	result := make(map[string][]*operation)

	if g.spec == nil || g.spec.Paths == nil {
		return result
	}

	for path, pathItem := range g.spec.Paths.PathItems.FromOldest() {
		for method, op := range pathItem.GetOperations().FromOldest() {
			if op == nil {
				continue
			}

			mergedParams := make([]*v3.Parameter, 0, len(pathItem.Parameters)+len(op.Parameters))
			mergedParams = append(mergedParams, pathItem.Parameters...)
			mergedParams = append(mergedParams, op.Parameters...)

			built, err := g.buildOperation(strings.ToUpper(method), path, op, mergedParams)
			if err != nil {
				slog.Warn("unable to build operation",
					slog.String("method", method),
					slog.String("path", path),
					slog.String("error", err.Error()),
				)
				continue
			}

			if len(op.Tags) == 0 {
				slog.Warn("operation missing tags, skipping service generation",
					slog.String("operation_id", built.ID),
					slog.String("path", path),
					slog.String("method", method),
				)
				continue
			}

			for _, tag := range op.Tags {
				tagKey := normalizeTagKey(tag)
				result[tagKey] = append(result[tagKey], built)
			}
		}
	}

	for key := range result {
		slices.SortFunc(result[key], func(a, b *operation) int {
			return strings.Compare(a.ID, b.ID)
		})
	}

	return result
}

func (g *Generator) buildOperation(method, path string, op *v3.Operation, params []*v3.Parameter) (*operation, error) {
	operationID := op.OperationId
	if operationID == "" {
		trimmed := strings.ReplaceAll(path, "/", "_")
		if trimmed == "" {
			trimmed = "root"
		}
		operationID = fmt.Sprintf("%s_%s", strings.ToLower(method), trimmed)
	}

	if ext, ok := extension.Get[map[string]any](op.Extensions, "x-codegen"); ok {
		if methodName, ok := ext["method_name"]; ok {
			if methodStr, ok := methodName.(string); ok && methodStr != "" {
				operationID = methodStr
			}
		}
	}

	pathParams := make([]operationParam, 0)
	hasQuery := false
	for _, param := range params {
		if param == nil {
			continue
		}

		switch param.In {
		case "path":
			pathParams = append(pathParams, operationParam{
				OriginalName: param.Name,
				VarName:      phpPropertyName(param.Name),
				Description:  param.Description,
			})
		case "query":
			hasQuery = true
		}
	}

	hasBody := op.RequestBody != nil
	deprecated := false
	if op.Deprecated != nil {
		deprecated = *op.Deprecated
	}

	return &operation{
		ID:          operationID,
		Summary:     strings.TrimSpace(op.Summary),
		Description: strings.TrimSpace(op.Description),
		Method:      method,
		Path:        path,
		PathParams:  pathParams,
		HasQuery:    hasQuery,
		HasBody:     hasBody,
		Deprecated:  deprecated,
	}, nil
}

func (op *operation) methodName() string {
	if op == nil {
		return ""
	}

	if op.ID == "" {
		return ""
	}

	return strcase.ToLowerCamel(op.ID)
}
