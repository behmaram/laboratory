<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class ExpertiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expertise')->insert(array(
            0 => array(
                'name' => 'تخصص غدد',
                'code' => 200020
            ),
            1 => array(
                'name' => 'تخصص قند و چربی',
                'code' =>  200021
            ),
            2 => array(
                'name' => 'تخصص قلب و عروق',
                'code' => 200022
            ),
            3 => array(
                'name' => 'پزشک عمومی',
                'code' => 200023
            )
            ));
    }
}
