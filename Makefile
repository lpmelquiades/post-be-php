vendor-install:
	docker exec -it post-be-php sh -c "composer install && composer dump-autoload"

vendor-update:
	docker exec -it post-be-php sh -c "composer update && composer dump-autoload"

test:
	docker exec -it post-be-php sh -c "cd /var/www/ && composer run test"

sh-post-be-php:
	docker exec -it post-be-php sh

build-no-cache:
	docker-compose build --no-cache

up-d:
	docker-compose up -d

# Using it in the first build is enough.
init: build-no-cache up-d vendor-install



logs:
	docker-compose logs -f

vendor-clean:
	sudo rm -R vendor/*
				
coverage-clean:
	sudo rm -R tests/_output/coverage*

mongodb-volume-clean:
	sudo rm -R ~/post-be-php-volume/mongodb/* 

#prune is good way of cleaning all images builds before doing it again
prune:
	docker system prune