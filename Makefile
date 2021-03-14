init: # init
	# @cd docker && docker-compose build --force-rm --no-cache
	#make ci
	make db-create
	#make db-update
	#make db-fixtures-load

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

db-create:	# schema-create
	@cd docker && docker-compose exec php bin/console doctrine:database:create --if-not-exists

db-update:	# schema-update
	@cd docker && docker-compose exec php bin/console doctrine:database:create --if-not-exists
	@cd docker && docker-compose exec php bin/console doctrine:schema:update --force

db-recreate: # recreate db
	@cd docker && docker-compose exec php bin/console doctrine:database:drop --force
	@cd docker && docker-compose exec php bin/console doctrine:database:create
	@cd docker && docker-compose exec php bin/console doctrine:schema:update --force

sf-cc:	# schema-update
	@cd docker && docker-compose exec php bin/console cache:clear

db-fixtures-load: # load fixtures
	@cd docker && docker-compose exec php bin/console doctrine:fixtures:load --no-interaction

ci: # composer install
	@cd docker && docker-compose exec php composer install
