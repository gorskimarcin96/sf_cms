#!/bin/bash
kill $(ps aux | grep 'cron_run.sh' | awk '{print $2}')
kill $(ps aux | grep 'messenger_consume.sh' | awk '{print $2}')