<?php
declare(strict_types=1);

namespace Config\App;

/**
 * This class defines all values related to configurations required in project
 */
class AppConfig {
    /**
     * Get all configuration values.
     * @return array
     */
    public static function getApiCredentials(): array
    {
        $apiCredentials['opMapApiUrl']  = $_ENV['OPEN_WEATHER_MAP_API_URL'];
        $apiCredentials['opMapApiKey']  = $_ENV['OPEN_WEATHER_MAP_API_KEY'];
        $apiCredentials['opMapApiUnit'] = $_ENV['OPEN_WEATHER_MAP_API_UNIT'];
        
        return $apiCredentials;
    }
}