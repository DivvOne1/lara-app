<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class LockService
{
    /**
     * @param $phone
     * @return bool
     */
    public function acquireLock($phone)
    {
        return Cache::add('phone_'.$phone, true, 600);
    }

    /**
     * @param $phone
     * @return void
     */
    public function releaseLock($phone)
    {
        Cache::forget('phone_'.$phone);
    }
}

