<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Role;
// use Database\Seeders\PermissionRoles;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
          //  AdminSeeder::class,
            RoleSeeder::class,
            RolesAndPermissionsSeeder::class,  
        ]);
        // $this->call([
        //     RoleSeeder::class,
        // ]);
        // $this->call([
        //     PermissionRoles::class,
        // ]);
        
    }
}
