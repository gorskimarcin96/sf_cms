#!/bin/bash
#kill $(ps aux | grep 'messenger_consume.sh' | awk '{print $2}')
php bin/console cache:clear
php bin/console messenger:stop-workers
php bin/console messenger:consume async