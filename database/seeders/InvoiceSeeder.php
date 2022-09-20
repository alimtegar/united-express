<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $senderId = DB::table('senders')->first()->id;

        DB::table('invoices')->insert([
            'sender_id' => $senderId,
            'quantity' => 1,
            'weight' => 26,
            'cod' => 550000,
            'cost' => 100000,
        ]);
    }
}
