<?php

namespace App\Http\Requests\Delay;

use Illuminate\Foundation\Http\FormRequest;

class DelayUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description' => ['required', 'string'],
        ];
    }
}
