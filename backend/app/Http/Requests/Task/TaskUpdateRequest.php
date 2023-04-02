<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description' => ['sometimes', 'string'],
            'completation_date' => ['sometimes', 'date'],
            'assigned_to_id' => ['sometimes', 'numeric', 'exists:users,id'],
            'is_completed' => ['sometimes', 'boolean'],
        ];
    }
}
