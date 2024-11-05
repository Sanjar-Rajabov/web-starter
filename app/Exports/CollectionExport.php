<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CollectionExport implements FromCollection, ShouldAutoSize
{
    public function __construct(
        public Collection $data
    )
    {
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->data;
    }
}
