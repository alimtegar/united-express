@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

{{-- {{var_dump($this->name)}} --}}

<div class="bg-gray-100 text-gray-900 tracking-wider leading-normal">
    <div class="p-8 pt-4 mt-2 bg-white" x-data="window.__controller.dataTableMainController()" x-init="setCallback();">
        <div class="flex justify-content-between pb-4 -ml-3">
            <div>
                {{-- <a href="{{ $data->href->export }}" class="ml-2 btn btn-outline-success shadow-none">
                    <span class="fas fa-sm fa-file-export"></span> {{ $data->href->export_text }}
                </a> --}}
                <a href="{{ $data->href->export_image }}" class="mr-2 btn btn-outline-primary shadow-none{{!empty($this->transitDestinationId) && !empty($this->createdDate) ? '' : ' disabled'}}">
                    <span class="fas fa-sm fa-download"></span> {{ $data->href->export_image_text }}
                </a>
                @if(empty($this->transitDestinationId) || empty($this->createdDate))
                <div class="form-group d-inline-flex mb-0">
                    <span class="control-label">
                        <small>Pilih tujuan lintas dan tanggal dahulu untuk men-download file</small>
                    </span>
                </div>
                @endif
            </div>
            <a href="{{ $data->href->create_new }}"  class="-ml- btn btn-primary shadow-none">
                <span class="fas fa-sm fa-plus"></span> {{ $data->href->create_new_text }}
            </a>
        </div>

        <div class="form-row mb-4">
            <div class="col-md-2 form-inline">
                Per Halaman: &nbsp;
                <select wire:model="perPage" class="form-control flex-grow-1">
                    <option>10</option>
                    <option>15</option>
                    <option>25</option>
                </select>
            </div>

            <div class="col"></div>

            {{-- {{var_dump($this->transitDestinationId)}} --}}

            @if($this->name === 'package')
                <div class="col-md-2 form-inline">
                    <select name="transitDestinationId" id="transit_destination_id" class="select2 form-control w-100">
                        <option></option>
                        @foreach($transitDestinations as $transitDestination)
                            <option value="{{ $transitDestination->id }}" {!! !empty($this->transitDestinationId) && $this->transitDestinationId == $transitDestination->id ? 'selected' : '' !!}>{{ $transitDestination->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 form-inline">
                    <input name="createdDate" id="created_date" class="datepicker form-control w-100">
                </div>
            @endif

            <div class="col-md-4">
                <input wire:model="search" class="form-control" type="text" placeholder="Cari barang..">
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-sm table-striped text-sm text-gray-600">
                    <thead>
                        {{ $head }}
                    </thead>
                    <tbody>
                        {{ $body }}
                    </tbody>
                </table>
            </div>
        </div>

        <div id="table_pagination" class="py-3">
            {{ $model->onEachSide(1)->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('livewire:load', function() {
        $(document).ready(function() {
            function setTZ(date) {
                return new Date(date.getTime() - (date.getTimezoneOffset() * 60 * 1000));
            }

            // Initialize scripts when Livewire rehydrate
            $(window).on('initScripts', initScripts);

            var cretaedDateDatePicker = $('.datepicker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                language: 'id',
            });

            cretaedDateDatePicker.datepicker('setDate', 'now');
            cretaedDateDatePicker.on('changeDate', function (e) {
                var name = e.target.name;
                var date = setTZ(e.date);

                @this.set(name, date);
            });

            function initScripts() {
                $('#transit_destination_id').select2({
                    placeholder: 'Pilih tujuan lintas',
                    allowClear: true,
                });

                // Set Livewire data on Select2 select
                $('.select2').on('select2:select', function (e) {
                    var name = e.target.name;
                    var selectedId = e.params.data.id;

                    @this.set(name, selectedId);
                });

                // Set Livewire data on Select2 select
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
