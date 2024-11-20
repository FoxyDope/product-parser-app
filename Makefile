CONTAINER_NAME=$(shell docker ps --filter "ancestor=product-parser-app:latest" --format "{{.Names}}")

# Development Commands
generate-secret:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c 'php -r "echo \"APP_SECRET=\" . bin2hex(random_bytes(16)) . \"\n\";" >> .env'
scrape-category:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c 'XDEBUG_TRIGGER=VSCODE php bin/console app:scrape-category --type=$(type) --category=$(category) --pages=$(pages)'
migrate:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c 'php bin/console doctrine:migrations:migrate'
make-migration:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c 'php bin/console make:migration'
cache-clear:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c 'php bin/console cache:clear'
consume-messages:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c 'php bin/console messenger:consume product_parsing -vv'
ci:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c 'composer install'
composer:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c 'composer $(CMD)'
test-all:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c './vendor/bin/phpunit'
test-unit:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c './vendor/bin/phpunit --testsuite Unit'
test-functional:
	docker exec -i $(CONTAINER_NAME) /bin/sh -c './vendor/bin/phpunit --testsuite Functional'
