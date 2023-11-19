<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $roles=[
          "admin",
          "accountant",
          "reception" ,
          "teacher"
        ];
        foreach ($roles as $role){
            Role::create(['name'=>$role]);
        }
         $admin=User::create([
            "name"=>"management_center",
            "email"=>"trainingCenter@gmail.com",
            "phone"=>"0999999999",
            "password"=>Hash::make("123123")
        ]);

        $admin->assignRole("admin");
    }
}
