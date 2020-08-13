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

    public function testShouldThrowExceptionForEmptyCitynameArgument()
    {
        $this->expectException(WeatherException::class);
        $this->expectExceptionMessage('Enter city name!');
        $this->expectExceptionCode(400);
 
        $this->weatherCommand->getWeather([]);
    }

    public function testShouldThrowExceptionForInvalidCitynameArgument()
    {
        $cityname = 'TESTCITY';
 
        $this->expectException(WeatherException::class);
        $this->expectExceptionMessage('City name does not exist!');
        $this->expectExceptionCode(400);

        $this->weatherCommand->getWeather([$cityname]);
    }

    public function testShouldReturnWeatherData()
    {  
        $actualResult = $this->weatherCommand->getWeather(['Munich']);
 
        $this->assertTrue(!empty($actualResult));
        $this->assertIsString($actualResult);
        $this->assertStringEndsWith('degrees celcius' . PHP_EOL, $actualResult);
    }
}
