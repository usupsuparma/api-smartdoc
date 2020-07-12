<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('types')->delete();
        
        \DB::table('types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'SE',
                'name' => 'Surat Edaran',
                'status' => 1,
                'created_at' => '2020-03-21 21:43:32',
                'updated_at' => '2020-03-21 21:43:32',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'SKT',
                'name' => 'Surat Keterangan',
                'status' => 1,
                'created_at' => '2020-03-21 21:44:04',
                'updated_at' => '2020-03-21 21:44:04',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'SPG',
                'name' => 'Surat Pengantar',
                'status' => 1,
                'created_at' => '2020-03-21 21:44:25',
                'updated_at' => '2020-03-21 21:44:25',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'SPY',
                'name' => 'Surat Pernyataan',
                'status' => 1,
                'created_at' => '2020-03-21 21:44:58',
                'updated_at' => '2020-03-21 21:44:58',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'ST',
                'name' => 'Surat Teguran',
                'status' => 1,
                'created_at' => '2020-03-21 21:45:11',
                'updated_at' => '2020-03-21 21:45:11',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'STG',
                'name' => 'Surat Tugas',
                'status' => 1,
                'created_at' => '2020-03-21 21:45:21',
                'updated_at' => '2020-03-21 21:45:21',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'SL',
                'name' => 'Surat Resmi Lainnya',
                'status' => 1,
                'created_at' => '2020-03-21 21:45:34',
                'updated_at' => '2020-03-21 21:45:34',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'SKS',
                'name' => 'Surat Kuasa',
                'status' => 1,
                'created_at' => '2020-04-19 12:48:17',
                'updated_at' => '2020-04-19 12:48:17',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'SP',
                'name' => 'Surat Peringatan',
                'status' => 1,
                'created_at' => '2020-04-25 15:21:14',
                'updated_at' => '2020-04-25 15:21:14',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'ND',
                'name' => 'Nota Dinas',
                'status' => 1,
                'created_at' => '2020-04-30 16:32:47',
                'updated_at' => '2020-04-30 16:32:47',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}