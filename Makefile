PROJECT_NAME="$(shell basename "$(PWD)")"
PROJECT_DIR="$(shell pwd)"
DOCKER_COMPOSE="$(shell which docker-compose)"
DOCKER="$(shell which docker)"
CONTAINER_PHP="php-unit"

init: generate-env up  ci right

restart: down up

sleep-5:
	sleep 5

up:
	docker-compose   --env-file .env up --build -d

down:
	docker-compose   --env-file .env down --remove-orphans

generate-env:
	@if [ ! -f .env ]; then \
    		cp .env.example .env && \
    		sed -i "s/^DB_PASSWORD=/DB_PASSWORD=$(shell openssl rand -hex 8)/" .env; \
    	fi

bash:
	${DOCKER_COMPOSE} exec -it ${CONTAINER_PHP} /bin/bash

ps:
	${DOCKER_COMPOSE} ps

logs:
	${DOCKER_COMPOSE} logs -f

ci:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} composer install --no-interaction

cu:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} composer update --no-interaction

m-up:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} php artisan migrate

m-rollback:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} php artisan migrate:rollback

m-status:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} php artisan migrate:status

cc:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} php artisan cache:clear

right:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} chown -R www-data:www-data . && \
	chmod -R guo+w storage

test:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} php artisan test

