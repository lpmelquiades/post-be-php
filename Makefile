vendor-install:
	docker exec -it post-be-php sh -c "composer install && composer dump-autoload"

vendor-update:
	docker exec -it post-be-php sh -c "composer update && composer dump-autoload"

test:
	docker exec -it post-be-php sh -c "cd /var/www/ && composer run test"

sh-post-be-php:
	docker exec -it post-be-php sh