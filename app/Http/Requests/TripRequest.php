<?php

declare(strict_types=1);

namespace App\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'car_id' => 'required|integer',
            'miles' => 'required|numeric',
        ];
    }

    public function getValidatorInstance()
    {
        $this->formatDate();

        return parent::getValidatorInstance();
    }

    protected function formatDate(): void
    {
        if ($this->request->has('date')) {
            $date = new DateTimeImmutable($this->request->get('date'));

            $this->merge([
                'date' => $date->format('Y-m-d'),
            ]);
        }
    }
}
