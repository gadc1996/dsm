<?php

namespace App\Http\Requests\Delay;

use Illuminate\Foundation\Http\FormRequest;

class DelayStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'task_id' => ['required', 'exists:tasks,id'],
            'description' => ['required', 'string'],
        ];
    }
}
