<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
    public function headings(): array
    {
        return [
            'Firstname',
            'Surname',
            'Email',
            'Basic Salary',
            'KRA PIN',
            'NSSF NO',
            'ID NO',
            'NHIF No',
            'Gender',
            'Mode Of Paymet',
            'Account No',
        ];
    }
}
