<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PackageDestination;

class PackageDestinationController extends Controller
{
    public function index(Request $request)
    {
        $transitDestinationId = $request->input('transit_destination_id');

        $banks = PackageDestination::where('transit_destination_id', $transitDestinationId)->get();

        return response()->json($banks, 200);
    }
}
