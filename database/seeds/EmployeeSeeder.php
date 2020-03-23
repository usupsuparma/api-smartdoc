<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Modules\External\Employee\Models\EmployeeModel;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 50) as $i) {
            EmployeeModel::create([
                'nik' => $faker->numberBetween(1000, 9000),
                'name' => $faker->name,
            ]);
        }
    }
}
