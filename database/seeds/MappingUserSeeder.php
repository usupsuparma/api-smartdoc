<?php

use Illuminate\Database\Seeder;
use App\Modules\User\Models\UserModel;

class MappingUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 50) as $i) {
            $user = UserModel::findOrFail($i);
            $user->update(['user_core_id' => $i]);
        }
    }
}
