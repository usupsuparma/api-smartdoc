<?php

use Illuminate\Database\Seeder;

class ClassificationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('classification')->delete();
        
        \DB::table('classification')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Penting',
                'status' => 1,
                'created_at' => '2020-03-12 15:49:18',
                'updated_at' => '2020-03-12 15:49:18',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Biasa',
                'status' => 1,
                'created_at' => '2020-04-18 10:51:57',
                'updated_at' => '2020-04-18 10:51:57',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Sangat Penting',
                'status' => 1,
                'created_at' => '2020-04-19 12:16:34',
                'updated_at' => '2020-04-19 12:27:48',
                'deleted_at' => '2020-04-19 12:27:48',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Sangat Penting',
                'status' => 1,
                'created_at' => '2020-04-22 09:26:38',
                'updated_at' => '2020-04-22 09:26:38',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}