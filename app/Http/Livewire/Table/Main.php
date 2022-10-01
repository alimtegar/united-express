<?php

namespace App\Http\Livewire\Table;

use App\Models\Manifest;
use App\Models\Invoice;
use App\Models\TransitDestination;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithDataTable;
use Carbon\Carbon;

class Main extends Component
{
    use WithPagination, WithDataTable;

    public $model;
    public $name;

    public $perPage = 10;
    public $sortField = "id";
    public $sortAsc = false;
    public $search = '';
    public $transitDestinationId;
    public $createdDate;

    protected $listeners = [ "deleteItem" => "delete_item" ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function decrementDataCols($data, $colVals) {
        foreach ($colVals as $col => $val) {
            if(!empty($val)) { $data->decrement($col, $val); }
        }
    }

    public function decrementOldManifestCols($package, $colVals) {
        $manifest = Manifest::query()
            ->where('transit_destination_id', $package->manifest->transit_destination_id)
            ->whereDate('created_at', Carbon::parse($package->created_at)->format('Y-m-d'));

        $this->decrementDataCols($manifest, $colVals);
    }

    public function decrementOldInvoiceCols($package, $colVals) {
        $invoice = Invoice::query()
            ->where('sender_id', $package->invoice->sender_id)
            ->whereDate('created_at', Carbon::parse($package->created_at)->format('Y-m-d'));

        $this->decrementDataCols($invoice, $colVals);
    }

    public function delete_item($id)
    {
        // dd($this->name);
        $data = $this->model::find($id);

        if (!$data) {
            $this->emit("deleteResult", [
                "status" => false,
                "message" => "Gagal menghapus data " . $this->name
            ]);
            return;
        }

        if($this->name === 'package') {
            $diffVals = [
                'quantity' => $data->quantity,
                'weight' => $data->weight,
                'volume' => $data->volume,
                'cod' => $data->cod,
                'cost' => $data->cost,
            ];

            // Decrement manifest or invoice columns
            if (boolval(array_sum($diffVals))) {
                $this->decrementOldManifestCols($data, $diffVals);
                $this->decrementOldInvoiceCols($data, $diffVals);
            }
        }

        $data->delete();
        $this->emit("deleteResult", [
            "status" => true,
            "message" => "Data " . __($this->name) . " berhasil dihapus!"
        ]);
    }

    public function mount() {
        $this->createdDate = now();
    }

    public function render()
    {
        $data = $this->get_pagination_data();

        switch ($this->name) {
            case 'package':
                $data = array_merge($data, [
                    'transitDestinations' => TransitDestination::all()->sortBy('name'),
                ]);
                break;

            default:
                # code...
                break;
        }

        return view($data['view'], $data);
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initScripts');
    }
}
