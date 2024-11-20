# Development Commands
scrape-category:
	docker exec -i product-parser-app-php-1 /bin/sh -c 'XDEBUG_TRIGGER=VSCODE php bin/console app:scrape-category --type=ebay --category=electronics --pages=3'
migrate:
	docker exec -i product-parser-app-php-1 /bin/sh -c 'php bin/console doctrine:migrations:migrate'
make-migration:
	docker exec -i product-parser-app-php-1 /bin/sh -c 'php bin/console make:migration'
cache-clear:
	docker exec -i product-parser-app-php-1 /bin/sh -c 'php bin/console cache:clear'
consume-messages:
	docker-compose exec php /bin/sh -c 'php bin/console messenger:consume product_parsing -vv'
ci:
	docker-compose exec php /bin/sh -c 'composer install'
composer:
	docker-compose exec php /bin/sh -c 'composer $(CMD)'

