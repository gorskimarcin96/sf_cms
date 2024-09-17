# Run project

## Copy .env file
```sh
cp docker/.env.dist docker/.env
```

## Create network and run nginx proxy manager
```sh
docker network create nginx
docker-compose -f docker/docker-compose.nginx.yml up -d
```

## Run dev
```sh
docker-compose -f docker/docker-compose.dev.yml up -d
docker-compose -f docker/docker-compose.dev.yml exec app composer install
```

## Run prod
```sh
docker-compose -f docker/docker-compose.prod.yml up -d
docker-compose -f docker/docker-compose.prod.yml exec app composer install --no-dev
```

### Run tests
```sh
docker-compose -f docker/docker-compose.dev.yml exec app composer tests
```

### Stop all dockers
```sh
docker-compose -f docker/docker-compose.nginx.yml
docker-compose -f docker/docker-compose.dev.yml
docker-compose -f docker/docker-compose.prod.yml
```
