start-local-db:
	docker compose -f docker-compose-pg.yml up -d

seed-admin:
	php artisan db:seed --class=AdminUserSeeder

build-image:
    docker compose build

up:
    docker compose up -d

down:
    docker compose down
