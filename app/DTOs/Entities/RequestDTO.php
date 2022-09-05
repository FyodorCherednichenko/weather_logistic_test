<?php
declare(strict_types=1);

namespace App\DTOs\Entities;

use App\DTOs\Validators\RequestDTOValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RequestDTO
{
    public float $latitude;
    public float $longitude;
    public Carbon $date;

    /**
     * @throws ValidationException
     */
    public function createFromRequest(Request $request, RequestDTOValidator $validator): RequestDTO
    {
        return self::createFromArray($validator->validate($request));
    }

    public static function createFromArray(array $data): self
    {
        $dto = new self();

        foreach (get_class_vars($dto::class) as $key => $field) {
            if ($key === 'date') {
                $dto->{$key} = new Carbon($data[$key]);
            } else {
                $dto->{$key} = (float) $data[$key];
            }
        }

        return $dto;
    }
}
