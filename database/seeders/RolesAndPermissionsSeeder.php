<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // Create roles
         $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
         $manager = Role::create(['name' => 'manager', 'guard_name' => 'web']);
         $receptionist = Role::create(['name' => 'receptionist', 'guard_name' => 'web']);
         
         // Create permissions
         Permission::create(['name' => 'create receptionists', 'guard_name' => 'web']);
         Permission::create(['name' => 'update receptionists', 'guard_name' => 'web']);
         Permission::create(['name' => 'delete receptionists', 'guard_name' => 'web']);
         // Client management permissions
         Permission::create(['name' => 'view all clients', 'guard_name' => 'web']);
         Permission::create(['name' => 'create clients', 'guard_name' => 'web']);
         Permission::create(['name' => 'update clients', 'guard_name' => 'web']);
         Permission::create(['name' => 'delete clients', 'guard_name' => 'web']);
         Permission::create(['name' => 'approve clients', 'guard_name' => 'web']);
         Permission::create(['name' => 'view own approved clients', 'guard_name' => 'web']);
         Permission::create(['name' => 'view pending clients', 'guard_name' => 'web']);
         
         // Other permissions
         Permission::create(['name' => 'manage managers', 'guard_name' => 'web']);
         Permission::create(['name' => 'manage receptionists', 'guard_name' => 'web']);
         Permission::create(['name' => 'manage all floors', 'guard_name' => 'web']);
         Permission::create(['name' => 'manage all rooms', 'guard_name' => 'web']);
         Permission::create(['name' => 'manage own receptionists', 'guard_name' => 'web']);
         Permission::create(['name' => 'manage own floors', 'guard_name' => 'web']);
         Permission::create(['name' => 'manage own rooms', 'guard_name' => 'web']);
         Permission::create(['name' => 'view client reservations', 'guard_name' => 'web']);
         Permission::create(['name' => 'make reservation', 'guard_name' => 'web']);
         
         // Assign permissions
         $admin->givePermissionTo(Permission::all());
         
         $manager->givePermissionTo([
            'create receptionists', 
            'update receptionists',
            'delete receptionists',
             'view all clients',
             'create clients',
             'update clients',
             'delete clients',
             'approve clients',
             'view own approved clients',
             'manage own receptionists',
             'manage own floors',
             'manage own rooms'
         ]);
         
         $receptionist->givePermissionTo([
             'view pending clients',
             'approve clients',
             'view own approved clients',
             'view client reservations',
             'make reservation'
         ]);
    }
}
