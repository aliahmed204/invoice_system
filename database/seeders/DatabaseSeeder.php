<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    private $permissions = [
        'invoices',
        'all invoices',
        'paid invoices',
        'unpaid invoices',
        'partially invoices',
        'invoices archive',
        'restore invoice',

        'reports',
        'invoices reports',
        'users reports',

        'users',
        'users list',
        'users roles',
        'add user',
        'edit user',
        'delete user',

        'settings',
        'products',
        'add product',
        'edit product',
        'delete product',

        'sections',
        'add section',
        'edit section',
        'delete section',

        'add invoice',
        'edit invoice',
        'delete invoice',
        'export invoice',
        'invoice status',
        'add attachment',

        'permissions',
        'add permission',
        'edit permission',
        'delete permission',


    ];


    public function run(): void
    {
        // seed permissions
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create admin User and assign the role to him.
        $user = User::create([
            'name' => 'ali ahmed',
            'email' => 'ahmedali1112233445566@gmail.com',
            'password' => Hash::make('123456'),

            'roles_name'=> ["owner"],
            'status'=> 'active',
        ]);

        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $this->call([
            SectionSeeder::class,
        ]);
    }



}
