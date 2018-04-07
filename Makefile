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
	@echo "  Utilities:"
	@echo "   clean                   Clean all cache, logs, sessions"
	@echo "   clean-coverage          Clean coverage report"
	@echo ""
	@echo ""


docker-up:
	@cd _docker/ && sh launch.sh
	@exit

docker-down:
	@docker-compose -f "_docker/docker-compose.yml" down

docker-clean:
	@-docker-compose -f "_docker/docker-compose.yml" exec -T php php composer.phar docker:cache:clear

docker-php1:
	@echo "\nWelcome to PHP machine\n"
	@docker exec -i -t php1 bash
	@exit

docker-php2:
	@echo "\nWelcome to PHP machine\n"
	@docker exec -i -t php2 bash
	@exit

docker-remove-images:
	@cd _docker/ && sh clean_images.sh
