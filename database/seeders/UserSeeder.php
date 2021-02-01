<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['name' => "admin",'username' => "admin",'email' => "admin@gabontelecom.ga",'password' => bcrypt('admin123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);
        $user2 = User::create(['name' => "marketing01",'username' => "marketing",'email' => "marketing01@gabontelecom.ga",'password' => bcrypt('marketing123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);

        $adminrole = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $adminrole->syncPermissions($permissions);

        $user->assignRole([$adminrole->id]);
        $user2->assignRole([$adminrole->id]);
    }
}
