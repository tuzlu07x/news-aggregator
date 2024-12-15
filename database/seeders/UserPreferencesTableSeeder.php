<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserPreferencesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_preferences')->delete();
        
        \DB::table('user_preferences')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 5,
                'areas_of_interest' => 'technology',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'areas_of_interest' => 'politics',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 2,
                'areas_of_interest' => 'sports',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 6,
                'areas_of_interest' => 'entertainment',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 4,
                'areas_of_interest' => 'health',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'areas_of_interest' => 'health',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'user_id' => 5,
                'areas_of_interest' => 'other',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'user_id' => 3,
                'areas_of_interest' => 'entertainment',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'user_id' => 4,
                'areas_of_interest' => 'technology',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'user_id' => 5,
                'areas_of_interest' => 'health',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}