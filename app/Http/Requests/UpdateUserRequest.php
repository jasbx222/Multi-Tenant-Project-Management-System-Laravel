<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // غيّرها حسب الصلاحيات إذا تحب
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255'],
            'password' => ['string', 'min:8', 'confirmed'],
            'role'=>['string','in:owner|member|manager']
        ];
    }
    
}
