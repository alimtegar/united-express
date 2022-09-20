<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transitDestId = DB::table('transit_destinations')->first()->id;

        DB::table('package_destinations')->insert([
            'transit_destination_id' => $transitDestId,
            'name' => 'Demak',
        ]);
    }
}
