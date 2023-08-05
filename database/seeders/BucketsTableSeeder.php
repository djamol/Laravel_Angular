<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BucketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 2, 'name' => 'A', 'volume' => 20.00 ],
            ['id' => 3, 'name' => 'B', 'volume' => 18.00],
            ['id' => 4, 'name' => 'C', 'volume' => 12.00],
            ['id' => 5, 'name' => 'D', 'volume' => 10.00],
            ['id' => 6, 'name' => 'E', 'volume' => 8.00],
        ];

        DB::table('buckets')->insert($data);
    }
}
