#pull up dev environment from scratch
dev: env-file composer-install npm-install-dev use-dev-noproxyfile sail-up db-regenerate
#pull up dev environment from scratch behind proxy  -  usage make dev-proxy proxy=http://proxy.local:3128
#dev-proxy: env-file composer-install npm-install-dev-proxy use-dev-proxyfile replace-devproxy sail-up db-regenerate

# Make .env
env-file:
	cp .env.example src/.env

# Install PHP Dependencies via Composer
composer-install:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(id -u):$(id -g) \
    composer install --ignore-platform-reqs --no-scripts

# link dev Proxy Compose file
use-dev-proxyfile:
	[ -f docker-compose.yml ] && rm docker-compose.yml ; true
	ln -s docker-compose_proxy.yml docker-compose.yml

# link dev no Proxy Compose file
use-dev-noproxyfile:
	[ -f docker-compose.yml ] && rm docker-compose.yml ; true
	ln -s docker-compose_noproxy.yml docker-compose.yml

# replace proxy in dev compose file -  usage make replace-devproxy proxy=http://proxy.local:3128
replace-devproxy:
	sed -i 's|https_proxy: .*$$|https_proxy: $(proxy)|g' docker-compose_proxy.yml
	sed -i 's|http_proxy: .*$$|http_proxy: $(proxy)|g' docker-compose_proxy.yml
	sed -i 's|https_proxy .*$$|https_proxy $(proxy)|g' docker_proxy/Dockerfile
	sed -i 's|http_proxy .*$$|http_proxy $(proxy)|g' docker_proxy/Dockerfile

# Permissions - docker Dev
permissions:
	chown -R 1337:1337 storage
	find src -type f -exec chmod 664 {} \;
	find src -type d -exec chmod 775 {} \;
	chgrp -R 1337 storage bootstrap/cache
	chmod -R ug+rwx storage bootstrap/cache

# Permissions custom - usage make permissions-custom user=username group=groupname
permissions-custom:
	chown -R $(user):$(group) storage
	find src -type f -exec chmod 664 {} \;
	find src -type d -exec chmod 775 {} \;
	chgrp -R $(group) storage bootstrap/cache
	chmod -R ug+rwx storage bootstrap/cache

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

# Install JS Dependencies via NPM via entered proxy -  usage make npm-install-proxy proxy=http://proxy.local:3128
npm-install-proxy:
	docker run --rm --name js-maintainence --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:14.10 /bin/bash -ci "npm config set https-proxy $(proxy) && npm config set proxy $(proxy) && npm install --no-audit && npm run production"

# Install Dev JS Dependencies via NPM via entered proxy -  usage make npm-install-dev-proxy proxy=http://proxy.local:3128
npm-install-dev-proxy:
	docker run --rm --name js-maintainence-dev --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:14.10 /bin/bash -ci "npm config set https-proxy $(proxy) && npm config set proxy $(proxy) && npm install --no-audit && npm run dev"

# rollback all migrations (DELETES EVERYTHING!!!) and migrating and seeding database
db-regenerate:
	./vendor/laravel/sail/bin/sail artisan migrate:reset \
    && ./vendor/laravel/sail/bin/sail artisan migrate \
    && ./vendor/laravel/sail/bin/sail artisan db:seed
