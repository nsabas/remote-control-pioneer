
up:
	docker-compose up -d

install_composer_dependencies:
	composer install --no-interaction

install_node_dependencies:
	yarn install

webpack_compile:
	yarn dev

setup: install_composer_dependencies install_node_dependencies webpack_compile
