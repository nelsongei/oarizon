<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayeReport implements FromView
{
    protected $total_enabled;
    protected $total_disabled;
    protected $payes_enabled;
    protected $payes_disabled;
    protected $organization;
    protected $period;
    protected $type;
    protected $month;
    protected $currencies;
    public function __construct($total_enabled,$total_disabled,$payes_enabled,$payes_disabled,$organization,$period,$type,$month,$currencies)
    {
        $this->total_enabled = $total_enabled;
        $this->total_disabled=$total_disabled;
        $this->payes_enabled = $payes_enabled;
        $this->payes_disabled = $payes_disabled;
        $this->organization = $organization;
        $this->period = $period;
        $this->type = $type;
        $this->month = $month;
        $this->currencies = $currencies;
    }

    public function view(): View
    {
        return  view('pdf.payeTable',[
            'total_enabled'=>$this->total_enabled,
            'total_disabled'=>$this->total_disabled,
            'payes_enabled'=>$this->payes_enabled,
            'payes_disabled'=>$this->payes_disabled,
            'organization'=>$this->organization,
            'period'=>$this->period,
            'type'=>$this->type,
            'month'=>$this->month,
            'currencies'=>$this->currencies
        ]);
    }
}
