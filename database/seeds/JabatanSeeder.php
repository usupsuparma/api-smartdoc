<?php

use Illuminate\Database\Seeder;
use App\Modules\External\Position\Models\PositionModel;
class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 20) as $i) {
            PositionModel::create([
                'nama_jabatan' => 'Jabatan '.$i,
            ]);
        }
    }
}
