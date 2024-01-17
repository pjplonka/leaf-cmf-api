dev:
	docker compose up --pull always -d --wait

test:
	php bin/phpunit