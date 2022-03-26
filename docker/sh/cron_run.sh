#!/bin/bash
kill $(ps aux | grep 'cron_run.sh' | awk '{print $2}')
while true
php bin/console cache:clear
do
  php bin/console cron:run
  sleep 60
done