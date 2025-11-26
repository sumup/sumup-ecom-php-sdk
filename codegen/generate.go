package main

import (
	"fmt"
	"os"

	"github.com/pb33f/libopenapi"
	"github.com/urfave/cli/v2"

	"github.com/sumup/sumup-ecom-php-sdk/codegen/pkg/generator"
)

func Generate() *cli.Command {
	var (
		out string
	)

	return &cli.Command{
		Name:  "generate",
		Usage: "Generate the PHP SDK",
		Args:  true,
		Action: func(c *cli.Context) error {
			if !c.Args().Present() {
				return fmt.Errorf("empty argument, path to openapi specs expected")
			}

			specPath := c.Args().First()

			if err := os.MkdirAll(out, os.ModePerm); err != nil {
				return fmt.Errorf("create output directory %q: %w", out, err)
			}

			spec, err := os.ReadFile(specPath)
			if err != nil {
				return fmt.Errorf("read specs: %w", err)
			}

			doc, err := libopenapi.NewDocument(spec)
			if err != nil {
				return fmt.Errorf("load openapi document: %w", err)
			}

			model, err := doc.BuildV3Model()
			if err != nil {
				return fmt.Errorf("build openapi v3 model: %w", err)
			}

			g := generator.New(generator.Config{
				Out: out,
			})

			if err := g.Load(&model.Model); err != nil {
				return fmt.Errorf("load specs: %w", err)
			}

			if err := g.Build(); err != nil {
				return fmt.Errorf("build sdk: %w", err)
			}

			return nil
		},
		Flags: []cli.Flag{
			&cli.StringFlag{
				Name:        "out",
				Aliases:     []string{"o"},
				Usage:       "path of the output directory",
				Required:    false,
				Destination: &out,
				Value:       "../src/",
			},
		},
	}
}
