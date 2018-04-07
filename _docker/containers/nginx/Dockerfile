FROM nginx:stable-alpine

RUN apk add --update bash \
    mc \
    && rm -rf /var/cache/apk/*

WORKDIR /etc/nginx/conf.d/