<?php

use Illuminate\Database\Seeder;

class ClassDispositionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('class_disposition')->delete();
        
        \DB::table('class_disposition')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Untuk Diketahui',
                'status' => 1,
                'created_at' => '2020-03-23 13:37:09',
                'updated_at' => '2020-03-23 13:37:09',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Untuk Diselesaikan',
                'status' => 1,
                'created_at' => '2020-03-23 13:37:14',
                'updated_at' => '2020-03-23 13:37:14',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Untuk Ditindaklanjuti',
                'status' => 1,
                'created_at' => '2020-03-23 13:38:40',
                'updated_at' => '2020-03-23 13:38:40',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Untuk Diteliti & Dikaji',
                'status' => 1,
                'created_at' => '2020-03-23 13:39:01',
                'updated_at' => '2020-03-23 13:39:01',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Untuk Dipergunakan',
                'status' => 1,
                'created_at' => '2020-03-23 13:39:11',
                'updated_at' => '2020-03-23 13:39:11',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Untuk Dimonitor',
                'status' => 1,
                'created_at' => '2020-03-23 13:39:18',
                'updated_at' => '2020-03-23 13:39:18',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Untuk Dipelajari atau Saran',
                'status' => 1,
                'created_at' => '2020-03-23 13:39:35',
                'updated_at' => '2020-03-23 13:39:35',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Konsep Jawaban',
                'status' => 1,
                'created_at' => '2020-03-23 13:39:49',
                'updated_at' => '2020-03-23 13:39:49',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Siapkan Bahan',
                'status' => 1,
                'created_at' => '2020-03-23 13:40:03',
                'updated_at' => '2020-03-23 13:40:03',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Mewakili Direksi',
                'status' => 1,
                'created_at' => '2020-03-23 13:40:18',
                'updated_at' => '2020-03-23 13:40:18',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'File',
                'status' => 1,
                'created_at' => '2020-03-23 13:40:25',
                'updated_at' => '2020-03-23 13:40:25',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}