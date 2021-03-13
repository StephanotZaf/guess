init: # init
	@cd docker && docker-compose build --force-rm --no-cache
	make up

up: # up
	@cd docker && docker-compose up -d
	echo "Application is running at http://localhost:81"
	make schema-update

# docker
dc-rebuild: # up
	@cd docker && docker-compose up -d --build


dc-stop: # up
	@cd docker && docker-compose stop


dc-build: # up
	@cd docker && docker-compose build


dc-up: # up
	@cd docker && docker-compose up -d

db-create:	# schema-create
				@cd docker && docker-compose exec php bin/console doctrine:database:create --if-not-exists

db-update:	# schema-update
				@cd docker && docker-compose exec php bin/console doctrine:database:create --if-not-exists
				@cd docker && docker-compose exec php bin/console doctrine:schema:update --force

db-recreate: # recreate db
					@cd docker && docker-compose exec php bin/console doctrine:database:drop --force
					@cd docker && docker-compose exec php bin/console doctrine:database:create
					@cd docker && docker-compose exec php bin/console doctrine:schema:update --force
dc-exec-php: # up
	@cd docker && docker-compose exec php bash

sf-cc:	# schema-update
				@cd docker && docker-compose exec php bin/console cache:clear

db-fixtures-load: # load fixtures
		@cd docker && docker-compose exec php bin/console doctrine:fixtures:load --no-interaction