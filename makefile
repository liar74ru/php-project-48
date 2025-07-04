# Makefile

install: # установить зависимости
	composer install
	chmod +x bin/gendiff

validate: # проверить код на ошибки
	composer validate

dump: # создание дампа базы данных
	composer dump-autoload

lint: # проверка кода на коректность
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests --ignore=coverage-report/

lint-fix: # исправление ошибок в коде
	composer exec --verbose phpcbf -- --standard=PSR12 src bin tests

stan: # запуск PHPStan для статического анализа кода
	./vendor/bin/phpstan analyse -c phpstan.neon

test: # запуск тестов
	vendor/bin/phpunit --coverage-html coverage-report

test-xml: # запуск тестов с отчетом в формате XML
	vendor/bin/phpunit --coverage-clover coverage.xml