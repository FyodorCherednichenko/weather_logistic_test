<?php
declare(strict_types=1);

namespace App\DTOs\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RequestDTOValidator
{
    private function getRules(): array
    {
        return [
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'date'      => 'required|date'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validate(Request $request): array
    {
        return Validator::make($request->input(), $this->getRules())->validate();
    }

}
