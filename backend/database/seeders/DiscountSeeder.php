<?php

namespace Database\Seeders;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        $discounts = [
            ['discount' => '5',  'description' => 'New customer welcome discount'],
            ['discount' => '10', 'description' => 'Khmer New Year promotion'],
            ['discount' => '15', 'description' => 'Pchum Ben holiday promotion'],
            ['discount' => '20', 'description' => 'Independence Day special'],
            ['discount' => '25', 'description' => 'Water Festival discount'],
            ['discount' => '30', 'description' => 'End of year clearance'],
            ['discount' => '7',  'description' => 'Loyalty member discount'],
            ['discount' => '12', 'description' => 'Weekend booking discount'],
            ['discount' => '18', 'description' => 'Refer-a-friend reward'],
            ['discount' => '50', 'description' => 'Flash sale 24-hour deal'],
        ];

        foreach ($discounts as $i => $data) {
            Discount::create([
                'discount'    => $data['discount'],
                'description' => $data['description'],
                'start_date'  => Carbon::now()->subDays(5),
                'end_date'    => Carbon::now()->addDays(30 + $i),
            ]);
        }
    }
}
