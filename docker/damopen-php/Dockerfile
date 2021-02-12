ARG BASE_IMAGE
ARG BASE_IMAGE_TAG

FROM $BASE_IMAGE:$BASE_IMAGE_TAG

USER root

RUN apk add --update --no-cache \
    && apk add ffmpeg \
    && rm -rf \
      /var/cache/apk/*

USER wodby
