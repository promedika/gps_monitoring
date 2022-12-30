<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public Function index()
    {
        return view('index');
       // dd(Auth::User()->department);
        //if (Auth::User()->department != 0 || Auth::User()->department != 1 ||  Auth::User()->department != 6) {
          //  return view('index');
       // }
       // if (Auth::User()->department == 2 || Auth::User()->department == 3 || Auth::User()->department == 4 || Auth::User()->department == 5) {
          //  return view('index1');
       // }
    }



    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('login'));
    }
}