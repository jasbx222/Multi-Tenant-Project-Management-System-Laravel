<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'        => 'required|string|in:new,completed,proccessing',
           'priority'  => 'required|boolean',
            'project_id'  => 'required|integer|exists:projects,id',
            'end_task' => 'date',
        ];
    }
}
