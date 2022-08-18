<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class RegisterRequest extends FormRequest
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
       // $emailRule = Rule::unique((new User)->getTable());
        $emailRule = Rule::unique('users')->where(fn ($query) => $query->where('mobile', $request->mobile));

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'mobile' => 'required|min:10|max:10|unique:users',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'profile_photo' => 'required|image|mimes:jpg,png|max:2048',
            'document' => 'required|mimes:png,jpg,xls,pdf|max:2048',
        ];
    }
}
