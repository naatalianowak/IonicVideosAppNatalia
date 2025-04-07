<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        if (!Role::where('name', 'Super Admin')->exists()) {
            Role::create(['name' => 'Super Admin']);
        }

        if (!Role::where('name', 'Video Manager')->exists()) {
            Role::create(['name' => 'Video Manager']);
        }

        if (!Role::where('name', 'Regular')->exists()) {
            Role::create(['name' => 'Regular']);
        }
    }
}
