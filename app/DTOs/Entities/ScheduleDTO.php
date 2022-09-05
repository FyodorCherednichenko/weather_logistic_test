<?php
declare(strict_types=1);

namespace App\DTOs\Entities;

use App\DTOs\Validators\ScheduleDTOValidator;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class ScheduleDTO
{
    public string $date;
    public string $time;
    public string $direction;

    /**
     * @throws ValidationException
     */
    public function createFromArray(array $data, ScheduleDTOValidator $validator): ScheduleDTO
    {
        $data = $validator->validate($data);

        $dto = new self();

        foreach (get_class_vars($dto::class) as $key => $field) {
                $dto->{$key} = $data[$key];
        }

        return $dto;
    }
}
