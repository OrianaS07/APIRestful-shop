<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // --- Roles ---
        $role1 = Role::create(['name' => 'Master']);
        $role2 = Role::create(['name' => 'Admin']);
        $role3 = Role::create(['name' => 'user']);
        $role4 = Role::create(['name' => 'no-user']);

        //--- Permissions ---
        /** PRODUCTS */
        Permission::create(['name' => 'products.index'])->syncRoles([$role1,$role2,$role3,$role4]);
        Permission::create(['name' => 'products.show'])->syncRoles([$role1,$role2,$role3]);

        Permission::create(['name' => 'products.buyers'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'products.categories.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'products.categories.update'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'products.categories.destroy'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'products.transactions'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'products.buyers.transactions'])->syncRoles([$role1,$role2,$role3]);

        /** TRANSACTION */
        Permission::create(['name' => 'transactions.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'transactions.show'])->syncRoles([$role1,$role2,$role3]);

        Permission::create(['name' => 'transactions.categories'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'transactions.sellers'])->syncRoles([$role1,$role2,$role3]);

        /** CATEGORY */
        Permission::create(['name' => 'categories.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'categories.store'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'categories.show'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'categories.update'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'categories.destroy'])->syncRoles([$role1,$role2,$role3]);

        Permission::create(['name' => 'categories.buyers'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'categories.sellers'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'categories.products'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'categories.transactions'])->syncRoles([$role1,$role2,$role3]);

        /** USERS */
        Permission::create(['name' => 'users.index'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'users.show'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'users.update'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$role1,$role2,$role3, $role4]);
        
        /** BUYERS */
        Permission::create(['name' => 'buyers.index'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'buyers.show'])->syncRoles([$role1,$role2,$role3, $role4]);

        Permission::create(['name' => 'buyers.sellers'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'buyers.products'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'buyers.categories'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'buyers.transactions'])->syncRoles([$role1,$role2,$role3, $role4]);

        /** SELLERS */
        Permission::create(['name' => 'sellers.index'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'sellers.show'])->syncRoles([$role1,$role2,$role3, $role4]);

        Permission::create(['name' => 'sellers.buyers'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'sellers.products.create'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'sellers.products.show'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'sellers.products.edit'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'sellers.categories'])->syncRoles([$role1,$role2,$role3, $role4]);
        Permission::create(['name' => 'sellers.transactions'])->syncRoles([$role1,$role2,$role3, $role4]);
        
    } 
}
