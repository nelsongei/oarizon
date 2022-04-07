<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name'=>'Nelson Sammy',
            'email'=>'nelson@lixnet.net',
            'password'=>Hash::make('secret')
        ]);
        //
//        $role  = Role::create(['name'=>'Super Administrator']);
//        $permissions = Permission::pluck('id','id')->all();
//        $role->syncPermissions($permissions);
////        $user->assignRole([$role->id]);
//        $user->assignRole([$role->id]);
        //
        $role = Role::create(['name'=>'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
