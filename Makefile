#!make
include _docker/variables.env
export $(shell sed 's/=.*//' _docker/variables.env)

ifndef VERBOSE
MAKEFLAGS += --no-print-directory
endif

default: help

help:
	@echo ""
	@echo ""
	@echo "Allowed operations outside docker:"
	@echo ""
	@echo "  Docker:"
	@echo "   docker-up               Start docker for application (as daemon!)"
	@echo "   docker-down             Stop docker"
	@echo "   docker-php-X            Login into docker-php-X machine"
	@echo "   docker-server-X         Login into docker-server-X machine"
	@echo "   docker-clean            Clean cache on docker-php machine"
	@echo ""
	@echo "   docker-remove-images    Removes all images and containers."
	@echo "                           !!!WARNING!!! Do it on your own risk!"
	@echo ""
	@echo ""
	@echo "  Utilities:"
	@echo "   clean                   Clean all cache, logs, sessions"
	@echo "   clean-coverage          Clean coverage report"
	@echo ""
	@echo ""


docker-up:
	@cd _docker/ && sh launch.sh

docker-down:
	@docker-compose -f "_docker/docker-compose.yml" down

docker-clean:
	@-docker-compose -f "_docker/docker-compose.yml" exec -T php php composer.phar docker:cache:clear

docker-php-1:
	@echo "\nWelcome to $(PHP_FPM1) machine\n"
	@docker exec -i -t $(PHP_FPM1) bash

docker-php-2:
	@echo "\nWelcome to $(PHP_FPM2) machine\n"
	@docker exec -i -t $(PHP_FPM2) bash

docker-remove-images:
	@cd _docker/ && sh clean_images.sh

docker-server-1:
	@echo "\nWelcome to $(NGINX_HOST1) machine\n"
	@docker exec -i -t $(NGINX_HOST1) bash

docker-server-2:
	@echo "\nWelcome to $(NGINX_HOST2) machine\n"
	@docker exec -i -t $(NGINX_HOST2) bash
