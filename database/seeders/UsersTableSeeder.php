<?php

namespace Database\Seeders;

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

        \DB::table('users')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Fatih',
                'email' => 'fatihtuzlu07@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$.xDwn9oc66PlQRuKIjwchO0ST0Q2KLEHTJ5byUwfYoyBg.GBjSxn.', //1234
                'remember_token' => NULL,
                'created_at' => '2024-12-15 13:57:13',
                'updated_at' => '2024-12-15 13:57:13',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'john',
                'email' => 'john@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$Rp56PwUxU7ARULlCQnJHBez2a3Kh4czqrQ3i4HBLeHN3gplI1Jt7u', //1234
                'remember_token' => NULL,
                'created_at' => '2024-12-15 13:57:26',
                'updated_at' => '2024-12-15 13:57:26',
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'john Doe',
                'email' => 'johndoe@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$0eQxvlOzxlaoDBKvVbNbhOfsk5XqIrj2rl1nMV98f9T3L8e7FwTKK', //1234
                'remember_token' => NULL,
                'created_at' => '2024-12-15 13:57:38',
                'updated_at' => '2024-12-15 13:57:38',
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'Michel',
                'email' => 'michel@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$12LEfMtkXA1GFdJtvIgXSO6cRRYTufNcpPanhf6MXs0a/EHM3Reny', //1234
                'remember_token' => NULL,
                'created_at' => '2024-12-15 13:57:55',
                'updated_at' => '2024-12-15 13:57:55',
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Ali',
                'email' => 'ali@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$jUrFSO13232.lD1OoqP09.hCjgUMIC0s.QfM3QrgRdx75rHb3pEeS', //1234
                'remember_token' => NULL,
                'created_at' => '2024-12-15 13:58:13',
                'updated_at' => '2024-12-15 13:58:13',
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Mendo',
                'email' => 'mendo@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$sH2Hl/OniX96lF1By89OX.Bwc8OzluDBN5u34/Ec8kEBGTsPlBx6W', //1234
                'remember_token' => NULL,
                'created_at' => '2024-12-15 13:58:24',
                'updated_at' => '2024-12-15 13:58:24',
            ),
        ));
    }
}
