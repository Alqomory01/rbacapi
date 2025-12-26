<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; use App\Models\Permission;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = 
        [ 'create-user', 
        'view-users', 
        'update-user', 
        'delete-user' ]; 
        foreach ($permissions as $perm) { Permission::firstOrCreate(['name' => $perm]); }
        // Create roles 
        $admin = Role::firstOrCreate(['name' => 'admin']); $manager = Role::firstOrCreate(['name' => 'manager']); 
        // Attach permissions to roles 
        $admin->permissions()->sync(Permission::pluck('id')); // admin gets all 
        $manager->permissions()->sync( Permission::whereIn('name', ['view-users','update-user'])->pluck('id') );
    }
}
