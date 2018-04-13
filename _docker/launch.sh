#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

docker-compose -f "${DIR}/docker-compose.yml" down -v
docker-compose -f "${DIR}/docker-compose.yml" up

