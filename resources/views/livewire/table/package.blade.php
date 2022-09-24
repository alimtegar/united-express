<div>
    <x-data-table :data="$data" :model="$packages" :transitDestinations="$transitDestinations">
        <x-slot name="head">
            <tr>
                <th></th>
                <th><a wire:click.prevent="sortBy('tracking_no')" role="button" href="#">
                        AWB
                        @include('components.sort-icon', ['field' => 'tracking_no'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('manifest.transitDestination.name')" role="button" href="#">
                        Tujuan Lintas
                        @include('components.sort-icon', ['field' => 'manifest.transitDestination.name'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('manifest.packageDestination.name')" role="button" href="#">
                        Tujuan Barang
                        @include('components.sort-icon', ['field' => 'manifest.packageDestination.name'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('invoice.sender.name')" role="button" href="#">
                        Pengirim
                        @include('components.sort-icon', ['field' => 'invoice.sender.name'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('recipient')" role="button" href="#">
                        Penerima
                        @include('components.sort-icon', ['field' => 'recipient'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('quantity')" role="button" href="#">
                        Pcs
                        @include('components.sort-icon', ['field' => 'quantity'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('weight')" role="button" href="#">
                        Kg
                        @include('components.sort-icon', ['field' => 'weight'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('volume')" role="button" href="#">
                        V
                        @include('components.sort-icon', ['field' => 'volume'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('type')" role="button" href="#">
                        T
                        @include('components.sort-icon', ['field' => 'type'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('cod')" role="button" href="#">
                        COD
                        @include('components.sort-icon', ['field' => 'cod'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('description')" role="button" href="#">
                        Keterangan
                        @include('components.sort-icon', ['field' => 'description'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                        Tanggal Input
                        @include('components.sort-icon', ['field' => 'created_at'])
                    </a></th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($packages as $package)
                <tr x-data="window.__controller.dataTableController({{ $package->id }})">
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" href="/user/edit/{{ $package->id }}" class="ml-2"><i
                                class="fa fa-16px fa-pen"></i></a>
                        {{-- <a role="button" x-on:click.prevent="deleteItem" href="#"><i
                                class="fa fa-16px fa-trash text-red-500"></i></a> --}}
                    </td>
                    <td>{{ $package->tracking_no }}</td>
                    <td>{{ $package->manifest->transitDestination->name }}</td>
                    <td>{{ $package->manifest->packageDestination->name }}</td>
                    <td>{{ $package->invoice->sender->name }}</td>
                    <td>{{ $package->recipient }}</td>
                    <td>{{ $package->quantity }}</td>
                    <td>{{ $package->weight }}</td>
                    <td>{{ $package->volume }}</td>
                    <td>{{ $package->type }}</td>
                    <td>@money($package->cod)</td>
                    <td>{{ $package->description }}</td>
                    <td>{{ $package->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
