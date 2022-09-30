<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.packages.index', [
            'user' => User::class,
            'package' => Package::class,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.packages.create', [
            'user' => User::class,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePackageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePackageRequest  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }

    public function image(Request $request) {
        $errorMessages = [];

        $transitDestinationId = $request->input('transit_destination_id');
        if (empty($transitDestinationId)) { $errorMessages[] = 'Tidak ada parameter <strong>transit_destination_id</strong> pada URL'; }

        $createdDate = $request->input('created_date');
        if (empty($createdDate)) { $errorMessages[] = 'Tidak ada parameter <strong>created_date</strong> pada URL'; }
        $createdDate = Carbon::parse($createdDate)->format('Y-m-d');

        $packages = Package::query()
            ->whereHas('manifest', function ($query) use ($transitDestinationId) {
                return $query->where('transit_destination_id', $transitDestinationId);
            })
            ->whereDate('created_at', $createdDate)
            ->get();
        if (!count($packages)) { $errorMessages[] = 'Data tidak ditemukan.'; }

        return view('pages.packages.image', [
            'packages' => $packages,
            'errorMessages' => $errorMessages,
        ]);
    }
}
