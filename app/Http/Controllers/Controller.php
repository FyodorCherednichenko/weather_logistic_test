<?php

namespace App\Http\Controllers;

use App\Actions\ProcessRequestAction;
use App\Actions\ProcessScheduleAction;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @throws ValidationException
     * @throws GuzzleException
     */
    public function cityWeather(Request $request, ProcessRequestAction $action): JsonResponse
    {
        return response()->json($action->execute($request));
    }

    /**
     * @throws ValidationException
     */
    public function schedule(string $date, string $time, string $direction, ProcessScheduleAction $action): JsonResponse
    {
        return response()->json($action->execute(
                [
                    'date'      => $date,
                    'time'      => $time,
                    'direction' => $direction
                ]
        ));
    }

}
