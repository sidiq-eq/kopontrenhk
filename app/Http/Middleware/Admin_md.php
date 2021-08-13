<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Admin_md
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $session = request()->session()->get('user');
        if($session != null){
            $data_user = DB::table('users')->where('username','=',$session)->first();
        }
        
        if($session == null){
            return abort(404);
        }elseif($data_user->level != "1"){
            return redirect()->to('logout')->with('status','Data Karyawan Telah Masuk');
        }
        return $next($request);
    }
}
