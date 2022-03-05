<?php

namespace Database\Seeders;

use App\Models\CrudExample;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CrudExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $faker = \Faker\Factory::create('id_ID');
        foreach (range(1, 100) as $i) {
            array_push($data, [
                'text'             => Str::random(10),
                'number'           => $faker->numberBetween(1, 1000),
                'select'           => Str::random(10),
                'select2'          => Str::random(10),
                'select2_multiple' => Str::random(10),
                'textarea'         => $faker->text(100),
                'radio'            => Str::random(10),
                'checkbox'         => json_encode([Str::random(10), Str::random(10), Str::random(10),]),
                'file'             => $faker->imageUrl,
                'date'             => $faker->date('Y-m-d'),
                'time'             => $faker->date('H:i:s'),
                'color'            => $faker->hexColor,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
        foreach (collect($data)->chunk(20) as $chunkData) {
            // dd($chunkData);
            CrudExample::insert($chunkData->toArray());
        }
    }
}
