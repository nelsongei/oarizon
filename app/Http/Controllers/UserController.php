<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $roles= Role::pluck('name','name')->all();
        $users = User::where('organization_id', Auth::user()->organization_id)->orderBy('id','desc')->simplePaginate(5);
        return view('admin.index',compact('users','roles'))->with('i',($request->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles= Role::pluck('name','name')->all();
        return view('admin.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:users,email|email',
            'password'=>'required|same:confirm-password',
            'roles'=>'required'
        ]);
        $input =$request->all();

        $input['password']=Hash::make($input['password']);
        $input['organization_id'] = 1;
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        $update = User::findOrFail($user->id);
        $update->organization_id = 1;
        $update->push();
        return  redirect()->route('users.index')->with('success','User Created');
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
    public function edit($id)
    {
        //
        $roles= Role::pluck('name','name')->all();
        return view('admin.edit',compact('roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::where('id',$id)->findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->assignRole($request->input('roles'));
        $user->push();
        return  redirect()->route('users.index')->with('success','User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
