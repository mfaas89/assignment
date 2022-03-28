#!/bin/bash

cd /opt/application

# Correct ownership of the node_modules folder (Reason: The mount in docker-compose forces it to root)
sudo chown -R www:www node_modules
npm i

exec npm run start
