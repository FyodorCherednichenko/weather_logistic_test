<?php
declare(strict_types=1);

namespace App\SubActions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GetCityWeatherSubAction
{
    /**
     * @throws GuzzleException
     */
    public function execute(float $longitude, float $latitude): string
    {
        $client = new Client();
        $api_key = env('WEATHER_API_KEY');

        return $client->get(
            "https://api.openweathermap.org/data/2.5/weather?lat={$latitude}&lon={$longitude}&appid={$api_key}"
        )->getBody()->getContents();
    }
}
