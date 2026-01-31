<?php

namespace Database\Seeders;

use App\Models\Land;
use Illuminate\Database\Seeder;

class LandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample lands
        $landTypes = ['residential', 'commercial', 'industrial'];
        $landNames = [
            'أرض سكنية جميلة',
            'قطعة أرض تجارية',
            'أرض صناعية',
            'أرض زراعية',
            'قطعة أرض استثمارية',
            'أرض سكنية فاخرة',
            'أرض تجارية ممتازة',
            'أرض صناعية كبيرة',
        ];

        $landIndex = 0;
        for ($y = 0; $y < 10; $y++) {
            for ($x = 0; $x < 10; $x++) {
                // Create land for about 30% of the grid
                if (rand(1, 100) <= 30) {
                    Land::create([
                        'name' => $landNames[$landIndex % count($landNames)] . ' ' . ($landIndex + 1),
                        'description' => 'أرض ممتازة في موقع استراتيجي',
                        'price' => rand(10000, 100000),
                        'x' => $x,
                        'y' => $y,
                        'owner_id' => null,
                        'is_available' => rand(1, 100) <= 70, // 70% available
                        'type' => $landTypes[array_rand($landTypes)],
                        'size' => rand(50, 500),
                    ]);
                    $landIndex++;
                }
            }
        }
    }
}
