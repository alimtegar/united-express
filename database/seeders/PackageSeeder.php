<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('packages')->insert([[
        //     'tracking_no' => 245863,
        //     'sender' => 'Matoa A',
        //     'recipient' => 'Susi Restiana Fauzi',
        //     'origin_code' => 'SOC',
        //     'destination_code' => 'CLP',
        //     'quantity' => 1,
        //     'weight' => 19,
        //     'type' => 'Parcel',
        //     'description' => 'COD 240.000',
        //     'cost' => 20000,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ], [
        //     'tracking_no' => 245865,
        //     'sender' => 'Matoa A',
        //     'recipient' => 'Prasasti Sekar Asrinta',
        //     'origin_code' => 'SOC',
        //     'destination_code' => 'PWT',
        //     'quantity' => 2,
        //     'weight' => 41,
        //     'type' => 'Parcel',
        //     'description' => 'COD 240.000',
        //     'cost' => 40000,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ], [
        //     'tracking_no' => 245996,
        //     'sender' => 'Matoa A',
        //     'recipient' => 'Apri Dwi Lestari',
        //     'origin_code' => 'SOC',
        //     'destination_code' => 'CLP',
        //     'quantity' => 1,
        //     'weight' => 24,
        //     'type' => 'Parcel',
        //     'description' => 'COD 240.000',
        //     'cost' => 20000,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]]);
    }
}
