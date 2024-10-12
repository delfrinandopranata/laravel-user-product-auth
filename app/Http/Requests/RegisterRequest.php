<?php

namespace App\Http\Requests;


class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name'     => 'required|string|max:50',
            'last_name'      => 'required|string|max:50',
            'email'         => 'required|max:255|email|unique:users',
            'password'      => 'required|confirmed',
            'date_of_birth' => 'required|date',
            'gender'        => 'required|in:male,female,other',
        ];
    }

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
     * @return array
     * Custom validation messages
     */
    public function messages()
    {
        return [
            'first_name.required'    => 'Please provide your first name',
            'first_name.max'         => 'First name cannot exceed 50 characters',
            'last_name.required'     => 'Please provide your last name',
            'last_name.max'          => 'Last name cannot exceed 50 characters',
            'email.required'         => 'Please provide your email',
            'email.unique'           => 'User already exists with this email, please try another one.',
            'password.required'      => 'Please provide your password',
            'password.confirmed'     => 'Password confirmation does not match',
            'date_of_birth.required' => 'Please provide your date of birth',
            'date_of_birth.date'     => 'Please provide a valid date of birth',
            'gender.required'        => 'Please select your gender',
            'gender.in'              => 'Gender must be one of male, female, or other',
        ];
    }
}
