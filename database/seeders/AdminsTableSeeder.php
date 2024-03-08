<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'first_name'         => 'Shakibul',
            'last_name'          => 'Islam',
            'email'              => 'admin@gmail.com',
            'phone'              => '01784801663',
            'national_id_number' => '1234567891',
            'gender'             => 'male',
            'permanent_address'  => 'House # 21, Road # 17, Block # D, Mirpur-1216, Dhaka',
            'present_address'    => 'House # 21, Road # 17, Block # D, Mirpur-1216, Dhaka',
            'password'           => '123456789',
            'is_verified'        => 1,
        ]);
    }
}
