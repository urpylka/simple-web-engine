#! /usr/bin/env bash

# https://alextoolsblog.blogspot.com/2020/05/docker-pull-postgres.html

docker pull postgres:alpine

mkdir -p $(pwd)/postgres-data 2>/dev/null

# docker rm -f postgres

docker run --rm \
    --name postgres \
    -e POSTGRES_PASSWORD=example \
    -d -p 5432:5432 \
    -v $(pwd)/postgres-data:/var/lib/postgresql/data \
    postgres
