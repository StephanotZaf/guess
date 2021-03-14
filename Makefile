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

dc-up: # docker compose up
	@cd docker && docker-compose up -d

dc-build: # docker compose build
	@cd docker && docker-compose build

dc-rebuild: # docker compose up and rebuild
	@cd docker && docker-compose up -d --build

dc-stop: # docker compose stop
	@cd docker && docker-compose stop

dc-exec-php: # up
	@cd docker && docker-compose exec php bash

dc-exec-mysql: # up
	@cd docker && docker-compose exec mysql bash

.PHONY: dc-down
dc-down:
	@cd docker && docker-compose down -v --rmi=all --remove-orphans

db-create:	# schema-create
	@cd docker && docker-compose exec php bin/console doctrine:database:create --if-not-exists

db-update:	# schema-update
	@cd docker && docker-compose exec php bin/console doctrine:database:create --if-not-exists
	@cd docker && docker-compose exec php bin/console doctrine:schema:update --force

db-recreate: # recreate db
	@cd docker && docker-compose exec php bin/console doctrine:database:drop --force
	@cd docker && docker-compose exec php bin/console doctrine:database:create
	@cd docker && docker-compose exec php bin/console doctrine:schema:update --force

db-load: # load fixtures
	@cd docker && docker-compose exec php bin/console doctrine:fixtures:load --no-interaction

sf-cc:	# schema-update
	@cd docker && docker-compose exec php bin/console cache:clear

ci: # composer install
	@cd docker && docker-compose exec php composer install
