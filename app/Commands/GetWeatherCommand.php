<?php
declare(strict_types=1);

namespace App\Commands;

use App\Exception\WeatherException,
    GuzzleHttp\Client,
    GuzzleHttp\Exception\ClientException,
    GuzzleHttp\Psr7\Response,
    GuzzleHttp\Psr7\Stream;

class GetWeatherCommand
{   
    private Client $client;

    private string $apiUrl;

    private string $apiKey;

    private string $apiUnit;

    public function __construct(Client $client, array $apiCredentials)
    {
        $this->client = $client;

        $this->apiUrl = $apiCredentials['opMapApiUrl'].
        '?units='.$apiCredentials['opMapApiUnit'].
        '&appid='.$apiCredentials['opMapApiKey'];
    }

    public function getWeather(array $args): string
    {
        if (!isset($args[0])) {
            throw $this->throwException('Enter city name!');
        }
        try {
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
                
                return $weatherTexts . PHP_EOL;
                
            } else {
                throw $this->throwException(sprintf('Failed to get weather data for "%s".', $cityName));
            }
        } catch (Throwable $e) {
            throw $this->throwException(sprintf('Failed to get weather data for "%s".', $cityName));
        }
    }
    
    //private fn throwException($message, $code = 400) => throw new WeatherException($message, $code);

    private function throwException(string $message, int $code = 400): void
    {
        throw new WeatherException($message, $code);
    }
}
