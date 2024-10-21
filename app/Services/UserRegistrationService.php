<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRegistrationService
{
    /**
     * @param array $data
     * @return array
     */
    public function registerCourier(array $data)
    {
        DB::beginTransaction();

        try {
            $existingCourier = User::where('phone', $data['phone'])
                ->where('role_id', 2)
                ->first();

            if ($existingCourier) {
                DB::rollBack();
                return ['success' => false, 'message' => 'Номер телефона уже занят курьером.'];
            }

            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => 2,
                'phone' => $data['phone'],
            ]);

            DB::commit();
            Auth::login($user);

            return ['success' => true, 'route' => 'courier.dashboard', 'message' => 'Вы успешно зарегистрировались как курьер.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'Произошла ошибка при регистрации. Пожалуйста, попробуйте еще раз.'];
        }
    }
}
