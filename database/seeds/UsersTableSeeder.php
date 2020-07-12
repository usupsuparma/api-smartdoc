<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_core_id' => NULL,
                'employee_id' => NULL,
                'role_id' => 5,
                'email' => 'vulpix@enigma.id',
                'username' => 'vulpix',
                'password' => '$2y$10$zuYIgOw0IqVf6QnD7.8hOOgy1b4.Q92bTuJU1IoCXnhYyWDf7Pyma',
                'remember_token' => NULL,
                'public_token' => NULL,
                'private_token' => NULL,
                'device_id' => '9355b5c3-dbff-4e7a-a8f3-16ca3f434c32',
                'last_login' => NULL,
                'log_date' => NULL,
                'count_login' => 0,
                'is_banned' => 0,
                'status' => 1,
                'created_at' => '2020-03-01 10:15:41',
                'updated_at' => '2020-06-30 14:53:13',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}