<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reviews')->delete();
        
        \DB::table('reviews')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'OM',
                'name' => 'Approval Surat Keluar Level Direksi',
                'status' => 1,
                'created_at' => '2020-03-30 15:18:46',
                'updated_at' => '2020-03-30 15:18:49',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'OMD',
                'name' => 'Approval Surat Keluar Level Direktur',
                'status' => 1,
                'created_at' => '2020-07-04 00:04:17',
                'updated_at' => '2020-07-04 00:04:17',
            ),
        ));
        
        
    }
}