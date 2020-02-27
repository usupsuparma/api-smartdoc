<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Modules\User\Models\UserModel;

class BackdoorSeeder extends Seeder
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
            UserModel::create([
                'email' => $faker->safeEmail,
                'username' => $faker->userName,
                'password' => app('hash')->make('hello'),
                'status' => true,
            ]);
        }
    }
}
