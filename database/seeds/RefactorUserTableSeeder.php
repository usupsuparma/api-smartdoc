<?php

use Illuminate\Database\Seeder;
use App\Modules\External\Users\Models\ExternalUserModel;


class RefactorUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = DB::connection('bijb')->table('users_copy')
                    ->join('struktur', 'users_copy.kode_struktur', '=', 'struktur.kode_struktur')
                    ->get();
                    
        foreach ($data as $dt) {
            $model = ExternalUserModel::find($dt->user_id);
            
            $model->update([
                'kode_struktur' => $dt->id,
            ]);
        }
    }
}
