<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function formlogin()
    {
        return view('login');
    }

    public function actionlogin(Request $request)
    {
            $email = $request->email;
            $password = $request->password;

            if(Auth::attempt(['email' => $email, 'password' => $password, 'status' => 'active',])) {
                return redirect('/');
            }else{
                return redirect()->back()->with('message', 'Login Gagal, Pastikan email dan password sudah benar !');
            }
    }
}
