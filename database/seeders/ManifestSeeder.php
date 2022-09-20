<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManifestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transitDestId = DB::table('transit_destinations')->first()->id;
        $packageDestId = DB::table('package_destinations')->first()->id;

        DB::table('manifests')->insert([
            'transit_destination_id' => $transitDestId,
            'package_destination_id' => $packageDestId,
            'quantity' => 1,
            'weight' => 26,
            'cod' => 550000,
            'cost' => 100000,
        ]);
    }
}
