<?php
declare(strict_types=1);

namespace App\Commands;

use App\Exception\WeatherException,
    GuzzleHttp\Client,
    GuzzleHttp\Exception\ClientException,
    GuzzleHttp\Psr7\Response,
    GuzzleHttp\Psr7\Stream;

/**
 * GetWeatherCommand
 * 
 * @package    Commands
 * @author     Rupal Javiya <rupal.javiya@gmail.com>
 */
class GetWeatherCommand
{   
    /**
     * Client Object for http curl request
     *
     * @var Client
     */
    private Client $client;

    /**
     * Full URL for getting weather from third party weather API
     *
     * @var string
     */
    private string $apiUrl;

    /**
     * Class constructor
     * 
     * @param Client $client client object for http call
     * @param array $apiCredentials Weather API credentials
     */
    public function __construct(Client $client, array $apiCredentials)
    {
        $this->client = $client;

        $this->apiUrl = $apiCredentials['opMapApiUrl'].
        '?units='.$apiCredentials['opMapApiUnit'].
        '&appid='.$apiCredentials['opMapApiKey'];
    }

    /**
     * Get weather of given location.
     *
     * @param array $args cityname parameter passed as argument in command
     */
    public function getWeather(array $args): void
    {
        try {
            if (!isset($args[0])) {
                throw $this->throwException('Enter city name!');
            }

            $cityName = $args[0];
            
            //Weather API integration
            $response = $this->client->request('GET', $this->apiUrl.'&q='.$cityName);

            if ($response->getStatusCode() === 200) {
                $weatherData = json_decode((string)$response->getBody(), true);
                
                if (count($weatherData['list']) === 0) {
                    throw $this->throwException('City name does not exist!');
                }

                $weatherTexts = ucfirst($weatherData['list'][0]['weather']['0']['description']). 
                ', ' . $weatherData['list'][0]['main']['temp'] .' degrees celcius';
                
                echo $weatherTexts . PHP_EOL;
                
            } else {
                throw $this->throwException(sprintf('Failed to get weather data for "%s".', $cityName));
            }
        } catch (WeatherException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Handle exception
     *
     * @param string $message exception message
     * @param int $code http return code 
     */
    private function throwException(string $message, int $code = 400): void
    {
        throw new WeatherException($message, $code);
    }
}
