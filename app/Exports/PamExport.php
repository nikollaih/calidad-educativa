<?php

namespace App\Exports;

use App\Models\PamAccion;
use Maatwebsite\Excel\Concerns\FromCollection;

class PamExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PamAccion::all();
    }
}
