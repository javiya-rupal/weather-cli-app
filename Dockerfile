FROM php:7.4-cli

WORKDIR /usr/src/weather-app

COPY . .

CMD ./vendor/bin/phpunit --bootstrap tests/bootstrap.php tests