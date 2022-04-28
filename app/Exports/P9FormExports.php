<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class P9FormExports implements WithHeadings, WithEvents, ShouldAutoSize
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

    public function headings(): array
    {
        return [

        ];
    }
    public function columnFormats(): array
    {
        return [
            'B'=>NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C'=>COL,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $excel) {
                $excel->sheet->getDelegate()->mergeCells('A7:A8');
                $excel->sheet->getDelegate()->mergeCells('M8:N8');
                $excel->sheet->getDelegate()->mergeCells('A22:O22');
                $excel->sheet->getDelegate()->mergeCells('A23:O23');
                $excel->sheet->getDelegate()->mergeCells('A24:O24');
                $excel->sheet->getDelegate()->mergeCells('F7:H7');
                $excel->sheet->getDelegate()->mergeCells('B7:B8');
                $excel->sheet->getDelegate()->mergeCells('C7:C8');
                $excel->sheet->getDelegate()->mergeCells('D7:D8');
                $excel->sheet->getDelegate()->mergeCells('E7:E8');
                $excel->sheet->getDelegate()->mergeCells('I7:I8');
                $excel->sheet->getDelegate()->mergeCells('J7:J8');
                $excel->sheet->setCellValue('N1', 'Employer`s PIN');
                $excel->sheet->setCellValue('O1', $this->organization->pin);
                $excel->sheet->setCellValue('N3', 'Employee`s PIN');
                $excel->sheet->setCellValue('O3', $this->employee->pin);
                if ($this->employee->middle_name != null || $this->employee->middle_name != '') {
                    $excel->sheet->setCellValue('A1', $this->employee->first_name . ' ' . $this->employee->middle_name);
                } else {
                    $excel->sheet->setCellValue('A1', $this->employee->first_name);
                }
                $excel->sheet->setCellValue('B1', $this->organization->name);
                $excel->sheet->setCellValue('C1', $this->employee->last_name);
                $excel->sheet->setCellValue('C1', $this->employee->last_name);
                $trel = 0.00;

                if ($this->year < 2017) {
                    $trel = 1162.00;
                } else if ($this->year >= 2017 && $this->year < 2018) {
                    $trel = 1280.00;
                } else {
                    $trel = 1408.00;
                }
                $coulms = array(
                    'MONTH', 'Basic Salary Kshs.', 'Benefits Non Cash Kshs.', 'Value of Quarters Kshs.', 'Total Gross Pay Kshs.', 'Defined Contribution Retirement Scheme Kshs.', '', '', 'Owner-Occupied Interest Kshs.', 'Retirement Contribution & Owner Occupied Interest', 'Chargeable Pay Kshs.', 'Tax Charged Kshs.', 'Personal Relief Kshs. ' . $trel, 'Insurance Relief Kshs.', 'PAYE Tax (J-K) Kshs.'
                );
                $excel->sheet->getDelegate()->mergeCells('F6:H6');
                $excel->sheet->setCellValue('F6',$coulms);

            }
        ];
    }
}

//        Excel::download($ename . '_P9Form_' . $year, function ($excel) use ($employee, $organization, $year) {
//            dd('He');
//            require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
//            require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");
//
//
//            $objPHPExcel = new PHPExcel();
//            // Set the active Excel worksheet to sheet 0
//            $objPHPExcel->setActiveSheetIndex(0);
//
//
//            $excel->sheet('P9 Form ' . $year, function ($sheet) use ($employee, $organization, $year, $objPHPExcel) {
//
//                $name = '';
//
//                if ($employee->middle_name != null || $employee->middle_name != '') {
//                    $name = $employee->first_name . ' ' . $employee->middle_name;
//                } else {
//                    $name = $employee->first_name;
//                }
//
//                $sheet->row(1, array(
//                    'Employer`s Name', $organization->name
//                ));
//
//                $sheet->cell('A1', function ($cell) {
//
//                    // manipulate the cell
//                    $cell->setFontWeight('bold');
//
//                });
//
//                $sheet->row(2, array(
//                    'Employee`s Main Name', $employee->last_name
//                ));
//
//                $sheet->cell('A2', function ($cell) {
//
//                    // manipulate the cell
//                    $cell->setFontWeight('bold');
//
//                });
//
//
//                $sheet->row(3, array(
//                    'Employee`s Other Names', $name
//                ));
//
//                $sheet->cell('A3', function ($cell) {
//
//                    // manipulate the cell
//                    $cell->setFontWeight('bold');
//
//                });
//
//                $sheet->setCellValue('N1', 'Employer`s PIN');
//                $sheet->setCellValue('O1', $organization->pin);
//                $sheet->setCellValue('N3', 'Employee`s PIN');
//                $sheet->setCellValue('O3', $employee->pin);
//
//                /*$sheet->row(4, array(
//                'Employer`s PIN', $organization->pin
//                ));
//  */
//                $sheet->cell('N1', function ($cell) {
//
//                    // manipulate the cell
//                    $cell->setFontWeight('bold');
//
//                });
//
//                /*$sheet->row(5, array(
//                'Employee`s PIN', $employee->pin
//                ));*/
//
//                $sheet->cell('N3', function ($cell) {
//
//                    // manipulate the cell
//                    $cell->setFontWeight('bold');
//
//                });
//
//                $trel = 0.00;
//
//                if ($year < 2017) {
//                    $trel = 1162.00;
//                } else if ($year >= 2017 && $year < 2018) {
//                    $trel = 1280.00;
//                } else {
//                    $trel = 1408.00;
//                }
//
//
//                $sheet->mergeCells('F6:H6');
//                $sheet->row(6, array(
//                    'MONTH', 'Basic Salary Kshs.', 'Benefits Non Cash Kshs.', 'Value of Quarters Kshs.', 'Total Gross Pay Kshs.', 'Defined Contribution Retirement Scheme Kshs.', '', '', 'Owner-Occupied Interest Kshs.', 'Retirement Contribution & Owner Occupied Interest', 'Chargeable Pay Kshs.', 'Tax Charged Kshs.', 'Personal Relief Kshs. ' . $trel, 'Insurance Relief Kshs.', 'PAYE Tax (J-K) Kshs.'
//                ));
//
//                $sheet->row(6, function ($r) {
//
//                    // call cell manipulation methods
//                    $r->setFontWeight('bold');
//                    $r->setAlignment('center');
//                });
//
//                $sheet->row(7, array(
//                    '', 'A', 'B', 'C', 'D', 'E', '', '', 'F Amount of Interest', 'G The Lowest of E added to F', 'H', 'J', 'K', '', 'L'
//                ));
//
//                $sheet->mergeCells('F7:H7');
//
//                $sheet->mergeCells('A7:A8');
//                $sheet->mergeCells('B7:B8');
//                $sheet->mergeCells('C7:C8');
//                $sheet->mergeCells('D7:D8');
//                $sheet->mergeCells('E7:E8');
//                $sheet->mergeCells('I7:I8');
//                $sheet->mergeCells('J7:J8');
//
//                $sheet->row(7, function ($r) {
//
//                    // call cell manipulation methods
//                    $r->setFontWeight('bold');
//                    $r->setAlignment('center');
//                });
//
//                $sheet->row(8, array(
//                    '', '', '', '', '', 'E1 30% of A', 'E2 Actual', 'E3 Fixed', '', '', '', '', 'Total Kshs. ' . $trel, ''
//                ));
//
//                $sheet->mergeCells('M8:N8');
//
//                $sheet->row(8, function ($r) {
//
//                    // call cell manipulation methods
//                    $r->setFontWeight('bold');
//                    $r->setAlignment('center');
//                });
//
//                $totalsalo = 0.00;
//                $totalgross = 0.00;
//                $totale = 0.00;
//                $totalrelief = 0.00;
//                $totalttax = 0.00;
//                $totaltax = 0.00;
//
//                for ($i = 1; $i <= 12; $i++) {
//                    $monthNum = $i;
//                    $dateObj = DateTime::createFromFormat('!m', $monthNum);
//                    $monthName = $dateObj->format('F'); // March
//                    $sheet->mergeCells('M' . ($i + 8) . ':N' . ($i + 8));
//
//                    $salo = Payroll::salo($employee, $i, $year);
//                    $gross = Payroll::pgross($employee->personal_file_number, $i, $year);
//                    $e = (30 / 100) * Payroll::salo($employee, $i, $year);
//                    $relief = Payroll::prelief($employee->id, $employee->personal_file_number, $i, $year);
//                    $ttax = Payroll::ptax($employee->personal_file_number, $i, $year) + Payroll::prelief($employee->id, $employee->personal_file_number, $i, $year);
//                    $tax = Payroll::ptax($employee->personal_file_number, $i, $year);
//
//                    $sheet->row(($i + 8), array(
//                        $monthName, $salo, 0.00, 0.00, $gross, $e, 0.00, 20000.00, 0.00, 0.00, $gross, $ttax, $relief, '', $tax
//                    ));
//
//                    $totalsalo = $salo + $totalsalo;
//                    $totalgross = $gross + $totalgross;
//                    $totale = $e + $totale;
//                    $totalrelief = $relief + $totalrelief;
//                    $totalttax = $ttax + $totalttax;
//                    $totaltax = $tax + $totaltax;
//
//                    $sheet->cell('A' . ($i + 8), function ($cell) {
//
//                        // manipulate the cell
//                        $cell->setFontWeight('bold');
//
//                    });
//
//                    $sheet->cell('A' . ($i + 8), function ($cell) {
//
//                        // manipulate the cell
//                        $cell->setFontWeight('bold');
//
//                    });
//
//                    $sheet->cell('N' . ($i + 8), function ($cell) {
//
//                        $cell->setAlignment('right');
//
//                    });
//
//                    $sheet->cell('M' . ($i + 8), function ($cell) {
//
//                        $cell->setAlignment('right');
//
//                    });
//
//                }
//
//                $sheet->mergeCells('M21:N21');
//
//                $sheet->row(21, array(
//                    'Totals', $totalsalo, 0.00, 0.00, $totalgross, $totale, 0.00, 20000.00 * 12, 0.00, 0.00, $totalgross, $totalttax, $totalrelief, '', $totaltax
//                ));
//
//                $sheet->cell('A21', function ($cell) {
//
//                    // manipulate the cell
//                    $cell->setFontWeight('bold');
//
//                });
//
//                $sheet->cell('N21', function ($cell) {
//
//                    $cell->setAlignment('right');
//
//                });
//
//                $sheet->cell('M21', function ($cell) {
//
//                    $cell->setAlignment('right');
//
//                });
//
//                $sheet->mergeCells('A22:O22');
//                $sheet->mergeCells('A23:O23');
//                $sheet->mergeCells('A24:O24');
//
//                $sheet->row(22, function ($r) {
//
//                    // call cell manipulation methods
//                    $r->setFontWeight('bold');
//                    $r->setAlignment('center');
//                });
//
//                $sheet->row(22, array(
//                    'TOTAL TAX (COLL.) Kshs. ' . $totaltax
//                ));
//
//                $sheet->row(23, array(
//                    'To be completed by Employer at end of year'
//                ));
//
//                $sheet->row(24, array(
//                    'TOTAL CHARGEABLE PAY (COL. H) Kshs. ' . $totalgross
//                ));
//
//                $sheet->row(24, function ($r) {
//
//                    // call cell manipulation methods
//                    $r->setFontWeight('bold');
//                });
//            });
//
//        })->download('xls');
