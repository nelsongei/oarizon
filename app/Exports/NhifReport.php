<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NhifReport implements FromView
{
    protected $total;
    protected $data;
    protected $organization;
    protected $month;
    public function __construct($total,$data,$organization,$month)
    {
        $this->total = $total;
        $this->data = $data;
        $this->organization = $organization;
        $this->month = $month;
    }
    public function view(): View
    {
        return view('pdf.nhifTable',[
            'data'=>$this->data,
            'organization'=>$this->organization,
            'month'=>$this->month,
            'total'=>$this->total
        ]);
    }
}
