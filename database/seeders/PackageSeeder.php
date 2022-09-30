<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manifestId = DB::table('manifests')->first()->id;
        $invoiceId = DB::table('invoices')->first()->id;
        $packageDestinationId = DB::table('package_destinations')->first()->id;

        DB::table('packages')->insert([
            'manifest_id' => $manifestId,
            'invoice_id' => $invoiceId,
            'package_destination_id' => $packageDestinationId,
            'tracking_no' => 1387,
            'recipient' => 'Jaya Sakti Teknik',
            'quantity' => 1,
            'weight' => 26,
            'type' => 'P',
            'cod' => 550000,
            'cost' => 100000,
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d')
        ]);
    }
}
