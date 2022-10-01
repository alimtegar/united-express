<?php

namespace App\Http\Livewire;

use App\Models\Package;
use App\Models\Manifest;
use App\Models\Invoice;
use App\Models\Sender;
use App\Models\TransitDestination;
use App\Models\PackageDestination;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Carbon\Carbon;

class CreatePackage extends Component
{
    public $package;
    public $packageId;
    public $action;
    public $button;
    protected $packageDestinations;

    protected function getRules()
    {
        return [
            'package.tracking_no' => $this->action == 'createPackage' ? 'required|unique:packages,tracking_no|numeric' : '',
            'package.sender_id' => 'required|exists:senders,id|numeric',
            'package.recipient' => 'required|string',
            'package.transit_destination_id' => 'required|exists:transit_destinations,id|numeric',
            'package.package_destination_id' => 'required|exists:package_destinations,id|numeric',
            'package.quantity' => 'required|numeric',
            'package.weight' => 'required|numeric',
            'package.volume' => 'nullable|numeric',
            'package.type' => 'nullable|in:P,D|string',
            'package.cod' => 'nullable|numeric',
            'package.description' => 'nullable|string',
        ];
    }

    public function getPackageDestinations() {
        if (!empty($this->package['transit_destination_id'])) {
            $this->packageDestinations = PackageDestination::where('transit_destination_id', $this->package['transit_destination_id'])->orderBy('name')->get();
        } else if (!empty($this->package->manifest->transit_destination_id)) {
            $this->packageDestinations = PackageDestination::where('transit_destination_id', $this->package->manifest->transit_destination_id)->orderBy('name')->get();
        }
    }

    public function createOrUpdateManifest($cols) {
        $manifest = Manifest::query()
            ->where('transit_destination_id', $cols['transit_destination_id'])
            ->whereDate('created_at', Carbon::now()->format('Y-m-d'));

        // If there's already current month manifest, update it, else, create new one
        if($manifest->count()) {
            $manifest->increment('quantity', $cols['quantity']);
            $manifest->increment('weight', $cols['weight']);

            if(!empty($cols['volume'])) { $manifest->increment('volume', $cols['volume']); }
            if(!empty($cols['cod'])) { $manifest->increment('cod', $cols['cod']); }
            if(!empty($cols['cost'])) { $manifest->increment('cost', $cols['cost']); }

            $manifest = $manifest->first();
        } else {
            $manifest = Manifest::create($cols);
        }

        return $manifest;
    }

    public function createOrUpdateInvoice($cols) {
        $invoice = Invoice::query()
            ->where('sender_id', $cols['sender_id'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        if($invoice->count()) {
            $invoice->increment('quantity', $cols['quantity']);
            $invoice->increment('weight', $cols['weight']);

            if(!empty($cols['volume'])) { $invoice->increment('volume', $cols['volume']); }
            if(!empty($cols['cod'])) { $invoice->increment('cod', $cols['cod']); }
            if(!empty($cols['cost'])) { $invoice->increment('cost', $cols['cost']); }

            $invoice = $invoice->first();
        } else {
            $invoice = Invoice::create($cols);
        }

        return $invoice;
    }

    public function createPackage()
    {
        $this->resetErrorBag();
        $this->validate();

        $package = Package::create($this->package);

        $packageDestination = PackageDestination::find($this->package['package_destination_id']);
        $package->packageDestination()->associate($packageDestination);

        $manifest_invoiceCols = array_diff_key($this->package, array_flip(['package_destination_id', 'tracking_no', 'recipient', 'type', 'description']));
        // $manifest = array_diff_key($manifest_invoiceCols, array_flip(['sender_id']));
        // $invoice = array_diff_key($manifest_invoiceCols, array_flip(['transit_destination_id', 'package_destination_id']));

        $manifest = $this->createOrUpdateManifest($manifest_invoiceCols);
        $package->manifest()->associate($manifest);

        $invoice = $this->createOrUpdateInvoice($manifest_invoiceCols);
        $package->invoice()->associate($invoice);
        $package->save();

        $this->emit('saved');
        $this->reset('package');
    }

    public function incrementDataCols($data, $colVals) {
        foreach ($colVals as $col => $val) {
            if(!empty($val)) { $data->increment($col, $val); }
        }
    }

    public function incrementOldManifestCols($colVals) {
        $manifest = Manifest::query()
            ->where('transit_destination_id', $this->package->manifest->transit_destination_id)
            ->whereDate('created_at', Carbon::parse($this->package->created_at)->format('Y-m-d'));

        $this->incrementDataCols($manifest, $colVals);
    }

    public function incrementOldInvoiceCols($colVals) {
        $invoice = Invoice::query()
            ->where('sender_id', $this->package->invoice->sender_id)
            ->whereDate('created_at', Carbon::parse($this->package->created_at)->format('Y-m-d'));

        $this->incrementDataCols($invoice, $colVals);
    }

    public function updatePackage()
    {
        $this->resetErrorBag();
        $this->validate();

        $oldPackage = Package::find($this->packageId);

        $oldTransitDestinationId = $oldPackage->manifest->transit_destination_id;
        $newTransitDestinationId = $this->package['transit_destination_id'];
        $oldSenderId = $oldPackage->invoice->sender_id;
        $newSenderId = $this->package['sender_id'];
        $oldPackageDestinationId = $oldPackage->package_destination_id;
        $newPackageDestinationId = $this->package['package_destination_id'];

        $isTransitDestinationUpdated = $oldTransitDestinationId !== $newTransitDestinationId;
        $isSenderUpdated = $oldSenderId !== $newSenderId;
        $isPackageDestinationUpdated = $oldPackageDestinationId !== $newPackageDestinationId;

        if (!$isTransitDestinationUpdated || !$isSenderUpdated) {
            $diffVals = [
                'quantity' => $this->package['quantity'] - $oldPackage->quantity,
                'weight' => $this->package['weight'] - $oldPackage->weight,
                'volume' => $this->package['volume'] - $oldPackage->volume,
                'cod' => $this->package['cod'] - $oldPackage->cod,
                'cost' => $this->package['cost'] - $oldPackage->cost,
            ];

            // If there's an update in some of columns, increment old manifest or invoice columns
            if (boolval(array_sum($diffVals))) {
                if (!$isTransitDestinationUpdated) {
                    $this->incrementOldManifestCols($diffVals);
                }
                if (!$isSenderUpdated) {
                    $this->incrementOldInvoiceCols($diffVals);
                }
            }
        }

        if($isTransitDestinationUpdated || $isSenderUpdated || $isPackageDestinationUpdated) {
            if($isTransitDestinationUpdated || $isSenderUpdated) {
                $manifest_invoiceCols = array_diff_key($this->package->toArray(), array_flip(['package_destination_id', 'tracking_no', 'recipient', 'type', 'description']));

                if($isTransitDestinationUpdated) {
                    $manifest = $this->createOrUpdateManifest($manifest_invoiceCols);
                    $oldPackage->manifest()->disassociate();
                    $oldPackage->manifest()->associate($manifest);
                }

                if($isSenderUpdated) {
                    $invoice = $this->createOrUpdateInvoice($manifest_invoiceCols);
                    $oldPackage->invoice()->disassociate();
                    $oldPackage->invoice()->associate($invoice);
                }

                // Make sure the difference of value is not negative
                $diffVals = [
                    'quantity' => -($oldPackage->quantity),
                    'weight' => -($oldPackage->weight),
                    'volume' => -($oldPackage->volume),
                    'cod' => -($oldPackage->cod),
                    'cost' => -($oldPackage->cost),
                ];

                // If there's an update in some of columns, increment old manifest or invoice columns
                if (boolval(array_sum($diffVals))) {
                    if ($isTransitDestinationUpdated) {
                        $this->incrementOldManifestCols($diffVals);
                    }
                    if ($isSenderUpdated) {
                        $this->incrementOldInvoiceCols($diffVals);
                    }
                }
            }

            if($isPackageDestinationUpdated) {
                $packageDestination = PackageDestination::find($newPackageDestinationId);
                $oldPackage->packageDestination()->disassociate();
                $oldPackage->packageDestination()->associate($packageDestination);
            }

            $oldPackage->save();
        }

        Package::query()
            ->where('id', $this->packageId)
            ->update([
                'recipient' => $this->package->recipient,
                'quantity' => $this->package->quantity,
                'weight' => $this->package->weight,
                'volume' => $this->package->volume,
                'type' => $this->package->type,
                'cod' => $this->package->cod,
                'description' => $this->package->description,
                'cost' => $this->package->cost,
            ]);

        $this->emit('saved');
    }

    public function mount()
    {
        if (!$this->package && $this->packageId) {
            $this->package = Package::find($this->packageId);
            $this->package['transit_destination_id'] = $this->package->manifest->transit_destination_id;
            $this->package['sender_id'] = $this->package->invoice->sender_id;
        }

        $this->getPackageDestinations();

        $this->button = create_button($this->action, "package");
    }

    public function render()
    {
        return view('livewire.create-package', [
            'senders' => Sender::all()->sortBy('name'),
            'transitDestinations' => TransitDestination::all()->sortBy('name'),
            // 'packageDestinations' => collect(new PackageDestination),
        ]);
    }

    public function updated() {
        $this->getPackageDestinations();
    }

    public function updatedPackages() {
        $this->dispatchBrowserEvent('focusFirstInput');
    }

    public function hydrate() {
        $this->getPackageDestinations();
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initScripts');
    }
}
