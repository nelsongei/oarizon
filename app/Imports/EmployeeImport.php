<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Jobgroup;
use App\Models\Organization;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EmployeeImport implements ToModel,WithStartRow
{
    public function initials($str, $pfn)
    {
        $ret = '';
        foreach (explode(' ', $str) as $word) {
            if ($word == null) {
                $ret .= strtoupper($str[0]);
            } else {
                $ret .= strtoupper($word[0]);
            }
        }
        return $ret . '.' . ($pfn + 1);

    }
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $job_group_id = Jobgroup::pluck('id')->first();
        // dd($job_group_id);
        $organization = Organization::find(Auth::user()->organization_id);
        $string = $organization->name;
        $str = strtoupper($string[0].',');
        $pfn = rand(1,1000);
        return new Employee([
            'personal_file_number'=>$str.$pfn,
            'first_name'=>$row[0],
            'last_name'=>$row[1],
            'email_office'=>$row[2],
            'basic_pay'=>$row[3],
            'pin'=>$row[4],
            'social_security_number'=>$row[5],
            'identity_number'=>$row[6],
            'hospital_insurance_number'=>$row[7],
            'gender'=>$row[8],
            'mode_of_payment'=>$row[9],
            'bank_account_number'=>$row[10],
            'organization_id'=>Auth::user()->organization_id,
            'job_group_id'=>$job_group_id,
        ]);
    }
}
