<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Modules\Test\Models\TestModel;
class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 100) as $index) {
            TestModel::create([
                'name' => $faker->name,
                'email' => $faker->freeEmail,
                'description' => $faker->text,
            ]);
        }
    }
}
