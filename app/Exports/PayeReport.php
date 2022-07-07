<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayeReport implements FromView
{
    protected $total_enabled;
    public function view(): View
    {
        return  view('pdf.payeTable',[

        ]);
    }
}
