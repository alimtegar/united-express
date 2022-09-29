<?php

if (count($packages)) {
    $createdAt = Carbon\Carbon::parse($packages[0]->created_at);
    $dmYDate = $createdAt->format('d-m-Y');
    $dMYDate = $createdAt->format('d-M-Y');
    $origin = 'Yogyakarta';
    $transitionDestination = $packages[0]->manifest->transitDestination->name;
}

?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @isset($meta)
        {{ $meta }}
    @endisset

    <!-- Styles -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&family=Nunito:wght@400;600;700&family=Open+Sans&display=swap" rel="stylesheet"> --}}

    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('stisla/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/notyf/notyf.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all">
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css" media="all">
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">

    <livewire:styles />

    <style>
    /* body {
        font-family: arial;
    } */

    .table-bordered, .table.table-bordered td, .table.table-bordered th {
        border-color: #343a40;
    }
    .table-bordered thead td, .table-bordered thead th {
        border-bottom-width: 1px;
    }
    </style>

    <!-- Scripts -->
    <script defer src="{{ asset('vendor/alpine.js') }}"></script>
</head>
<body class="bg-white">
    @if (count($packages))
    <div class="p-8 pb-0">
        <a id="download-link" class="btn btn-primary shadow-none" href="#" download={{ 'Manifest_' . $dmYDate . '_' . $origin . '-' . $transitionDestination }}>Download File Gambar</a>
    </div>
    <div id="downloaded-table" class="bg-white p-8">
        <table class="table table-bordered table-sm text-body">
            <thead>
                <tr>
                    <th class="text-center align-middle" colspan="20">Cargo Manifest</th>
                </tr>
                <tr>
                    <th class="text-center align-middle" colspan="2">Tanggal</th>
                    <td class="text-center align-middle">{{ $dMYDate }}</td>
                    <th class="text-center align-middle">Asal:</th>
                    <td class="text-center align-middle" colspan="4">{{ $origin }}</td>
                    <th class="text-center align-middle" colspan="2">Tujuan:</th>
                    <td class="text-center align-middle">{{ $transitionDestination }}</td>
                </tr>
                <tr>
                    <th class="text-center align-middle" rowspan="2">No</th>
                    <th class="text-center align-middle" rowspan="2">AWB</th>
                    <th class="text-center align-middle" rowspan="2">Pengirim</th>
                    <th class="text-center align-middle" rowspan="2">Penerima</th>
                    <th class="text-center align-middle" colspan="4">Rincian Barang</th>
                    <th class="text-center align-middle" rowspan="2">Tujuan</th>
                    <th class="text-center align-middle" rowspan="2">COD</th>
                    <th class="text-center align-middle" rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th class="text-center align-middle">Pcs</th>
                    <th class="text-center align-middle">Kg</th>
                    <th class="text-center align-middle">V</th>
                    <th class="text-center align-middle">T</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $key => $package)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td>{{$package->tracking_no}}</td>
                    <td>{{$package->invoice->sender->name}}</td>
                    <td>{{$package->recipient}}</td>
                    <td class="text-center">{{$package->quantity}}</td>
                    <td class="text-center">{{$package->weight}}</td>
                    <td class="text-center">{{$package->volume}}</td>
                    <td class="text-center">{{$package->type}}</td>
                    <td>{{$package->manifest->packageDestination->name}}</td>
                    <td>@money($package->cod)</td>
                    <td>{{$package->description}}</td>
                <tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>Total</th>
                    <td class="text-center">{{$packages[0]->manifest->quantity}}</td>
                    <td class="text-center">{{$packages[0]->manifest->weight}}</td>
                    <td class="text-center">{{$packages[0]->manifest->volume}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js" integrity="sha512-01CJ9/g7e8cUmY0DFTMcUw/ikS799FHiOA0eyHsUWfOetgbx/t6oV4otQ5zXKQyIrQGTHSmRVPIgrgLcZi/WMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var node = document.getElementById('downloaded-table');
        var downloadLink = document.getElementById('download-link');

        domtoimage.toPng(node)
            .then(function (dataUrl) {
                var img = new Image();
                img.src = dataUrl;
                downloadLink.href= dataUrl;
                // document.body.appendChild(img);
            })
            .catch(function (error) {
                console.error('oops, something went wrong!', error);
            });
    </script>
    @endif
    @if (count($errorMessages))
    <div class="p-8">
        @foreach ($errorMessages as $errorMessage)
            <div class="alert alert-danger" role="alert">
                {!! $errorMessage !!}
            </div>
        @endforeach
    </div>
    @endif
</body>
</html>
