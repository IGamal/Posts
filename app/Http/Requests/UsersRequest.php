<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "name" => 'required|min:3|max:20',
            "email" => "required|unique:users",
            "role_id" => "required",
            "is_active" => "required",
            "password" => "required|string|min:8|confirmed",
            "password_confirmation" => "required",
            "photo_path" => "required"
        ];
    }
}