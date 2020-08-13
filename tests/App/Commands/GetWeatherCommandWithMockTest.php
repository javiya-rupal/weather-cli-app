<?php
declare(strict_types=1);

namespace Tests\App\Commands;

use App\Exception\WeatherException,
    App\Commands\GetWeatherCommand,
    GuzzleHttp\Client,
    GuzzleHttp\Handler\MockHandler,
    GuzzleHttp\HandlerStack,
    GuzzleHttp\Psr7\Response,
    PHPUnit\Framework\TestCase;
 
class GetWeatherCommandWithMockTest extends TestCase
{
    public function testShouldDisplayErrorForEmptyCitynameArgument()
    {
        $this->expectOutputString('Enter city name!');
        $weatherCommand = $this->getWeatherCommandObject(400);
        $weatherCommand->getWeather([]);
    }

    public function testShouldDisplayErrorForInvalidCitynameArgument()
    {
        $cityname = 'TESTCITY';
        $body = file_get_contents(__DIR__.'/Mock/CityWeather/invalid-cityname-weather-response-body.json');
        
        $this->expectOutputString('City name does not exist!');

        $weatherCommand = $this->getWeatherCommandObject(200, $body);
        $weatherCommand->getWeather([$cityname]);
    }

    public function testShouldReturnWeatherData()
    {
        $cityname = 'TESTCITY';
        $body = file_get_contents(__DIR__.'/Mock/CityWeather/weather-response-body.json');

        $this->expectOutputString('Clear sky, 28.26 degrees celcius'. PHP_EOL);

        $weatherCommand = $this->getWeatherCommandObject(200, $body);
        $weatherCommand->getWeather([$cityname]);
    }
    
    private function getWeatherCommandObject($status, $body = null)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
 
        $apiTestCredentials['opMapApiUrl']  = 'https://samples.openweathermap.org/data/2.5/find';
        $apiTestCredentials['opMapApiKey']  = '439d4b804bc8187953eb36d2a8c26a02';
        $apiTestCredentials['opMapApiUnit'] = 'metric';

        return new GetWeatherCommand($client, $apiTestCredentials);
    }
}
