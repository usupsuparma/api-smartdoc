<?php

use Illuminate\Database\Seeder;

class ExternalPositionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('external_positions')->delete();
        
        \DB::table('external_positions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_jabatan' => 'Direktur Utama',
                'status' => 1,
                'created_at' => '2020-08-31 16:33:49',
                'updated_at' => '2020-08-31 16:33:49',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nama_jabatan' => 'Direktur',
                'status' => 1,
                'created_at' => '2020-08-31 16:34:33',
                'updated_at' => '2020-08-31 16:34:33',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nama_jabatan' => 'Komisaris',
                'status' => 1,
                'created_at' => '2020-08-31 16:35:06',
                'updated_at' => '2020-08-31 16:35:06',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'nama_jabatan' => 'Vice Precident',
                'status' => 1,
                'created_at' => '2020-08-31 16:35:25',
                'updated_at' => '2020-08-31 16:35:25',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'nama_jabatan' => 'Manager',
                'status' => 1,
                'created_at' => '2020-08-31 16:35:34',
                'updated_at' => '2020-08-31 16:35:34',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'nama_jabatan' => 'Plt Manager',
                'status' => 1,
                'created_at' => '2020-08-31 16:35:40',
                'updated_at' => '2020-08-31 16:35:40',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'nama_jabatan' => 'Staff',
                'status' => 1,
                'created_at' => '2020-08-31 16:35:48',
                'updated_at' => '2020-08-31 16:35:48',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'nama_jabatan' => 'Pelaksana Khusus',
                'status' => 1,
                'created_at' => '2020-08-31 16:36:01',
                'updated_at' => '2020-08-31 16:36:01',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'nama_jabatan' => 'Assistant Manager',
                'status' => 1,
                'created_at' => '2020-08-31 16:36:10',
                'updated_at' => '2020-08-31 16:36:10',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'nama_jabatan' => 'Plt Assistant Manager',
                'status' => 1,
                'created_at' => '2020-08-31 16:36:21',
                'updated_at' => '2020-08-31 16:36:21',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'nama_jabatan' => 'Non Staff',
                'status' => 1,
                'created_at' => '2020-08-31 16:36:30',
                'updated_at' => '2020-08-31 16:36:30',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}