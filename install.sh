#!/bin/bash
npm install --production --prefer-offline --no-audit --progress=false
composer install --no-dev -o
echo "installation done!"
echo "run 'composer serve' to start server."