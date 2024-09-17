# Run docker for dev

```sh
cp .env.example .env
cp docker/.env.dist docker/.env
docker compose -f docker/docker-compose.dev.yml build sf_cms
docker compose -f docker/docker-compose.dev.yml up -d
docker compose -f docker/docker-compose.dev.yml exec sf_cms composer install
```

## Run tests
```sh
docker compose -f docker/docker-compose.dev.yml exec sf_cms composer tests
```

# Run docker for prod

```sh
cp .env.example .env
cp docker/.env.dist docker/.env
docker compose -f docker/docker-compose.prod.yml build sf_cms
docker compose -f docker/docker-compose.prod.yml up -d
docker compose -f docker/docker-compose.prod.yml exec sf_cms composer install --no-dev
```
