<?php
namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePelangganDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        foreach (range(1, 100) as $index) {
            DB::table('pelanggan')->insert([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'birthday'   => $faker->date('Y-m-d', '2005-12-31'),
                'gender'     => $faker->randomElement(['Male', 'Female', 'Other']),
                'email'      => $faker->unique()->safeEmail,
                'phone'      => $faker->phoneNumber,
            ]);
        }
    }
}
