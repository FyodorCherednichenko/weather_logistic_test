<?php
declare(strict_types=1);

namespace App\DTOs\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleDTOValidator
{
    private function getRules(): array
    {
        return [
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:s',
            'direction' => [
                'required',
                Rule::in(['Route_1', 'Route_2', 'Route_3'])
            ]
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validate(array $data): array
    {
        return Validator::make($data, $this->getRules())->validate();
    }

}
