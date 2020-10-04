<?php

use Illuminate\Database\Seeder;

class ReviewDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('review_details')->delete();
        
        \DB::table('review_details')->insert(array (
            0 => 
            array (
                'id' => 1,
                'review_id' => 2,
                'structure_id' => 23,
                'order' => 1,
                'created_at' => '2020-07-16 18:25:32',
                'updated_at' => '2020-07-16 18:25:32',
            ),
            1 => 
            array (
                'id' => 2,
                'review_id' => 2,
                'structure_id' => 9,
                'order' => 2,
                'created_at' => '2020-07-16 18:25:41',
                'updated_at' => '2020-07-16 18:25:41',
            ),
            2 => 
            array (
                'id' => 3,
                'review_id' => 2,
                'structure_id' => 3,
                'order' => 3,
                'created_at' => '2020-07-16 18:26:27',
                'updated_at' => '2020-07-16 18:26:27',
            ),
            3 => 
            array (
                'id' => 4,
                'review_id' => 2,
                'structure_id' => 2,
                'order' => 4,
                'created_at' => '2020-07-16 18:26:35',
                'updated_at' => '2020-07-16 18:26:35',
            ),
            4 => 
            array (
                'id' => 5,
                'review_id' => 1,
                'structure_id' => 23,
                'order' => 1,
                'created_at' => '2020-07-16 18:26:54',
                'updated_at' => '2020-07-16 18:26:54',
            ),
            5 => 
            array (
                'id' => 6,
                'review_id' => 1,
                'structure_id' => 9,
                'order' => 2,
                'created_at' => '2020-07-16 18:27:01',
                'updated_at' => '2020-07-16 18:27:01',
            ),
        ));
        
        
    }
}