<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CourierController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        return view('courier.courier-dashboard');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showRegistrationForm()
    {
        return view('courier.register');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerСourier(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|string|unique:users,phone,NULL,id,role_id,2',
        ]);

        $existingUser = User::where('email', $validatedData['email'])->first();
        if ($existingUser) {
            return redirect()->back()->withErrors(['email' => 'Email уже занят.']);
        }

        $existingCourier = User::where('phone', $validatedData['phone'])
            ->where('role_id', 2)
            ->first();
        if ($existingCourier) {
            return redirect()->back()->withErrors(['phone' => 'Номер телефона уже занят курьером.']);
        }

        $user = new User();
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->role_id = 2; // Роль курьера
        $user->phone = $validatedData['phone'];
        $user->save();

        Auth::login($user);

        return redirect()->route('courier.dashboard')->with('success', 'Вы успешно зарегистрировались как курьер.');
    }
}
