<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(DiscountSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(SettingSeeder::class);

        \App\Models\Post::factory(17)->create();
    }
}
