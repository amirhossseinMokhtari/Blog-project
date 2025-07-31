<?php

namespace App\Http\Requests\UserRequests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Response;

class LoginRequestUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        return [
            'email' => 'required|email|exists:users',
            'password' => 'required|min:7'
        ];
    }
}
