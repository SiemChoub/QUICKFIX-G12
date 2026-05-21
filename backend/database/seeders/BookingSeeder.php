<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $types   = ['immediately', 'deadline'];
        $actions = ['request', 'progress', 'done'];

        $customers = User::where('role', 'customer')->pluck('id')->all();
        $fixers    = User::where('role', 'fixer')->pluck('id')->all();

        if (empty($customers)) {
            $customers = [1];
        }
        if (empty($fixers)) {
            $fixers = [null];
        }

        for ($i = 1; $i <= 10; $i++) {
            Booking::create([
                'booking_type_id' => $i,
                'user_id'         => $customers[array_rand($customers)],
                'type'            => $types[array_rand($types)],
                'action'          => $actions[array_rand($actions)],
                'fixer_id'        => $fixers[array_rand($fixers)],
            ]);
        }
    }
}
