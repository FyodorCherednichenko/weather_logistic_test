<?php
declare(strict_types=1);

namespace App\Actions;

use App\DTOs\Entities\RequestDTO;
use App\DTOs\Validators\RequestDTOValidator;
use App\SubActions\GetCityWeatherSubAction;
use App\SubActions\SaveRequestToDBSubAction;
use App\SubActions\SaveResponseToDBSubAction;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class ProcessRequestAction
{
    public function __construct(
        public RequestDTO $dto,
        public RequestDTOValidator $validator,
        public GetCityWeatherSubAction $get_city_weather,
        public SaveRequestToDBSubAction $save_request_to_db,
        public SaveResponseToDBSubAction $save_response_to_db
    ) {
    }

    /**
     * @throws ValidationException|GuzzleException
     */
    public function execute(Request $request): array
    {
        $dto = $this->dto->createFromRequest($request, $this->validator);

        $request_id = $this->save_request_to_db->execute($dto);

        $response = json_decode($this->get_city_weather->execute($dto->longitude, $dto->latitude));

        $weather = [
            'main' => [
                'description' => $response->weather[0]->description,
                'wind_speed'  => $response->wind->speed,
                'temp'        => $response->main->temp,
                'feels_like'  => $response->main->feels_like,
                'temp_min'    => $response->main->temp_min,
                'temp_max'    => $response->main->temp_max,
                'pressure'    => $response->main->pressure,
                'humidity'    => $response->main->humidity
            ],
            'country'    => $response->sys->country,
            'city'       => $response->name,
        ];

        $this->save_response_to_db->execute($weather, $request_id);

        return $weather;
    }
}
