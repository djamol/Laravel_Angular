<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id'=>1,'name'=>'Pink','volume'=>2.50],
            ['id'=>2,'name'=>'Red','volume'=>2.00],
            ['id'=>3,'name'=>'Blue','volume'=>1.00],
            ['id'=>4,'name'=>'Orange','volume'=>0.80],
            ['id'=>5,'name'=>'Green','volume'=>0.80],
        ];

        DB::table('balls')->insert($data);
    }
}
