<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        return view('client.dashboard');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showRegistrationForm()
    {
        return view('client.register');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|string',
        ]);

        $existingUser = User::where('email', $validatedData['email'])->first();
        if ($existingUser) {
            return redirect()->back()->withErrors(['email' => 'Email уже занят.']);
        }

        DB::transaction(function () use ($validatedData) {
            $user = new User();
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->role_id = 1; // Роль клиента
            $user->phone = $validatedData['phone'];
            $user->save();
        });

        return redirect()->route('client.dashboard')->with('success', 'Вы успешно зарегистрировались как клиент.');
    }
}
