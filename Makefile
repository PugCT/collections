#!make

help:
	@awk -F ':|##' '/^[^\t].+?:.*?##/ {printf "\033[36m%-30s\033[0m %s\n", $$1, $$NF}' $(MAKEFILE_LIST)

phpstan: ## Run phpstan analysis tool
	php vendor/bin/phpstan analyse

psalm: ## Run psalm analysis tool
	php vendor/bin/psalm

phpunit: ## Run unit tests
	php vendor/bin/phpunit --testdox tests --coverage-html build/coverage-report

analize: ## Run all analysis and tests tools
	make phpstan && make psalm && make phpunit
