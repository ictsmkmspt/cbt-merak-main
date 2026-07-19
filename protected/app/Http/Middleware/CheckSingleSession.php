<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class CheckSingleSession
{
    /**
     * Pastikan token sesi di browser ini masih sama dengan token
     * terbaru yang tersimpan di database untuk user ini.
     * Kalau beda, berarti akun sudah login dari perangkat/browser lain.
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionToken = Session::get('current_token');

            if ($sessionToken !== null && $user->current_token !== $sessionToken) {
                Auth::logout();
                Session::flush();

                if ($request->ajax()) {
                    return response()->json(['status' => 'logout_paksa'], 401);
                }

                return redirect('auth/login')->with('pesan_logout', 'Akun Anda terdeteksi login di perangkat/browser lain. Demi keamanan ujian, sesi ini dikeluarkan secara otomatis.');
            }
        }

        return $next($request);
    }
}
