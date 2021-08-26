docker-compose up -d
docker-compose exec app composer install
docker-compose exec app vendor/bin/php-cs-fixer fix src
docker-compose exec app php bin/console c:c
