docker-compose up -d
docker-compose exec php composer install -n
docker-compose exec php composer update
docker-compose exec php ./bin/console cache:clear
#docker-compose exec php ./bin/console doctrine:schema:drop --full-database --force
docker-compose exec php ./bin/console doctrine:schema:drop --full-database --force --env=test
docker-compose exec php ./bin/console doctrine:database:create --if-not-exists
docker-compose exec php ./bin/console doctrine:database:create --if-not-exists --env=test
docker-compose exec php php -d memory_limit=-1 ./bin/console doctrine:migrations:migrate -n
docker-compose exec php php -d memory_limit=-1 ./bin/console doctrine:migrations:migrate -n --env=test
docker-compose exec php php -d memory_limit=4G vendor/bin/php-cs-fixer fix src
docker-compose exec php php -d memory_limit=4G vendor/bin/php-cs-fixer fix tests
docker-compose exec php php -d memory_limit=4G vendor/bin/phpstan analyze src
docker-compose exec php php -d memory_limit=4G vendor/bin/phpstan analyze tests
docker-compose exec php php -d memory_limit=4G ./bin/phpunit
#docker-compose exec php bin/console app:save-dog-jokes
#docker-compose exec postgres pg_dump sf_cms --table public.dog_joke --inserts --rows-per-insert=500 -a -U user > dog_jokes.sql