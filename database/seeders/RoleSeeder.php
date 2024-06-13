<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonArray = '[{"id": 1, "RoleName": "Super Admin"}]';

    	$array = json_decode($jsonArray, true);
        DB::table('roles')->insert($array);
    }
}
