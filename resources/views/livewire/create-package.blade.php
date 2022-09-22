@push('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            Barang
        </x-slot>

        <x-slot name="description">
            Lengkapi data berikut dan submit untuk menambahkan barang baru.
        </x-slot>

        <x-slot name="form">
            <div class="form-group col-span-12">
                <x-jet-label for="tracking_no" value="AWB" />
                <x-jet-input id="tracking_no" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.tracking_no" />
                <x-jet-input-error for="package.tracking_no" class="mt-2" />
            </div>

            <div class="form-group col-span-12 sm:col-span-6">
                {{-- Ketik dan Enter pengirim baru jika tidak ada dalam daftar --}}
                <x-jet-label for="sender_id" value="Pengirim"/>
                {{-- <x-jet-input id="sender_id" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.sender_id" /> --}}
                <select id="sender_id" class="select2 w-full" name="sender_id">
                    <option></option>
                    @foreach($senders as $sender)
                        <option value="{{ $sender->id }}">{{ $sender->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="package.sender_id" class="mt-2" />
            </div>

            <div class="form-group col-span-12 sm:col-span-6">
                <x-jet-label for="recipient" value="Penerima" />
                <x-jet-input id="recipient" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.recipient" />
                <x-jet-input-error for="package.recipient" class="mt-2" />
            </div>

            <div class="form-group col-span-12 sm:col-span-6">
                <x-jet-label for="transit_destination_id" value="Tujuan Lintas" />
                {{-- <x-jet-input id="transit_destination_id" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.transit_destination_id" /> --}}
                <select id="transit_destination_id" class="select2 w-full" name="transit_destination_id">
                    <option></option>
                    @foreach($transitDestinations as $transitDestination)
                        <option value="{{ $transitDestination->id }}">{{ $transitDestination->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="package.transit_destination_id" class="mt-2" />
            </div>

            <div class="form-group col-span-12 sm:col-span-6">
                <x-jet-label for="package_destination_id" value="Tujuan Barang" help="Pilih tujuan lintas terlebih dahulu" />
                {{-- <x-jet-input id="package_destination_id" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.package_destination_id" /> --}}
                <select id="package_destination_id" class="select2 w-full" name="package_destination_id">
                    @foreach($packageDestinations as $packageDestination)
                        <option></option>
                        <option value="{{ $packageDestination->id }}">{{ $packageDestination->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="package.package_destination_id" class="mt-2" />
            </div>

            <div class="form-group col-span-12 sm:col-span-3">
                <x-jet-label for="quantity" value="Jumlah (Pcs)" />
                <x-jet-input id="quantity" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.quantity" />
                <x-jet-input-error for="package.quantity" class="mt-2" />
            </div>

            <div class="form-group col-span-12 sm:col-span-3">
                <x-jet-label for="weight" value="Berat (Kg)" />
                <x-jet-input id="weight" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.weight" />
                <x-jet-input-error for="package.weight" class="mt-2" />
            </div>

            <div class="form-group col-span-12 sm:col-span-3">
                <x-jet-label for="volume" value="Volume" help="Opsional" />
                <x-jet-input id="volume" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.volume" />
                <x-jet-input-error for="package.volume" class="mt-2" />
            </div>

            <div class="form-group col-span-12 sm:col-span-3">
                <x-jet-label for="type" value="Jenis" help="Opsional" />
                {{-- <x-jet-input id="type" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.type" /> --}}
                <select id="type" class="select2 w-full" name="type">
                    <option></option>
                    <option value="P">Parsel</option>
                    <option value="D">Dokumen</option>
                </select>
                <x-jet-input-error for="package.type" class="mt-2" />
            </div>

            <div class="form-group col-span-12">
                <x-jet-label for="cod" value="COD" help="Opsional" />
                <x-jet-input id="cod" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.cod" />
                <x-jet-input-error for="package.cod" class="mt-2" />
            </div>

            <div class="form-group col-span-12">
                <x-jet-label for="description" value="Keterangan" help="Opsional" />
                <x-jet-input id="description" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.description" />
                <x-jet-input-error for="package.description" class="mt-2" />
            </div>

            {{-- <div class="form-group col-span-12">
                <x-jet-label for="cost" value="Harga" />
                <x-jet-input id="cost" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="package.cost" />
                <x-jet-input-error for="package.cost" class="mt-2" />
            </div> --}}
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

@push('scripts')
<script>
    $(document).ready(function() {
        function initScripts() {
            var transitDestSelect2 = $('#transit_destination_id');
            var packageDestSelect2 = $('#package_destination_id');
            var packageDestSelect2Config = {
                placeholder: 'Pilih tujuan barang',
                allowClear: true,
            };

            $('#sender_id').select2({
                placeholder: 'Pilih pengirim',
                allowClear: true,
            });
            transitDestSelect2.select2({
                placeholder: 'Pilih tujuan lintas',
                allowClear: true,
            });
            packageDestSelect2.select2(packageDestSelect2Config);
            $('#type').select2({
                placeholder: 'Pilih jenis',
                allowClear: true,
            });

            transitDestSelect2.on('select2:select', function (e) {
                var selectedTransitDestId = e.params.data.id;
        
                packageDestSelect2.empty();
                packageDestSelect2.select2({
                    ...packageDestSelect2Config,
                    ajax: {
                        url: `{{ route('package-destinations.index') }}?transit_destination_id=${selectedTransitDestId}`,
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: $.map(data, function(obj) {
                                    return { id: obj.id, text: obj.name };
                                })
                            };
                        }
                    },
                });
            });
        }

        initScripts();

        window.addEventListener('initScripts', initScripts);
    });
</script>
@endpush