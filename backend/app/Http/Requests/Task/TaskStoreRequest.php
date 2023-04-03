<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{

    public function prepareForValidation()
    {
        $this->merge([
            'created_by_id' => auth()->user()->id
        ]);
    }

    public function rules()
    {
        return [
            'description' => ['required', 'string'],
            'completation_date' => ['required', 'date'],
            'created_by_id' => ['required', 'numeric', 'exists:users,id'],
            'assigned_to_id' => ['required', 'numeric', 'exists:users,id'],
        ];
    }
}
