<x-app-layout>
    <x-slot name="header_content">
        <h1>Tambah Barang</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('packages.index') }}">Barang</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('packages.create') }}">Tambah Barang</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:create-package action="createPackage" />
    </div>
</x-app-layout>
