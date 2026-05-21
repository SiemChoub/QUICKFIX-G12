<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'Booking access',
            'Booking create',
            'Booking edit',
            'Booking delete',
            'Promotion access',
            'Promotion create',
            'Promotion edit',
            'Promotion delete',
            'Dashboard view',
            'Report export',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }
    }
}
