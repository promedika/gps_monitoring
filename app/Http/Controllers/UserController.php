<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Stmt\Switch_;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::User()->role != 1){
        $users = User::all();
        return view('user.index', compact('users'));
        }else{
        return redirect('error.404');
        }
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

        // dd($request);
        $this->validate($request,[
            'first_name'=>'required',
            'email'=>'required|unique:users|email',
            'password'=>'required',
            'department' =>'required',
            'role'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
        ]);
        $user = new user();
        $user->first_name = $request->first_name;
        $user->last_name = isset($request->last_name) ? $request->last_name : ' ';
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
            'email'=>'required|email',
            'role'=>'required',
            'department'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
        ]);

        
        $id = $request->id;
        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = isset($request->last_name) ? $request->last_name : ' ';
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

    public function uploadUsers(Request $request)
    {
        $extension = $request->file('file')->getClientOriginalExtension();

        $ext = ['xlsx','xls'];

        if (!in_array($extension,$ext)){

            return redirect()->route('.dashboard.users.index')->with('message', 'Format file tidak sesuai !');
        }

        $tmp_path = $_FILES["file"]["tmp_name"];
        $filename = $_FILES['file']['name'];
        $target_file = storage_path('app'.DIRECTORY_SEPARATOR.$filename);

        // move file upload to storage
        move_uploaded_file($tmp_path, $target_file);
        try {
            Excel::import(new UsersImport,$target_file);
            $return = 'User Berhasil di Import !';
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            
            foreach ($failures as $failure) {
                $return = $failure->errors();
            }
            File::delete($target_file);
            
            return redirect()->route('dashboard.users.index')->with('failure', $return[0]);
        }
        File::delete($target_file);
        return redirect()->route('dashboard.users.index')->with('success', $return);
    }
}
