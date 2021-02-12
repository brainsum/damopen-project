#!/usr/bin/env bash

COMPOSE_FILES="-f docker-compose.yml"

if [[ -f "docker-compose.local.yml" ]]; then
  COMPOSE_FILES="${COMPOSE_FILES} -f docker-compose.local.yml"
fi

echo "Using compose files: ${COMPOSE_FILES}"

# Stop the container. Don't use down, or you'll lose your db.
docker-compose ${COMPOSE_FILES} stop || exit 1
# Stop containers managed by pygmy. The pygmy down will remove data, use it only when necessary.
# pygmy stop || exit 1

# You could stop docker, restart local web server, or whatever here.