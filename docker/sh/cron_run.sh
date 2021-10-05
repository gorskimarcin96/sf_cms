#!/bin/bash
while true
do
  php bin/console cron:run
  sleep 60
done