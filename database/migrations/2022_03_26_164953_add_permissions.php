<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AddPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        
        $editUsers = Permission::create(['name' => 'edit-users']);
        $editMembers = Permission::create(['name' => 'edit-members']);
        
        $superAdmin->givePermissionTo($editUsers);
        $superAdmin->givePermissionTo($editMembers);
        $admin->givePermissionTo($editMembers);
        
        $user = User::where('email', 'pavli@live.com')->first();
        if ($user) {
            $user->assignRole('super-admin');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate roles');
        DB::statement('truncate permissions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
