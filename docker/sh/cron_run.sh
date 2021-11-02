#!/bin/bash
while true
php bin/console cache:clear
do
  php bin/console cron:run
  sleep 60
done