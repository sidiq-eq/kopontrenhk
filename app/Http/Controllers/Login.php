<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Login extends Controller
{
    public function login(){
        $data['title'] = 'Login System';
        return view('login',$data);
    }
    public function auth(Request $request){
        $user = DB::table('users')->get();
        $username = $request->username;
        $password = $request->password;
        $cek_user = DB::table('users')->where('username','=',$username)->first();
        
        if($cek_user){
            if($password == $cek_user->password){

                if($cek_user->level==1){
                    $request->session()->put('user',$cek_user->username);
                    return redirect('beranda')->with('status','anda seorang admin')->with('alert-class','alert-success');
                }elseif($cek_user->level==2){
                    $request->session()->put('user',$cek_user->username);
                    return redirect('beranda2')->with('status','anda seorang user')->with('alert-class','alert-success');
                }elseif($cek_user->level==3){
                    
                    $request->session()->put('user',$cek_user->username);
                    
                    return redirect('beranda3')->with('status','anda seorang Manager')->with('alert-class','alert-success');
                }else{
                    $request->session()->put('user',$cek_user->username);
                    
                    return redirect('beranda4');
                }
            }
            else{
                return redirect('login')->with('status','password salah')->with('alert-class','alert-danger');
            }
        } else{
            return redirect('login')->with('status','Username tidak ditemukan')->with('alert-class','alert-danger');
        }


    }
    
    // public function logout(){

    // }
}
