<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            Barang
        </x-slot>

        <x-slot name="description">
            Lengkapi data berikut dan submit untuk menambahkan barang baru.
        </x-slot>

        <x-slot name="form">
            <div class="form-group col-span-6">
                <x-jet-label for="tracking_no" value="AWB" />
                <small>Nomor pelacakan pengiriman</small>
                <x-jet-input id="tracking_no" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.tracking_no" />
                <x-jet-input-error for="package.tracking_no" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="sender" value="Pengirim" />
                <small>Nama Pengirim</small>
                <x-jet-input id="sender" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.sender" />
                <x-jet-input-error for="package.sender" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="recipient" value="Penerima" />
                <small>Nama Penerima</small>
                <x-jet-input id="recipient" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.recipient" />
                <x-jet-input-error for="package.recipient" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="origin_id" value="Asal" />
                <small>Asal pengiriman</small>
                <x-jet-input id="origin_id" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.origin_id" />
                <x-jet-input-error for="package.origin_id" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="destination_id" value="Tujuan" />
                <small>Tujuan Pengiriman</small>
                <x-jet-input id="destination_id" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.destination_id" />
                <x-jet-input-error for="package.destination_id" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="quantity" value="Jumlah" />
                <small>Jumlah barang (Pcs)</small>
                <x-jet-input id="quantity" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.quantity" />
                <x-jet-input-error for="package.quantity" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3">
                <x-jet-label for="weight" value="Berat" />
                <small>Berat barang (Kg)</small>
                <x-jet-input id="weight" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.weight" />
                <x-jet-input-error for="package.weight" class="mt-2" />
            </div>

            <div class="form-group col-span-6">
                <x-jet-label for="type" value="Jenis" />
                <small>Jenis barang</small>
                <x-jet-input id="type" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.type" />
                <x-jet-input-error for="package.type" class="mt-2" />
            </div>

            <div class="form-group col-span-6">
                <x-jet-label for="description" value="Keterangan" />
                <small>Keterangan barang</small>
                <x-jet-input id="description" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.description" />
                <x-jet-input-error for="package.description" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __($button['submit_text']) }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
