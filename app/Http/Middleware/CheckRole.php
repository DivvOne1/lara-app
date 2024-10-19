<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  int  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Получаем текущего авторизованного пользователя
        $user = $request->user();

        // Проверяем, что роль пользователя совпадает с ожидаемой ролью
        if ($user && $user->role_id == $role) {
            return $next($request);
        }

        // Если роли не совпадают, возвращаем ошибку доступа
        return redirect()->route('login')->with('error', 'У вас нет доступа к этому разделу.');
    }
}
