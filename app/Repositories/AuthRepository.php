<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function register(array $data): User
    {
        // Update the data array to use first_name, last_name, date_of_birth, and gender
        $data = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
        ];

        return User::create($data);
    }
}
