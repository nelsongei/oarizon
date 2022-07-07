<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NssfReport implements FromView,ShouldAutoSize
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
    public function  view(): View
    {
        return view('pdf.nssfTable',[
            'data'=>$this->data,
            'organization'=>$this->organization,
            'total'=>$this->total,
            'month'=>$this->month
        ]);
    }
}
