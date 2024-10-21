<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserRegistrationService;
use App\Services\LockService;

class CourierController extends Controller
{
    protected $registrationService;
    protected $lockService;

    /**
     * @param UserRegistrationService $registrationService
     * @param LockService $lockService
     */
    public function __construct(UserRegistrationService $registrationService, LockService $lockService)
    {
        $this->registrationService = $registrationService;
        $this->lockService = $lockService;
    }

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
    public function registerCourier(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|string|unique:users,phone,NULL,id,role_id,2',
        ]);

        $lock = $this->lockService->acquireLock($validatedData['phone']);
        if (!$lock) {
            return redirect()->back()->withErrors(['phone' => 'Номер телефона в данный момент недоступен. Пожалуйста, попробуйте позже.']);
        }

        $result = $this->registrationService->registerCourier($validatedData);

        $this->lockService->releaseLock($validatedData['phone']);

        if ($result['success']) {
            return redirect()->route($result['route'])->with('success', $result['message']);
        }

        return redirect()->back()->withErrors(['phone' => $result['message']]);
    }
}

