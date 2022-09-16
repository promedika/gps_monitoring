<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
            'departement' =>'required',
            'role'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
        ]);
        $user = new user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->department = $request->department;
        $user->role = $request->role;
        $user->start_date = $request->start_date;
        $user->end_date = $request->end_date;
        $user->created_by = Auth::User()->id;
        $user->updated_by = Auth::User()->id;
        $user->status = 'active';
        $user->save();

        return redirect(route('dashboard.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        return response()->json(['data' => $user]);
        return redirect(route('dashboard.users.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'role'=>'required',
            'department'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
        ]);
        $id = $request->id;
        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if($request->password !='' && strlen(trim($request->password)) > 0){
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->department = $request->department;
        $user->start_date = $request->start_date;
        $user->end_date = $request->end_date;
        $user->updated_by = Auth::User()->id;
        $user->status = $request->status;
        $user->save();
        return redirect(route('dashboard.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        $user->delete();
        return $user;

        return view('user.index', compact('users'));
    }

    public function editPassword(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        return response()->json(['data' => $user]);
        return redirect(route('dashboard.users.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        if($request->password !='' && strlen(trim($request->password)) > 0){
            $user->password = Hash::make($request->password);
        }
        $user->updated_by = Auth::User()->id;
        $user->save();
        return redirect(route('dashboard.users.index'));
    }
}
