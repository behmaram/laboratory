<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        $roles = [
            ['name' => 'admin', 'guard_name' => 'api'],
            ['name' => 'user', 'guard_name' => 'api'],
            ['name' => 'nurse', 'guard_name' => 'api'],
        ];
        Role::insert($roles);
    }
}
