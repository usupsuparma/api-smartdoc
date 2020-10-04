<?php

use Illuminate\Database\Seeder;

class MappingStructureTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mapping_structure')->delete();
        
        \DB::table('mapping_structure')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'MS001',
                'name' => 'Direktur',
                'primary_top_level_id' => 1,
                'secondary_top_level_id' => NULL,
                'status' => 1,
                'created_at' => '2020-05-07 12:45:46',
                'updated_at' => '2020-05-08 00:52:40',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'MS002',
                'name' => 'Direksi',
                'primary_top_level_id' => 2,
                'secondary_top_level_id' => NULL,
                'status' => 1,
                'created_at' => '2020-05-07 12:45:46',
                'updated_at' => '2020-05-08 21:13:03',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'MS003',
                'name' => 'VP',
                'primary_top_level_id' => 4,
                'secondary_top_level_id' => 5,
                'status' => 1,
                'created_at' => '2020-05-07 12:45:46',
                'updated_at' => '2020-05-08 01:05:26',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'MS004',
                'name' => 'Department',
                'primary_top_level_id' => 5,
                'secondary_top_level_id' => 9,
                'status' => 1,
                'created_at' => '2020-05-07 12:45:46',
                'updated_at' => '2020-08-13 08:33:03',
            ),
        ));
        
        
    }
}