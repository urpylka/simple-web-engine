#! /usr/bin/env bash

docker rm -f swe_v2-client 2>/dev/null

echo "Interrupt this in 5 sec..."
sleep 5

docker run -d \
    --name swe_v2-client \
    -p 80:80 \
    -v $(pwd)/www:/usr/share/nginx/html \
    nginx:alpine
