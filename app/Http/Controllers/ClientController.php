<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email уже занят.']);
        }

        $user = $this->userService->register($request->validated());

        if ($user) {
            Auth::login($user);
            return redirect()->route('client.dashboard')->with('success', 'Вы успешно зарегистрировались как клиент.');
        }

        return redirect()->back()->withErrors(['registration' => 'Не удалось зарегистрировать пользователя.']);
    }
}
