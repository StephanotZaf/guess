.PHONY: init
init: # init
	@cd docker && docker-compose build --force-rm --no-cache && cd -
	make ci && cd -
	@cp -n .env .env.local
	@cp -n docker/.env.dist .env
	make db-create && cd -
	make db-update && cd -
	make db-load && cd -

.PHONY: dc-start
dc-start: # docker compose start
	@cd docker && docker-compose start

.PHONY: dc-up
dc-up: # docker compose up
	@cd docker && docker-compose up -d

.PHONY: dc-build
dc-build: # docker compose build
	@cd docker && docker-compose build

.PHONY: dc-rebuild
dc-rebuild: # docker compose up and rebuild
	@cd docker && docker-compose up -d --build

.PHONY: dc-stop
dc-stop: # docker compose stop
	@cd docker && docker-compose stop

.PHONY: dc-exec-php
dc-exec-php: # goto php container
	@cd docker && docker-compose exec php bash

.PHONY: dc-exec-mysql
dc-exec-mysql: # goto mysql container
	@cd docker && docker-compose exec mysql bash

.PHONY: dc-exec-nginx
dc-exec-mysql: # goto nginx container
	@cd docker && docker-compose exec nginx bash

.PHONY: dc-down
dc-down: # docker compose down
	@cd docker && docker-compose down -v --rmi=all --remove-orphans

.PHONY: db-create
db-create:	# schema-create
	@cd docker && docker-compose exec php bin/console doctrine:database:create --if-not-exists

.PHONY: db-update
db-update:	# schema-update
	@cd docker && docker-compose exec php bin/console doctrine:database:create --if-not-exists
	@cd docker && docker-compose exec php bin/console doctrine:schema:update --force

.PHONY: db-init
db-init: # db init
	@cd docker && docker-compose exec php bin/console doctrine:database:drop --force
	@cd docker && docker-compose exec php bin/console doctrine:database:create
	@cd docker && docker-compose exec php bin/console doctrine:schema:update --force

.PHONY: db-load
db-load: # load fixtures
	@cd docker && docker-compose exec php bin/console doctrine:fixtures:load --no-interaction

.PHONY: db-validate
db-validate: # validate schema
	@cd docker && docker-compose exec php bin/console doctrine:cache:clear-metadata
	@cd docker && docker-compose exec php bin/console doctrine:schema:validate

.PHONY: sf-cc
sf-cc:	# symfony cache-clear
	@cd docker && docker-compose exec php bin/console cache:clear

.PHONY: sf-cc-all
sf-cc-all:	# symfony cache-clear all
	@cd docker && docker-compose exec php bin/console cache:clear
	@cd docker && docker-compose exec php bin/console doctrine:cache:clear-metadata
	@cd docker && docker-compose exec php bin/console doctrine:cache:clear-query
	@cd docker && docker-compose exec php bin/console doctrine:cache:clear-result

.PHONY: ci
ci: # composer install
	@cd docker && docker-compose exec php composer install
