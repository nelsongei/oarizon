<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            'create_employee',
            'update_employee'
        ];
        $displays = [
            'Create Employee',
            'Update Employee'
        ];
        foreach ($permissions as $permission) {
//            foreach ($displays as $display){
                Permission::create(['name' => $permission]);
//            }
        }
    }
}
