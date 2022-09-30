<x-app-layout>
    <x-slot name="header_content">
        <h1>Edit Barang</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('packages.index') }}">Barang</a></div>
            <div class="breadcrumb-item"><a href="#">Edit Package</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:create-package action="updatePackage" :packageId="request()->package->id" />
    </div>
</x-app-layout>
