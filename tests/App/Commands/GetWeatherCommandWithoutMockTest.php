<?php
namespace Tests\App\Commands;

use App\Exception\WeatherException,
    App\Commands\GetWeatherCommand,
    GuzzleHttp\Client,
    GuzzleHttp\Handler\MockHandler,
    GuzzleHttp\HandlerStack,
    GuzzleHttp\Psr7\Response,
    PHPUnit\Framework\TestCase;
 
class GetWeatherCommandWithoutMockTest extends TestCase
{
    /** @var WeatherCommand */
    private $weatherCommand;
 
    protected function setUp(): void
    {
        $client = new Client();

        //Test credentials
        $apiCredentials['opMapApiUrl']  = $_ENV['OPEN_WEATHER_MAP_API_URL'];
        $apiCredentials['opMapApiKey']  = $_ENV['OPEN_WEATHER_MAP_API_KEY'];
        $apiCredentials['opMapApiUnit'] = $_ENV['OPEN_WEATHER_MAP_API_UNIT'];

        $this->weatherCommand = new GetWeatherCommand($client, $apiCredentials);
    }
 
    protected function tearDown(): void
    {
        $this->weatherCommand = null;
    }

    public function testShouldDisplayErrorForEmptyCitynameArgument()
    {
        $this->expectOutputString('Enter city name!');
        $this->weatherCommand->getWeather([]);
    }

    public function testShouldDisplayErrorForInvalidCitynameArgument()
    {
        $cityname = 'TESTCITY';
        $this->expectOutputString('City name does not exist!');
        $this->weatherCommand->getWeather([$cityname]);
    }

    public function testShouldReturnWeatherData()
    {  
        $cityname = 'Munich';
        $regex='/^[A-Z].*?(degrees celcius)?/s';
        $this->expectOutputRegex($regex);
        $this->weatherCommand->getWeather([$cityname]);
    }
}
