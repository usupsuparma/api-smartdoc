<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 4,
                'name' => 'Administrator 2',
                'categories' => 'admin',
                'publisher' => 0,
                'status' => 1,
                'created_at' => '2020-03-09 20:41:09',
                'updated_at' => '2020-06-29 08:32:21',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 5,
                'name' => 'Administrator',
                'categories' => 'admin',
                'publisher' => 0,
                'status' => 1,
                'created_at' => '2020-03-10 08:47:08',
                'updated_at' => '2020-06-29 08:32:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 10,
                'name' => 'Staff Drafter',
                'categories' => 'management',
                'publisher' => 0,
                'status' => 1,
                'created_at' => '2020-06-29 08:34:06',
                'updated_at' => '2020-06-29 08:34:06',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 11,
                'name' => 'VP / Manager / Pit. Manager / Ass. Manager',
                'categories' => 'management',
                'publisher' => 0,
                'status' => 1,
                'created_at' => '2020-06-29 08:37:13',
                'updated_at' => '2020-06-29 19:05:04',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 12,
                'name' => 'Direksi',
                'categories' => 'management',
                'publisher' => 0,
                'status' => 1,
                'created_at' => '2020-06-29 08:41:40',
                'updated_at' => '2020-06-29 19:05:20',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 13,
                'name' => 'Direktur Utama',
                'categories' => 'management',
                'publisher' => 0,
                'status' => 1,
                'created_at' => '2020-06-29 08:43:58',
                'updated_at' => '2020-06-29 08:43:58',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 14,
                'name' => 'Admin Surat',
                'categories' => 'admin',
                'publisher' => 1,
                'status' => 1,
                'created_at' => '2020-06-29 08:46:38',
                'updated_at' => '2020-07-13 15:11:31',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}