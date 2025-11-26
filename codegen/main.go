package main

import (
	"fmt"
	"log/slog"
	"os"

	"github.com/lmittmann/tint"
	"github.com/urfave/cli/v2"
)

func main() {
	if err := App().Run(os.Args); err != nil {
		fmt.Fprintf(os.Stderr, "program exited: %v", err)
		os.Exit(1)
	}
}

func App() *cli.App {
	return &cli.App{
		Name:           "codegen",
		Usage:          "sumup-php generator.",
		DefaultCommand: "generate",
		Before: func(ctx *cli.Context) error {
			logger := slog.New(tint.NewHandler(os.Stderr, nil))
			slog.SetDefault(logger)
			return nil
		},
		Commands: []*cli.Command{
			Generate(),
		},
	}
}
