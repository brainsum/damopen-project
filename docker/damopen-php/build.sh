#!/usr/bin/env bash

SCRIPT=$(readlink -f "$0")
SCRIPT_DIR=$(dirname "$SCRIPT")

VARIABLES=$(realpath "${SCRIPT_DIR}/../variables.env")
# shellcheck source=../variables.env
source "${VARIABLES}"

BUILD_TAG="${PHP_IMAGE}:${PHP_IMAGE_TAG}"
LATEST_TAG="${PHP_IMAGE}:latest"

echo "Building tag: ${BUILD_TAG}"

CONTEXT=$(realpath "${SCRIPT_DIR}")

DOCKER_BUILDKIT=1 docker build \
  --progress=plain \
  --rm \
  -f "${SCRIPT_DIR}/Dockerfile" \
  -t "${BUILD_TAG}" \
  -t "${LATEST_TAG}" \
  --build-arg BUILDKIT_INLINE_CACHE=1 \
  --build-arg BASE_IMAGE="${PHP_BASE_IMAGE}" \
  --build-arg BASE_IMAGE_TAG="${PHP_BASE_IMAGE_TAG}" \
  "${CONTEXT}"
