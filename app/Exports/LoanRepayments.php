<?php

namespace App\Exports;

use App\Models\Loanaccount;
use App\Models\Loanrepayment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoanRepayments implements FromArray, WithHeadings, FromQuery,ShouldAutoSize
{
    use Exportable;

//    public function __construct(int $y)
//    {
//    }

    /**
     * @return Loanaccount[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection
     */
    public function query()
    {
        return Loanaccount::where('is_disbursed', '1')->get();
    }

    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'LOAN ACCOUNT', 'DATE', 'PRINCIPAL PAID', 'INTEREST PAID',
        ];
    }
}
