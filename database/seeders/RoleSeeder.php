<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name'=> 'Admin']);
        $role2 = Role::create(['name'=> 'Director']);
        $role3 = Role::create(['name'=> 'Gerente']);
        $role4 = Role::create(['name'=> 'Recepcionista']);
        $role5 = Role::create(['name'=> 'CYT']);
        $role6 = Role::create(['name'=> 'Marketing']);
        $role7 = Role::create(['name'=> 'Estilista']);
        $role8 = Role::create(['name'=> 'Auxiliar']);

        Permission::create(['name' => 'users.index'])->syncRoles([$role1, $role2, $role3]);

    }
}
