<?php
declare(strict_types=1);

namespace App\SubActions;

use App\DTOs\Entities\RequestDTO;
use Illuminate\Support\Facades\DB;

class SaveRequestToDBSubAction
{

    public function execute(RequestDTO $DTO): int
    {
        return DB::table('requests')
            ->insertGetId(
                [
                    'longitude' => $DTO->longitude,
                    'latitude'  => $DTO->latitude,
                    'date'      => $DTO->date->format('Y-m-d')
                ]
            );
    }
}
