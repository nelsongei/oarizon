<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Organization;
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
//        $user = User::create([
//            'name'=>'Nelson Sammy',
//            'email'=>'nelson@lixnet.net',
//            'password'=>Hash::make('secret'),
//            'organization_id'=>1
//        ]);
//        $org = Organization::create([
//            'name'=>'Oarizon',
//            'email'=>'info@oarizon.net',
//            'installation_date'=>'2020-07-04',
//            'licensed'=>100
//        ]);
//        $cur = Currency::create([
//            'name'=>'Kenyan Shilling',
//            'shortname'=>'KES',
//            'organization_id'=>1,
//        ]);
        $role = Role::create(['name'=>'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        //
        //
//        $role = Role::create(['name'=>'Admin']);
//        $permissions = Permission::pluck('id','id')->all();
//        $role->syncPermissions($permissions);
//        $user->assignRole([$role->id]);
    }
}
