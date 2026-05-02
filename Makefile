start-local-db:
	docker compose -f docker-compose-pg.yml up -d

seed-admin:
	php artisan db:seed --class=AdminUserSeeder
