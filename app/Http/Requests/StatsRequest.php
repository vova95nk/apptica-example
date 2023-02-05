<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $date
 */
class StatsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Не передана дата для выборки',
            'date.date' => 'Некорректный формат переданного значения',
        ];
    }

    public function getDate(): Carbon
    {
        return Carbon::make($this->validated('date'));
    }
}
