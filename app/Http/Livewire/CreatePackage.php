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
            'package.tracking_no' => 'required|unique:packages,tracking_no|numeric',
            'package.sender_id' => 'required|exists:senders,id|string',
            'package.recipient' => 'required|string',
            'package.transit_destination_id' => 'required|exists:transit_destinations,id|string',
            'package.package_destination_id' => 'required|exists:package_destinations,id|string',
            'package.quantity' => 'required|numeric',
            'package.weight' => 'required|numeric',
            'package.volume' => 'nullable|numeric',
            'package.type' => 'nullable|in:P,D|string',
            'package.cod' => 'nullable|numeric',
            'package.description' => 'nullable|string',
        ];
    }

    public function getPackageDestinations() {
        $this->packageDestinations = !empty($this->package['transit_destination_id']) 
            ? PackageDestination::where('transit_destination_id', $this->package['transit_destination_id'])->get() 
            : null;
    }

    public function createPackage()
    {
        $this->resetErrorBag();
        $this->validate();

        $package = Package::create($this->package);

        $manifest_invoice = array_diff_key($this->package, array_flip(['tracking_no', 'recipient', 'type', 'description']));
        // $manifest = array_diff_key($manifest_invoice, array_flip(['sender_id']));
        // $invoice = array_diff_key($manifest_invoice, array_flip(['transit_destination_id', 'package_destination_id']));

        // Create or update manifest
        $currentMonthManifest = Manifest::query()
            ->where('transit_destination_id', $manifest_invoice['transit_destination_id'])
            ->where('package_destination_id', $manifest_invoice['package_destination_id'])
            ->whereDay('created_at', now()->day)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        // If there's already current month manifest, update it, else, create new one
        if($currentMonthManifest->count()) {
            $currentMonthManifest->increment('quantity', $manifest_invoice['quantity']);
            $currentMonthManifest->increment('weight', $manifest_invoice['weight']);
            
            if(!empty($manifest_invoice['volume'])) {
                $currentMonthManifest->increment('volume', $manifest_invoice['volume']);
            }

            if(!empty($manifest_invoice['cod'])) {
                $currentMonthManifest->increment('cod', $manifest_invoice['cod']);
            }

            if(!empty($manifest_invoice['cost'])) {
                $currentMonthManifest->increment('cost', $manifest_invoice['cod']);
            }
        } else {
            $currentMonthManifest = Manifest::create($manifest_invoice);
        }

        $package->manifest()->associate($currentMonthManifest);

        // Create or update invoice
        $senderInvoice = Invoice::query()
            ->where('sender_id', $manifest_invoice['sender_id'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        if($senderInvoice->count()) {
            $senderInvoice->increment('quantity', $manifest_invoice['quantity']);
            $senderInvoice->increment('weight', $manifest_invoice['weight']);
            
            if(!empty($manifest_invoice['volume'])) {
                $senderInvoice->increment('volume', $manifest_invoice['volume']);
            }

            if(!empty($manifest_invoice['cod'])) {
                $senderInvoice->increment('cod', $manifest_invoice['cod']);
            }

            if(!empty($manifest_invoice['cost'])) {
                $senderInvoice->increment('cost', $manifest_invoice['cod']);
            }
        } else {
            $senderInvoice = Invoice::create($manifest_invoice);
        }

        $package->invoice()->associate($senderInvoice);
        $package->save();
        
        $this->emit('saved');
        $this->reset('package');
    }

    public function updatePackage()
    {
        $this->resetErrorBag();
        $this->validate();

        Package::query()
            ->where('id', $this->packageId)
            ->update([
                "name" => $this->package->name,
                "email" => $this->package->email,
            ]);

        $this->emit('saved');
    }

    public function mount()
    {
        if (!$this->package && $this->packageId) {
            $this->package = Package::find($this->packageId);
        }

        $this->getPackageDestinations();

        $this->button = create_button($this->action, "package");
    }

    public function render()
    {
        return view('livewire.create-package', [
            'senders' => Sender::all(),
            'transitDestinations' => TransitDestination::all(),
            // 'packageDestinations' => collect(new PackageDestination),
        ]);
    }

    public function updated() {
        $this->getPackageDestinations();
    }

    public function hydrate() {
        $this->getPackageDestinations();
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initScripts');
    }
}
