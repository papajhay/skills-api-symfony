COMPOSE ?= docker compose
PHP ?= php

.PHONY: help build up down restart logs shell composer-install migrate fixtures test

help:
	@printf '%s\n' \
		'Available targets:' \
		'  make build            Build the Docker images' \
		'  make up               Start the stack in detached mode' \
		'  make down             Stop and remove the stack' \
		'  make restart          Restart the stack' \
		'  make logs             Follow service logs' \
		'  make shell            Open a shell in the PHP container' \
		'  make composer-install Install PHP dependencies in the container' \
		'  make migrate          Run Doctrine migrations' \
		'  make fixtures         Load Doctrine fixtures' \
		'  make test             Run the test suite'

build:
	$(COMPOSE) build

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

restart:
	$(COMPOSE) restart

logs:
	$(COMPOSE) logs -f

shell:
	$(COMPOSE) exec php sh

composer-install:
	$(COMPOSE) exec php composer install

migrate:
	$(COMPOSE) exec php php bin/console doctrine:migrations:migrate --no-interaction

fixtures:
	$(COMPOSE) exec php php bin/console doctrine:fixtures:load --no-interaction

test:
	$(COMPOSE) exec php php bin/phpunit
