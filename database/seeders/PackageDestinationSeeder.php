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
        $transitDestinationId = DB::table('transit_destinations')->first()->id;

        DB::table('package_destinations')->insert([
            'transit_destination_id' => $transitDestinationId,
            'name' => 'Demak',
        ]);
    }
}
