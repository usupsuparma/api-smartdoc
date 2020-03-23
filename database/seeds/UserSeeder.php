<?php

use Illuminate\Database\Seeder;
use App\Modules\External\Users\Models\ExternalUserModel;
use App\Modules\External\Organization\Models\OrganizationModel;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 50) as $i) {
            
            ExternalUserModel::create([
                'id_employee' => $i,
                'kode_struktur' => OrganizationModel::find($i)->kode_struktur,
                'kode_jabatan' => rand(1, 20),
                'is_active' => true,
            ]);
        }
    }
}
