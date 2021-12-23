# README #

Тестирование производительности nodejs и php8

assync-nodejs - ассинхронное тестирование на работу с базой. Фреймворк - express\
assync-php    - ассинхронное тестирование на работу с базой. Библиотека - amphp\
operations-php-and-nodejs - тестирование на операциях + запись в файл. Php vs Nodejs. Без библиотек. (cluster для Nodejs 
исключительно для собственного любопытства)

p.s. Итоговый результат\
php7.1 nodejs быстрее процентов на 20-30 (тестировались только операции)\
php7.4 примерно такой же как nodejs, в некоторых местах чуть быстрее (тестировались только операции)\
php8 по всем параметрам обходит nodejs (операции и асинхронные тесты)

Тесты проводились как с включенным fpm, так и выключенным