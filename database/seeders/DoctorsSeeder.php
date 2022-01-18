<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doctors')->insert(array(
            0 => array(
                'name' => 'زیبا احمدی',
                'expertise_code' => 200020,
                'address' => 'پلاک',
                'phone_number' => '09190000745'
            ),
            1 => array(
                'name' => 'سعید ایمانی',
                'expertise_code' => 200020,
                'address' => "پلاک",
                'phone_number' => '09190000009'
            ),
            2 => array(
                'name' => 'رضا صفایی',
                'expertise_code' => 200021,
                'address' => "پلاک",
                'phone_number' => '09190000008'
            ),
            3 => array(
                'name' => 'صابر بنیاد',
                'expertise_code' => 200021,
                'address' => "پلاک",
                'phone_number' => '09190000003'
            ),
            4 => array(
                'name' => 'شیما شریف',
                'expertise_code' => 200022,
                'address' => "پلاک",
                'phone_number' => '09190000004'
            ),
            5 => array(
                'name' => 'سمیه عارف',
                'expertise_code' => 200022,
                'address' => "پلاک",
                'phone_number' => '09190000075'
            ),
            6 => array(
                'name' => 'شیرین شریف',
                'expertise_code' => 200023,
                'address' => "پلاک",
                'phone_number' => '09190000084'
            ),
            7 => array(
                'name' => 'سیما فراز',
                'expertise_code' => 200023,
                'address' => "پلاک",
                'phone_number' => '09190000095'
            )
        ));
    }
}
