package extension

import (
	"github.com/pb33f/libopenapi/orderedmap"
	"go.yaml.in/yaml/v4"
)

// Get extracts extension attributes from extensions.
func Get[T any](ext *orderedmap.Map[string, *yaml.Node], key string) (T, bool) {
	var empty T
	if ext == nil {
		return empty, false
	}

	if raw, ok := ext.Get(key); ok {
		var v T
		if err := raw.Decode(&v); err != nil {
			return empty, false
		}

		return v, true
	}

	return empty, false
}

// GetOrDefault extracts extension attributes from extensions, returning def as default.
func GetOrDefault[T any](ext *orderedmap.Map[string, *yaml.Node], key string, def T) T {
	if val, ok := Get[T](ext, key); ok {
		return val
	}

	return def
}
