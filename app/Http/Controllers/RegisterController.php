<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    //
    public function index()
    {
        //Get Modules
        $endpoint = 'http://127.0.0.1/licensemanager/public/api/module/license';
        $data = new \GuzzleHttp\Client(['base_uri' => $endpoint]);
        $response = $data->request('GET', $endpoint);
        $modules = json_decode($response->getBody(), true);
        return view('register.index', compact('modules'));
    }

    public function store(Request $request)
    {
        $data = Http::post('http://127.0.0.1/licensemanager/public/api/v1/create/organization', [
            'fname' => $request->firstname,
            'surname' => $request->surname,
            'lname' => null,
            'cname' => $request->company_name,
            'mobno' => $request->email,
            'email' => $request->phone,
            'password' => $request->password,
            'website' => $request->website,
            'address' => $request->address,
            'module' => $request->module_id,
            'pin' => null,
            'paid_via' => $request->paid_via,
            'trxn_id' => $request->trxn_id,
        ]);
        if ($data){
            $organization = new Organization();
            $organization->name = $request->company_name;
            $organization->email = $request->email;
            $organization->website = $request->website;
            $organization->address  = $request->address;
            $organization->installation_date = date('Y-m-d');
            $organization->phone = $request->phone;
            $organization->licensed = 10;
            $organization->save();
            $orgId = $organization->id;
            $user = new User();
            $user->username = $request->firstname;
            $user->name = $request->firstname .' '.$request->surname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 'admin';
            $user->organization_id = $orgId;
            $user->save();
            //Role Assign
            //$this->roleAssign($user);
        }
        return $data;
    }
    public function roleAssign($user)
    {
        $role = Role::create(['name'=>'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
