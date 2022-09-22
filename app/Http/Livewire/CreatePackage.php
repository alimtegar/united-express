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

    protected function getRules()
    {
        $rules = ($this->action == "updatePackage") ? [
            'package.email' => 'required|email|unique:packages,email,' . $this->packageId
        ] : [
            'package.password' => 'required|min:8|confirmed',
            'package.password_confirmation' => 'required' // livewire need this
        ];

        return array_merge([
            'package.tracking_no' => 'required|unique:packages,tracking_no|numeric|min_digits:6',
            'package.sender' => 'required|string',
            'package.email' => 'required|email|unique:packages,email'
        ], $rules);
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

        $this->button = create_button($this->action, "package");
    }

    public function render()
    {
        return view('livewire.create-package', [
            'senders' => Sender::all(),
            'transitDestinations' => TransitDestination::all(),
            'packageDestinations' => collect(new PackageDestination),
        ]);
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initScripts');
    }
}
