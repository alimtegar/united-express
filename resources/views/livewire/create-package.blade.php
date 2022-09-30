@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div id="form-create" class="mb-4">
    <x-jet-form-section :submit="$action">
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
                <x-jet-label for="sender_id" value="Pengirim"/>
                <select id="sender_id" class="select2 w-full" name="package.sender_id">
                    <option></option>
                    @foreach($senders as $sender)
                        <option value="{{ $sender->id }}" {!!
                            (!empty($this->package->invoice->sender_id) && $this->package->invoice->sender_id == $sender->id) ||
                            (!empty($this->package['sender_id']) && $this->package['sender_id'] == $sender->id)
                                ? 'selected'
                                : ''
                        !!}>
                            {{ $sender->name }}
                        </option>
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
                <select id="transit_destination_id" class="select2 w-full" name="package.transit_destination_id">
                    <option></option>
                    @foreach($transitDestinations as $transitDestination)
                        <option value="{{ $transitDestination->id }}" {!!
                                (!empty($this->package->manifest->transit_destination_id) && $this->package->manifest->transit_destination_id == $transitDestination->id) ||
                                (!empty($this->package['transit_destination_id']) && $this->package['transit_destination_id'] == $transitDestination->id)
                                    ? 'selected'
                                    : ''
                        !!}>
                            {{ $transitDestination->name }}
                        </option>
                    @endforeach
                </select>
                <x-jet-input-error for="package.transit_destination_id" class="mt-2" />
            </div>

            <div class="form-group col-span-12 sm:col-span-6">
                <x-jet-label for="package_destination_id" value="Tujuan Barang" help="Pilih tujuan lintas terlebih dahulu" />
                <select id="package_destination_id" class="select2 w-full" name="package.package_destination_id">
                    @if(!empty($this->packageDestinations))
                        @foreach($this->packageDestinations as $packageDestination)
                            <option></option>
                            <option value="{{ $packageDestination->id }}" {!!
                                (!empty($this->package->package_destination_id) && $this->package->package_destination_id == $packageDestination->id) ||
                                (!empty($this->package['package_destination_id']) && $this->package['package_destination_id'] == $packageDestination->id)
                                    ? 'selected'
                                    : ''
                            !!}>
                                {{ $packageDestination->name }}
                            </option>
                        @endforeach
                    @endif
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
                <select id="type" class="select2 w-full" name="package.type">
                    <option></option>
                    <option value="P" {!! !empty($this->package['type']) && $this->package['type'] == 'P' ? 'selected' : '' !!}>Parsel</option>
                    <option value="D" {!! !empty($this->package['type']) && $this->package['type'] == 'D' ? 'selected' : '' !!}>Dokumen</option>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('livewire:load', function() {
        $(document).ready(function() {
            $('#tracking_no').focus();

            // Scroll to top and focus on the first text input when Livewire 'saved' event emitted
            Livewire.on('saved', function() {
                $('#tracking_no').focus();
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                return false;
            });

            // Initialize scripts when Livewire rehydrate
            $(window).on('initScripts', initScripts);

            function initScripts() {
                var transitDestSelect2Elem = $('#transit_destination_id');
                var packageDestSelect2Elem = $('#package_destination_id');

                var packageDestSelect2ElemConfig = {
                    placeholder: 'Pilih tujuan barang',
                    allowClear: true,
                };

                $('#sender_id').select2({
                    placeholder: 'Pilih pengirim',
                    allowClear: true,
                });
                transitDestSelect2Elem.select2({
                    placeholder: 'Pilih tujuan lintas',
                    allowClear: true,
                });
                packageDestSelect2Elem.select2(packageDestSelect2ElemConfig);
                $('#type').select2({
                    placeholder: 'Pilih jenis',
                    allowClear: true,
                });

                // Set Livewire variable on Select2 select
                $('.select2').on('select2:select', function (e) {
                    var name = e.target.name;
                    var selectedId = e.params.data.id;

                    @this.set(name, selectedId);
                });

                // Set Livewire variable on Select2 select
                $('.select2').on('select2:unselecting', function (e) {
                    var name = e.target.name;

                    @this.set(name, null);
                });
            }

            initScripts();
        });
    });
</script>
@endpush
