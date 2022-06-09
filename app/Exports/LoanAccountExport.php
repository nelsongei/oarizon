<?php

namespace App\Exports;

use App\Models\Loanaccount;
use App\Models\Member;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LoanAccountExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $rowCount=0;

    public function headings(): array
    {
        return [
            'LOAN ACCOUNT', 'DATE', 'PRINCIPAL PAID', 'INTEREST PAID',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    public function collection()
    {
        $this->rowCount = $this->registerEvents();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class=>function(AfterSheet $event){
            $sheet = $event->sheet;
            $objValidation = $sheet->getCell('A2')->getDataValidation();
            }
        ];
    }
}
