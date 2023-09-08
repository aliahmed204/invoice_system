<?php

namespace App\Exports;

use App\Models\Invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

class UnpaidInvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoices::where('value_status','=','2')->get();
    }
}
