<?php

namespace Database\Seeders;

use App\Models\Payments;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $fixers = User::where('role', 'fixer')->pluck('id')->all();
        if (empty($fixers)) {
            $fixers = [1];
        }

        $statuses = ['yes', 'no'];

        for ($i = 1; $i <= 10; $i++) {
            $amount      = rand(15, 80);
            $numberFixed = rand(1, 8);
            $total       = $amount * $numberFixed;

            $payment = new Payments();
            $payment->forceFill([
                'fixer_id'     => $fixers[array_rand($fixers)],
                'amount'       => (string) $amount,
                'number_fixed' => (string) $numberFixed,
                'total'        => (string) $total,
                'datepay'      => Carbon::now()->subDays(rand(0, 20)),
                'dateline'     => Carbon::now()->addDays(rand(1, 30)),
                'description'  => "Payment record #{$i} for completed services",
                'status'       => $statuses[array_rand($statuses)],
            ])->save();
        }
    }
}
