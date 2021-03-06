#!make

help:
	@awk -F ':|##' '/^[^\t].+?:.*?##/ {printf "\033[36m%-30s\033[0m %s\n", $$1, $$NF}' $(MAKEFILE_LIST)

php_cs_fixer: ## Run php-cs-fixer
	php-cs-fixer fix

psalm: ## Run psalm analysis tool
	php vendor/bin/psalm  --report=checkstyle.json

phpunit: ## Run unit tests
	php vendor/bin/phpunit --testdox tests --coverage-html build/coverage-report

infection: ## Run mutation tests
	php infection.phar --threads=4 --log-verbosity=all

analyze: ## Run all analysis and test tools
	make psalm && make phpunit && make infection
