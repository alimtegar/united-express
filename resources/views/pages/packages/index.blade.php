<x-app-layout>
    <x-slot name="header_content">
        <h1>Daftar Barang</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('packages.index') }}">Barang</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('packages.index') }}">Daftar Barang</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="package" :model="$package" />
    </div>
</x-app-layout>
