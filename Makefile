# Make this makefile self-documented with target `help`
.PHONY: help
.DEFAULT_GOAL := help
help: ## Show help
	@grep -Eh '^[0-9a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

export PHPDOCUMENTOR_VERSION := v3.0.0

.PHONY: vendor
vendor: composer.json ## Install dependencies
	composer install

.PHONY: fmt
fmt: vendor ## Format code using php-cs-fixer
	PHP_CS_FIXER_IGNORE_ENV=true vendor/bin/php-cs-fixer fix -v --using-cache=no

.PHONY: fmtcheck
fmtcheck: vendor ## Check code formatting
	PHP_CS_FIXER_IGNORE_ENV=true vendor/bin/php-cs-fixer fix -v --using-cache=no --dry-run 
