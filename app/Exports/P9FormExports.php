<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class P9FormExports implements ShouldAutoSize, FromView
{
    protected $year;
    protected $employee;
    protected $organization;

    public function __construct($year, $employee, $organization)
    {
        $this->year = $year;
        $this->employee = $employee;
        $this->organization = $organization;
    }

    public function view(): View
    {
        return view('pdf.p9Table');
    }
}
