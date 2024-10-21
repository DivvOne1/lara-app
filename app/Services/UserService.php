<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = new User();
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->role_id = 1;
            $user->phone = $data['phone'];
            $user->save();

            return $user;
        });
    }
}
