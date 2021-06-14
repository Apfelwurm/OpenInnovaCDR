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
sail-up-deattached:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail up -d

#sail ps
sail-ps:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail ps

#sail logs
sail-logs:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail logs

#sail logs
sail-logs-follow:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail logs -f


# Install JS Dependencies via NPM
npm-install:
	docker run --rm --name js-maintainence --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:14.10 /bin/bash -ci "npm install --no-audit && npm run production"

# Install Dev JS Dependencies via NPM
npm-install-dev:
	docker run --rm --name js-maintainence-dev --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:14.10 /bin/bash -ci "npm install --no-audit && npm run dev"

# rollback all migrations (DELETES EVERYTHING!!!) and migrating and seeding database
db-regenerate:
	./vendor/laravel/sail/bin/sail artisan migrate:reset \
    && ./vendor/laravel/sail/bin/sail artisan migrate \
    && ./vendor/laravel/sail/bin/sail artisan db:seed
