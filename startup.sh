#!/usr/bin/env bash

COMPOSE_FILES="-f docker-compose.yml"

if [[ -f "docker-compose.local.yml" ]]; then
  COMPOSE_FILES="${COMPOSE_FILES} -f docker-compose.local.yml"
fi

echo "Using compose files: ${COMPOSE_FILES}"

docker-compose ${COMPOSE_FILES} up -d --force-recreate || exit 1
docker-compose ${COMPOSE_FILES} ps || exit 1
docker-compose ${COMPOSE_FILES} exec php sh || exit 1
