# Install PHP Dependencies via Composer
composer-install:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(id -u):$(id -g) \
    composer install --ignore-platform-reqs --no-scripts

#sail shell
sail-shell:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail shell

#sail up
sail-up:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail up

#sail down
sail-down:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail down

#sail up deattached
sail-up:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail up -d

#sail ps
sail-ps:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail ps

#sail logs
sail-logss:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail logs
