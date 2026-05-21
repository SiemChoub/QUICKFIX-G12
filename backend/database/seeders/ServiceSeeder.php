<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Leak Pipe Repair',          'description' => 'Fix leaking water pipes inside walls or under sinks.',     'price' => 25.00, 'category' => 'Plumbing'],
            ['name' => 'Power Outlet Installation', 'description' => 'Install or replace electrical outlets and switches.',       'price' => 18.50, 'category' => 'Electrical'],
            ['name' => 'Deep House Cleaning',       'description' => 'Full deep clean for a 2-3 bedroom home.',                   'price' => 45.00, 'category' => 'Cleaning'],
            ['name' => 'AC Cleaning Service',       'description' => 'Cleaning of split-type air conditioning units.',            'price' => 30.00, 'category' => 'Air Conditioning'],
            ['name' => 'Wooden Door Repair',        'description' => 'Repair broken or sagging wooden doors and frames.',         'price' => 22.00, 'category' => 'Carpentry'],
            ['name' => 'Interior Wall Painting',    'description' => 'Repaint interior walls per room with provided paint.',      'price' => 55.00, 'category' => 'Painting'],
            ['name' => 'Refrigerator Repair',       'description' => 'Diagnose and repair common refrigerator faults.',           'price' => 35.00, 'category' => 'Appliance Repair'],
            ['name' => 'Cockroach Treatment',       'description' => 'Cockroach and ant chemical treatment for a full house.',    'price' => 28.00, 'category' => 'Pest Control'],
            ['name' => 'Lawn Mowing',               'description' => 'Lawn mowing and basic edging service.',                     'price' => 20.00, 'category' => 'Gardening'],
            ['name' => 'Small Apartment Moving',    'description' => 'Pack and move a studio or 1-bedroom apartment locally.',    'price' => 80.00, 'category' => 'Moving'],
        ];

        foreach ($services as $service) {
            $category = Category::firstOrCreate(
                ['name' => $service['category']],
                ['description' => $service['category'] . ' related services']
            );

            Service::create([
                'name'        => $service['name'],
                'description' => $service['description'],
                'price'       => $service['price'],
                'image'       => 'service-default.jpg',
                'category_id' => $category->id,
            ]);
        }
    }
}
