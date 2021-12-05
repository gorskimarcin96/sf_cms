#!/bin/bash
php bin/console cache:clear
php bin/console messenger:stop-workers
php bin/console messenger:consume async