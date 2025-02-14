build:
	docker compose build

dev:
	docker compose up --pull always -d --wait

up:
	docker compose up -d

exec:
	docker compose exec -it php sh

test\:init:
	bin/console doctrine:database:drop --env=test --force || true
	bin/console doctrine:database:create --env=test || true
	bin/console doctrine:schema:create  --env=test || true

test\:run:
	php bin/phpunit