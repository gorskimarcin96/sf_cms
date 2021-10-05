docker-compose down
docker-compose up -d
docker-compose exec app-web composer install
docker-compose exec app-web vendor/bin/php-cs-fixer fix src
docker-compose exec app-web php bin/console c:c
docker-compose exec app-web php bin/console doctrine:migrations:migrate -n
