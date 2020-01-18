dev: docker-compose.yml docker-compose.dev.yml
	docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d

prod: docker-compose.yml docker-compose.prod.yml
	docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d

stop: docker-compose.yml docker-compose.prod.yml docker-compose.dev.yml
	docker-compose -f docker-compose.yml -f docker-compose.prod.yml -f docker-compose.dev.yml stop

redis-cli: docker-compose.yml
	docker-compose exec redis redis-cli
