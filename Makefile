# pull up dev environment from scratch
dev: env-file-dev composer-install npm-install-dev use-dev-noproxyfile permissions key-generate sail-up-deattached db-regenerate

#pull up dev environment from scratch behind proxy  -  usage make dev-proxy proxy=http://proxy.local:3128
dev-proxy: env-file composer-install-proxy npm-install-dev-proxy use-dev-proxyfile permissions replace-devproxy key-generate sail-up-deattached db-regenerate

#pull up prd environment from scratch (please use make env-file-prd and edit your .env file, then run this!)
prd: composer-install npm-install use-prd-noproxyfile replace-prdproxy key-generate prd-up

#pull up prd environment from scratch (please use make env-file-prd and edit your .env file, then run this!) behind proxy
#usage make prd-proxy proxy=http://proxy.local:3128
prd-proxy: composer-install-proxy npm-install-proxy use-prd-proxyfile replace-prdproxy key-generate prd-up

# Make .env
env-file-dev:
	cp .env.dev.example .env

# Make .env
env-file-prd:
	cp .env.prd.example .env


# Install PHP Dependencies via Composer
composer-install:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(id -u):$(id -g) \
    composer install --ignore-platform-reqs --no-scripts

# Install PHP Dependencies via Composer via proxy -  usage make composer-install-proxy proxy=http://proxy.local:3128
composer-install-proxy:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    -e https_proxy=$(proxy) -e http_proxy=$(proxy) \
    --user $(id -u):$(id -g) \
    composer install --ignore-platform-reqs --no-scripts

# require PHP Dependencies via Composer usage make composer-require module=modulename
composer-require:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(id -u):$(id -g) composer require $(module) --ignore-platform-reqs --no-scripts

# require PHP Dependencies via Composer usage make composer-require module=modulename proxy=http://proxy.local:3128
composer-require-proxy:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    -e https_proxy=$(proxy) -e http_proxy=$(proxy) \
    --user $(id -u):$(id -g) composer require $(module) --ignore-platform-reqs --no-scripts

# link dev Proxy Compose file
use-dev-proxyfile:
	[ -f docker-compose.yml ] && rm docker-compose.yml ; true
	ln -s docker-compose_proxy.yml docker-compose.yml

# link dev no Proxy Compose file
use-dev-noproxyfile:
	[ -f docker-compose.yml ] && rm docker-compose.yml ; true
	ln -s docker-compose_noproxy.yml docker-compose.yml


# link prd Proxy Compose file
use-prd-proxyfile:
	[ -f docker-compose.yml ] && rm docker-compose.yml ; true
	ln -s docker-compose_prd_proxy.yml docker-compose.yml

# link prd no Proxy Compose file
use-prd-noproxyfile:
	[ -f docker-compose.yml ] && rm docker-compose.yml ; true
	ln -s docker-compose_prd_noproxy.yml docker-compose.yml

# replace proxy in dev compose file -  usage make replace-devproxy proxy=http://proxy.local:3128
replace-devproxy:
	sed -i 's|https_proxy: .*$$|https_proxy: $(proxy)|g' docker-compose_proxy.yml
	sed -i 's|http_proxy: .*$$|http_proxy: $(proxy)|g' docker-compose_proxy.yml
	sed -i 's|https_proxy .*$$|https_proxy $(proxy)|g' docker_proxy/Dockerfile
	sed -i 's|http_proxy .*$$|http_proxy $(proxy)|g' docker_proxy/Dockerfile

# replace proxy in dev compose file -  usage make replace-devproxy proxy=http://proxy.local:3128
replace-prdproxy:
	sed -i 's|https_proxy: .*$$|https_proxy: $(proxy)|g' docker-compose_prd_proxy.yml
	sed -i 's|http_proxy: .*$$|http_proxy: $(proxy)|g' docker-compose_prd_proxy.yml
	sed -i 's|https_proxy .*$$|https_proxy $(proxy)|g' docker_prd_proxy/Dockerfile
	sed -i 's|http_proxy .*$$|http_proxy $(proxy)|g' docker_prd_proxy/Dockerfile

# Permissions - docker Dev
permissions:
	chown -R 1000:1000 storage bootstrap/cache
	chown -R 1000:1000 .env
	chgrp -R 1000 storage bootstrap/cache
	chmod -R ug+rwx storage bootstrap/cache

# Permissions custom - usage make permissions-custom user=username group=groupname
permissions-custom:
	chown -R $(user):$(group) storage bootstrap/cache
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

#sail command - usage make sail-command command="artisan migrate"
sail-command:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail $(command)


prd-up:
	docker-compose up -d --build

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

show-requestlog-prd:
	docker-compose exec -T openinnovacdr /bin/sh -c "cat storage/app/innovaphonerequestlog.txt"

show-laravellog-prd:
	docker-compose exec -T openinnovacdr /bin/sh -c "cat storage/logs/laravel.log"

follow-requestlog-prd:
	docker-compose exec -T openinnovacdr /bin/sh -c "tail -f storage/app/innovaphonerequestlog.txt"

follow-laravellog-prd:
	docker-compose exec -T openinnovacdr /bin/sh -c "tail -f storage/logs/laravel.log"

#generate  key:
key-generate:
	docker run --rm --name composer key generate --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(id -u):$(id -g) php:8-fpm-alpine /bin/sh -c "cd /app && php artisan key:generate"

# Build docs container
docs-build:
	docker pull sphinxdoc/sphinx:latest
	docker build -t openinnovacdr_docs docs
# Make Documentation
docs-html:
	docker run --rm -v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/docs:/docs openinnovacdr_docs make html

