#!/usr/bin/env bash

SCRIPT=$(readlink -f "$0")
SCRIPT_DIR=$(dirname "$SCRIPT")

VARIABLES=$(realpath "${SCRIPT_DIR}/../variables.env")
# shellcheck source=../variables.env
source "${VARIABLES}"

BUILD_TAG="${PHP_IMAGE}:${PHP_IMAGE_TAG}"
LATEST_TAG="${PHP_IMAGE}:latest"

echo "Pushing tag: ${BUILD_TAG}"

docker push "${BUILD_TAG}"
docker push "${LATEST_TAG}"
