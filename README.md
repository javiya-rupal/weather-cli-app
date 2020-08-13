# weather-cli-app
Basic CLI API integration of gettings weather of any city.

# Installation, Configure and Run
* Clone git repository in your server.
* Create `.env` by copy from `.env.example`.
* Set API credentials and details in `.env` file.
* In Console, go to your project directory, install composer and run command `composer install`.
* Set executable permission on weather file. run command `chmod 755 weather` for that.
* Now Run the API with command `./weather London`

# Unittest
* `./vendor/bin/phpunit --bootstrap tests/bootstrap.php tests` run in console to run the unit-tests.

# Global Requisites

* php-cli (= 7.4)

# App Structure

> _Note: I am mentioning only files/folders which you need to configure if required_

```bash
├── app
│   ├── Commands
│   │   ├── GetWeatherCommand.php
│   ├── Exception
│   │   ├── WeatherException.php
│   ├── bootstrap.php
├── config
│   ├── app.php
├── tests
│   ├── App
│   │   ├── Commands
│   │   │   ├── Mock
│   │   │   │   ├── Cityweather
│   │   │   │   │   ├── invalid-cityname-weather-response-body.json
│   │   │   │   │   ├── weather-response-body.json
│   │   │   └── GetWeatherCommandWithMockTest.php
│   │   │   └── GetWeatherCommandWithoutMockTest.php
│   ├── bootstrap.php
│   ├── phpunit.xml.dist
├── .env
├── .env.example
├── .gitignore
├── composer.json
├── composer.lock
├── README.md
```
# Screens

### Weather Command

![Weather Command](/screens/weather-command.png)

### Unit-tests

![Unit-tests](/screens/command-tests.png)

## Write me if you have any queries
* Write to rupal.javiya@gmail.com
