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
	@echo "   docker-php              Login into docker-php machine"
	@echo "   docker-clean            Clean cache on docker-php machine"
	@echo ""
	@echo "   docker-remove-images    Removes all images and containers."
	@echo "                           !!!WARNING!!! Do it on your own risk!"
	@echo ""
	@echo ""
	@echo "Allowed operations inside docker:"
	@echo ""
	@echo "  Testing:"
	@echo "   phpunit                 Run PHPUnit tests & generate coverage report"
	@echo "   behat                   Run Behat tests"
	@echo "   phpcs                   PHP Code Sniffer"
	@echo ""
	@echo "   tests                   All tests"
	@echo ""
	@echo ""
	@echo "  Utilities:"
	@echo "   clean                   Clean all cache, logs, sessions"
	@echo "   clean-coverage          Clean coverage report"
	@echo ""
	@echo ""

tests:
	@make behat
	@make phpunit
	@make phpcs

behat:
	@make clean
	@APPLICATION_ENV="development" bin/behat --config behat.yml --stop-on-failure

phpunit:
	@make clean
	@make clean-coverage
	@APPLICATION_ENV="development"
	@bin/phpunit --coverage-html web/coverage

phpcs:
	bin/phpcs --ignore=fixtures --standard=vendor/creolink/code_style/Symfony2 src

clean:
	@rm -fR var/cache
	@rm -fR var/cache_test
	@rm -rf var/logs
	@rm -rf var/logs_test
	@rm -rf var/sessions
	@-chown -R www-data:1000 var/
	@echo "\nCache cleared\n"

clean-coverage:
	@rm -fR web/coverage

docker-up:
	@cd ../_docker/ && sh launch.sh
	@make clean
	@rm -fR web/coverage
	@make docker-php
	@exit

docker-down:
	@docker-compose -f "../_docker/docker-compose.yml" down

docker-clean:
	@-docker-compose -f "../_docker/docker-compose.yml" exec -T php php composer.phar docker:cache:clear

docker-php:
	@echo "\nWelcome to PHP machine\n"
	@docker exec -i -t web_php bash
	@exit

docker-remove-images:
	@cd ../_docker/ && sh clean_images.sh
