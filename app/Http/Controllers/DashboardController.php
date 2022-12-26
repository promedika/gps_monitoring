<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    }
    public Function index1()
    {
        return view('index1');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
