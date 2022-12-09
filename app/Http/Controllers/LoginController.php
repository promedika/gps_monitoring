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
        $this->validate($request,[
            'phone' => 'required|numeric',
            'password'=>'required',
            
        ]);
            $phone = $request->phone;
            $password = $request->password;

            if(Auth::attempt(['phone' => $phone, 'password' => $password, 'status' => 'active',])) {
                return redirect('/');
            }else{
                return redirect()->back()->with('message', 'Login Gagal, Pastikan Phone dan password sudah benar !');
            }
    }
}
