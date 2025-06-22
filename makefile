# Makefile
install: # установить зависимости
	composer install

validate: # проверить код на ошибки
	composer validate

brain-games: # запустить игру
	./bin/brain-games

brain-even: # запускаем игру 1 четное не четное
	./bin/brain-even

brain-calc: # запускаем игру 2 Калькулятор
	./bin/brain-calc

brain-gcd: # Запускаем игру 3 наибольший общий делитель
	./bin/brain-gcd

brain-progression: # Запускаем игру 4 прогрессия
	./bin/brain-progression

brain-prime: # Запускаем игру 5 простое число
	./bin/brain-prime

lint: # проверка кода на коректность
	composer exec --verbose phpcs -- --standard=PSR12 src bin

lint-fix: # исправление ошибок в коде
	composer exec --verbose phpcbf -- --standard=PSR12 src bin

dump: # создание дампа базы данных
	composer dump-autoload
