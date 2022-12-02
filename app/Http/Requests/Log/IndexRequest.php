<?php

namespace App\Http\Requests\Log;

use App\Enums\Date\IntervalTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => [
                'array',
                'sometimes',
            ],
            'date.*' => ['in:interval,start,end'],
            'date.interval' => [new Enum(IntervalTypes::class)],
            'date.start' => ['nullable', 'required_with:date.end'],
            'date.end' => ['nullable', 'required_with:date.start'],
        ];
    }
}
