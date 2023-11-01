<?php

namespace App\Http\Middleware;

use App\Models\Semester;
use Closure;
use Illuminate\Http\Request;

class SetSemester
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Semester untuk uji coba
        $semester = '231';

        // Jika sudah production, maka ambil dari tabel v_smt
        if (config('app.env') == 'production') {
            $semester = Semester::where('fak_id', '41010')->first()->smt_yad;
        }

        session(['semester' => $semester]);

        return $next($request);
    }
}
