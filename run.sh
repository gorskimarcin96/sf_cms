docker-compose up -d
docker-compose exec app-web composer install
docker-compose exec app-web ./bin/console cache:clear
#docker-compose exec app-web ./bin/console doctrine:schema:drop --full-database --force
docker-compose exec app-web ./bin/console doctrine:database:create --if-not-exists
docker-compose exec app-web ./bin/console doctrine:database:create --if-not-exists --env=test
docker-compose exec app-web ./bin/console doctrine:migrations:migrate -n
docker-compose exec app-web ./bin/console doctrine:migrations:migrate -n --env=test
docker-compose exec app-web php -d memory_limit=4G vendor/bin/php-cs-fixer fix src
docker-compose exec app-web php -d memory_limit=4G vendor/bin/phpstan analyze src
docker-compose exec app-web php -d memory_limit=4G ./bin/phpunit