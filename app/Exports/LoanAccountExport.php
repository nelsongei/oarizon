<?php

namespace App\Exports;

use App\Models\Loanaccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class LoanAccountExport implements FromQuery
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        //
        return Loanaccount::all();
    }
}
