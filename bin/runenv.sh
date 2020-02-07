#!/bin/bash

sudo sysctl -w vm.max_map_count=262144
sudo docker stop $(sudo docker ps --filter name=brain -aq) && sudo docker rm $(sudo docker ps --filter name=obelix -aq)
sudo docker-compose build
ln -sf environment/development.env .env
sudo docker network create obelix_default
sudo docker-compose up
