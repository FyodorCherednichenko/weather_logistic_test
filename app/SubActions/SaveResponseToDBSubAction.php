<?php
declare(strict_types=1);

namespace App\SubActions;

use Illuminate\Support\Facades\DB;

class SaveResponseToDBSubAction
{
    public function execute(array $weather, int $request_id): bool
    {
        return DB::table('responses')->insert(
            [
                'request_id' => $request_id,
                'weather'    => json_encode($weather)
            ]
        );
    }
}
