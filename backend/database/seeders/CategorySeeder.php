<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Plumbing',          'description' => 'Pipe repair, leak fixing and water system services'],
            ['name' => 'Electrical',        'description' => 'Wiring, outlets and electrical installation services'],
            ['name' => 'Cleaning',          'description' => 'Home and office cleaning services'],
            ['name' => 'Air Conditioning',  'description' => 'AC installation, cleaning and repair'],
            ['name' => 'Carpentry',         'description' => 'Furniture repair and woodworking services'],
            ['name' => 'Painting',          'description' => 'Interior and exterior painting services'],
            ['name' => 'Appliance Repair',  'description' => 'Refrigerator, washing machine and home appliance repair'],
            ['name' => 'Pest Control',      'description' => 'Insect, rodent and pest removal services'],
            ['name' => 'Gardening',         'description' => 'Lawn care, planting and landscape services'],
            ['name' => 'Moving',            'description' => 'House and office moving and delivery services'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
