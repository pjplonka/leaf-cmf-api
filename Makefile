dev:
	docker compose up --pull always -d --wait

exec:
	docker compose exec -it php sh