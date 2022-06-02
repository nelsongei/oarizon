<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\traits\Encryptable;


class Employee extends Model
{
    protected $table = "x_employee";

    protected $encryptable = [

        'basic_pay',
    ];
    // Add your validation rules here
    public static $rules = [
        'personal_file_number' => 'required|unique:x_employee,personal_file_number',
        'lname' => 'required',
        'fname' => 'required',
        'identity_number' => 'required|unique:x_employee,identity_number',
        'dob' => 'required',
        'gender' => 'required',
        'jgroup_id' => 'required',
        'type_id' => 'required',
        'pay' => 'required|regex:/^(\$?(?(?=\()(\())\d+(?:,\d+)?(?:\.\d+)?(?(2)\)))$/',
        'djoined' => 'required',
        'email_office' => 'required|email|unique:x_employee,email_office',
        'email_personal' => 'email|unique:x_employee,email_personal',
        'passport_number' => 'unique:x_employee,passport_number',
        'work_permit_number' => 'unique:x_employee,work_permit_number',
        'pin' => 'unique:x_employee,pin',
        'social_security_number' => 'unique:x_employee',
        'hospital_insurance_number' => 'unique:x_employee,hospital_insurance_number',
        'telephone_mobile' => 'unique:x_employee,telephone_mobile',
        'swift_code' => 'unique:x_employee,swift_code',
        'bank_account_number' => 'unique:x_employee,bank_account_number',
        'bank_eft_code' => 'unique:x_employee,bank_eft_code'

    ];

    public static function rolesUpdate($id)
    {
        return array(
            'personal_file_number' => 'required|unique:x_employee,personal_file_number,' . $id,
            'lname' => 'required',
            'fname' => 'required',
            'identity_number' => 'required|unique:x_employee,identity_number,' . $id,
            'dob' => 'required',
            'gender' => 'required',
            'pay' => 'required|regex:/^(\$?(?(?=\()(\())\d+(?:,\d+)?(?:\.\d+)?(?(2)\)))$/',
            'jgroup_id' => 'required',
            'type_id' => 'required',
            'djoined' => 'required',
            'email_office' => 'required|email|unique:x_employee,email_office,' . $id,
            'email_personal' => 'email|unique:x_employee,email_personal,' . $id,
            'passport_number' => 'unique:x_employee,passport_number,' . $id,
            'work_permit_number' => 'unique:x_employee,work_permit_number,' . $id,
            'pin' => 'unique:x_employee,pin,' . $id,
            'social_security_number' => 'unique:x_employee,social_security_number,' . $id,
            'hospital_insurance_number' => 'unique:x_employee,hospital_insurance_number,' . $id,
            'telephone_mobile' => 'unique:x_employee,telephone_mobile,' . $id,
            'swift_code' => 'unique:x_employee,swift_code,' . $id,
            'bank_account_number' => 'unique:x_employee,bank_account_number,' . $id,
            'bank_eft_code' => 'unique:x_employee,bank_eft_code,' . $id
        );
    }

    public static $messages = array(
        'personal_file_number.required' => 'Please insert employee`s personal file number!',
        'personal_file_number.unique' => 'That personal file number already exists!',
        'fname.required' => 'Please insert employee`s first name!',
        'lname.required' => 'Please insert employee`s last name!',
        'gender.required' => 'Please insert employee`s gender!',
        'djoined.required' => 'Please insert date employee joined the company!',
        'dob.required' => 'Please insert employee`s date of birth!',
        'jgroup_id.required' => 'Please insert Employee`s job group!',
        'type_id.required' => 'Please insert employee`s type!',
        'pay.required' => 'Please insert employee`s basic salary!',
        'identity_number.required' => 'Please insert employee`s identity number!',
        'identity_number.unique' => 'That identity number already exists!',
        'pay.required' => 'Please insert basic pay or 0.00 if employee has no salary!',
        'pay.regex' => 'Please insert a valid salary!',
        'email_office.required' => 'Please insert employee`s office email!',
        'email_office.unique' => 'That employee`s office email already exists!',
        'email_personal.unique' => 'That employee personal email already exists!',
        'passport_number.unique' => 'That passport number already exists!',
        'work_permit_number.unique' => 'That work permit number already exists!',
        'pin.unique' => 'That kra pin already exists!',
        'social_security_number.unique' => 'That nssf number already exists!',
        'hospital_insurance_number.unique' => 'That nhif number already exists!',
        'telephone_mobile.unique' => 'That mobile number already exists!',
        'swift_code.unique' => 'That swift code already exists!',
        'bank_account_number.unique' => 'That bank account number already exists!',
        'bank_eft_code.unique' => 'That bank eft code already exists!',
    );

    // Don't forget to fill this array
    protected $fillable = [
        'personal_file_number',
        'first_name',
        'last_name',
        'email_office',
        'basic_pay',
        'pin',
        'social_security_number',
        'identity_number',
        'hospital_insurance_number',
        'gender',
        'mode_of_payment',
        'bank_account_number',
        'organization_id',
    ];


    public function branch()
    {

        return $this->belongsTo(Branch::class);
    }

    public function promotion()
    {

        return $this->hasMany(Promotion::class);
    }


    public function department()
    {

        return $this->belongsTo(Department::class);
    }

    public function jobgroup()
    {

        return $this->belongsTo(Jobgroup::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leaveapplication::class, 'employee_id');
    }

    public function office_shift()
    {
        return $this->hasOne(OfficeShift::class, 'id', 'office_shift_id');
    }

    public function jobtitle()
    {

        return $this->belongsTo(JobTitle::class);
    }


    public function allowances()
    {
        return $this->belongsTo(EAllowances::class);
    }

    public function reliefs()
    {
        return $this->belongsTo(ERelief::class);
    }

    public function benefits()
    {
        return $this->belongsTo(Earnings::class);
    }

    public function employee_attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function Leaveapplications()
    {

        return $this->hasMany(Leaveapplication::class);
    }

    public function employeenontaxables()
    {

        return $this->hasMany(Employeenontaxable::class);
    }

    public function occurences()
    {

        return $this->hasMany(Occurence::class);
    }

    public function citizenship()
    {

        return $this->belongsTo(Citizenship::class);
    }

    public function member()
    {

        return $this->belongsTo(Member::class);
    }

    public function education()
    {

        return $this->hasMany(Education::class);
    }

    public function pension()
    {

        return $this->hasMany(Pension::class);
    }


    public static function getEmployeeName($id)
    {

        $employee = Employee::findOrFail($id);
        $name = $employee->personal_file_number . '-' . $employee->first_name . ' ' . $employee->last_name;

        return $name;
    }


    public static function getActiveEmployee()
    {

        $employee = DB::table('x_employee')->where('in_employment', '=', 'Y')->where('organization_id', Auth::user()->organization_id)->get();

        return $employee;
    }

    public static function getDeactiveEmployee()
    {

        $employee = DB::table('x_employee')->where('in_employment', '=', 'N')->where('organization_id', Auth::user()->organization_id)->get();

        return $employee;
    }

}
