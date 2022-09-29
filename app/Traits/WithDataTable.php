<?php

namespace App\Traits;

use \Carbon\Carbon;

trait WithDataTable
{

    public function get_pagination_data()
    {
        switch ($this->name) {
            case 'user':
                $users = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.user',
                    "users" => $users,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('user.new'),
                            'create_new_text' => 'Buat User Baru',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            case 'package':
                $sortFieldArr =  explode('.', $this->sortField);
                $sortAsc = $this->sortAsc ? 'asc' : 'desc';

                $packages = $this->model::search($this->search);

                if (count($sortFieldArr) === 3) {
                    $packages = $packages->with([$sortFieldArr[0] => function ($query) use ($sortFieldArr, $sortAsc) {
                        $query->with([$sortFieldArr[1] => function ($query) use ($sortFieldArr, $sortAsc) {
                            $query->orderBy($sortFieldArr[2], $sortAsc);
                        }]);
                    }]);
                } else {
                    $packages = $packages->orderBy($this->sortField, $sortAsc);
                }

                if(!empty($this->transitDestinationId)) {
                    $packages = $packages->whereHas('manifest', function ($query) {
                        return $query->where('transit_destination_id', $this->transitDestinationId);
                    });
                }

                if(!empty($this->createdDate)) {
                    $createdDate = Carbon::parse($this->createdDate)->format('Y-m-d');

                    $packages = $packages->whereDate('created_at', $createdDate);
                }

                $packages = $packages->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.package',
                    "packages" => $packages,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('packages.create'),
                            'create_new_text' => 'Input Barang',
                            'export' => '#',
                            'export_text' => 'Export',
                            'export_image' => route('packages.image', ['transit_destination_id' => $this->transitDestinationId, 'created_date' => $createdDate]),
                            'export_image_text' => 'Download File Gambar',
                        ],
                    ]),
                ];
                break;

            default:
                # code...
                break;
        }
    }
}
