<?php

namespace App\Http\Livewire;

use App\Models\Package;
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

        $password = $this->package['password'];

        if (!empty($password)) {
            $this->package['password'] = Hash::make($password);
        }

        Package::create($this->package);

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

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initScripts');
    }
}
