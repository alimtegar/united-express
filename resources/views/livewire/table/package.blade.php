<div>
    <x-data-table :data="$data" :model="$packages">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('tracking_no')" role="button" href="#">
                    AWB
                    @include('components.sort-icon', ['field' => 'tracking_no'])
                </a></th>
                <th><a wire:click.prevent="sortBy('sender')" role="button" href="#">
                    Pengirim
                    @include('components.sort-icon', ['field' => 'sender'])
                </a></th>
                <th><a wire:click.prevent="sortBy('recipient')" role="button" href="#">
                    Penerima
                    @include('components.sort-icon', ['field' => 'recipient'])
                </a></th>
                <th><a wire:click.prevent="sortBy('origin_code')" role="button" href="#">
                    Asal
                    @include('components.sort-icon', ['field' => 'origin_code'])
                </a></th>
                <th><a wire:click.prevent="sortBy('destination_code')" role="button" href="#">
                    Tujuan
                    @include('components.sort-icon', ['field' => 'destination_code'])
                </a></th>
                <th><a wire:click.prevent="sortBy('quantity')" role="button" href="#">
                    Pcs
                    @include('components.sort-icon', ['field' => 'quantity'])
                </a></th>
                <th><a wire:click.prevent="sortBy('weight')" role="button" href="#">
                    Kg
                    @include('components.sort-icon', ['field' => 'weight'])
                </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                    Tanggal Dibuat
                    @include('components.sort-icon', ['field' => 'created_at'])
                </a></th>
                {{-- <th></th> --}}
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($packages as $package)
                <tr x-data="window.__controller.dataTableController({{ $package->id }})">
                    <td>{{ $package->tracking_no }}</td>
                    <td>{{ $package->sender }}</td>
                    <td>{{ $package->recipient }}</td>
                    <td>{{ $package->origin_code }}</td>
                    <td>{{ $package->destination_code }}</td>
                    <td>{{ $package->quantity }}</td>
                    <td>{{ $package->weight }}</td>
                    <td>{{ $package->created_at->format('d M Y H:i') }}</td>
                    {{-- <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="/user/edit/{{ $package->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                    </td> --}}
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
