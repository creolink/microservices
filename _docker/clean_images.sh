#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

docker-compose -f "${DIR}/docker-compose.yml" down -v
sleep 5

docker rm $(docker ps -aq) -f
docker rmi $(docker images -q) -f
