<?php

namespace App\Exports;

use App\Models\Jobgroup;
use App\Models\Loanaccount;
use App\Models\Loanrepayment;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class EmployeeExport implements WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $results = 0;

    public function collection()
    {
        //
        $jobs = Jobgroup::count();
        return $this->results = $jobs;
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
            'Mode Of Payment',
            'Account No',
        ];
    }

//    public function registerEvents(): array
//    {
//        $jobs = Jobgroup::where('organization_id', Auth::user()->organization_id)->get();
//        return [
//            AfterSheet::class => function (AfterSheet $event) use ($jobs) {
//                require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
//                $row = 2;
//                /** @var Sheet $sheet */
//                $sheet = $event->sheet;
//
//                /**
//                 * validation for bulkuploadsheet
//                 */
//                if (ob_get_level() > 0) {
//                    ob_end_clean();
//                }
//                for ($i = 0; $i < count($jobs); $i++) {
//                    if (!empty($jobs[$i])) {
//                        $sheet->setCellValue("Y" . $row, $jobs[$i]->id . ": " . $jobs[$i]->job_group_name);
//                        $row++;
//                    }
//                }
//                $sheet1 = new Spreadsheet();
//                $event->sheet->getDelegate()->getParent()
//                    ->addNamedRange(new NamedRange('ListEmployees', $event->sheet->getDelegate(), 'Y2:Y' . (count($jobs))));
////                $sheet->getParent()->addNamedRange(
////                    new NamedRange('accounts',$sheet->getDelegate(),'Y2:Y'.(count($jobs)+1),)
////                );
//                for ($i = 2; $i <= 100; $i++) {
//                    $objValidation = $sheet->getCell('L' . $i)->getDataValidation();
//                    $objValidation->setType(DataValidation::TYPE_LIST);
//                    $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
//                    $objValidation->setAllowBlank(false);
//                    $objValidation->setShowInputMessage(true);
//                    $objValidation->setShowErrorMessage(true);
//                    $objValidation->setShowDropDown(true);
//                    $objValidation->setErrorTitle('Input error');
//                    $objValidation->setError('Value is not in list.');
//                    $objValidation->setPromptTitle('Pick from list');
//                    $objValidation->setPrompt('Please pick a value from the drop-down list.');
//                    $objValidation->setFormula1($event->sheet->getCell("Y{$i}")); //note this!
//                }
//            }
//        ];
//    }
}
