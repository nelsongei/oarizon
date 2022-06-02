<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use App\Models\Appraisal;
use App\Models\Audit;
use App\Models\Bank;
use App\Models\BBranch;
use App\Models\Branch;
use App\Models\Citizenship;
use App\Models\Currency;
use App\Models\Department;
use App\Models\Document;
use App\Models\Education;
use App\Models\Employee;
use App\Models\Employeebenefit;
use App\Models\EType;
use App\Http\Controllers\Controller;
use App\Models\Jobgroup;
use App\Models\JobTitle;
use App\Models\Mailsender;
use App\Models\Nextofkin;
use App\Models\Occurence;
use App\Models\Organization;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class EmployeesController extends Controller
{

    /*
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $employees = Employee::getActiveEmployee();

        Audit::logaudit(now(), 'view', 'viewed employee list');

        return view('employees.index', compact('employees'));
    }

    public function getEmployees()
    {
        return Employee::getActiveEmployee();
    }

    public function createcitizenship(Request $request)
    {
        $postcitizen = $request->all();
        $data = array('name' => $postcitizen['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('citizenships')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Citizenships', 'create', 'created: ' . $postcitizen['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createeducation(Request $request)
    {
        $posteducation = $request->all();
        $data = array('education_name' => $posteducation['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('education')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Educations', 'create', 'created: ' . $posteducation['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createjobtitle(Request $request)
    {
        $postjobtitle = $request->all();
        $data = array('job_title' => $postjobtitle['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_jobtitles')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Job Title', 'create', 'created: ' . $postjobtitle['name']);
            return $check;
        } else {
            return 1;
        }

    }


    public function createbank(Request $request)
    {
        $postbank = $request->all();
        $data = array('bank_name' => $postbank['name'],
            'bank_code' => $postbank['code'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('banks')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Banks', 'create', 'created: ' . $postbank['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createbankbranch(Request $request)
    {
        $postbankbranch = $request->all();
//        dd($postbankbranch);
        $data = array('bank_branch_name' => $postbankbranch['name'],
            'branch_code' => $postbankbranch['code'],
            'bank_id' => $postbankbranch['bid'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('bank_branches')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $postbankbranch['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createbranch(Request $request)
    {
        $postbranch = $request->all();
        $data = array('name' => $postbranch['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_branches')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $postbranch['name']);
            return $check;
        } else {
            return 1;
        }

    }


    public function createdepartment(Request $request)
    {
        $postdept = $request->all();
        $data = array('name' => $postdept['name'],
            'codes' => $postdept['code'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_departments')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $postdept['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createtype(Request $request)
    {
        $posttype = $request->all();
        $data = array('employee_type_name' => $posttype['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_employee_type')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $posttype['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function creategroup(Request $request)
    {
        $postgroup = $request->all();
        $data = array('job_group_name' => $postgroup['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_job_group')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $postgroup['name']);
            return $check;
        } else {
            return 1;
        }

    }

    /*
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $organization = Organization::find(Auth::user()->organization_id);

        $employees = count(Employee::where('organization_id', Auth::user()->organization_id)->get());

        #echo "<pre>"; print_r($organization->licensed); echo "</pre>"; die;
        if ($organization->licensed <= $employees) {
            return View::make('employees.employeelimit');
        } else {
            $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();
            $branches = Branch::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
            $departments = Department::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
            $jgroups = Jobgroup::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
            $jobtitles = JobTitle::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
            $etypes = EType::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
            $banks = Bank::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
            $bbranches = BBranch::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
            $educations = Education::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
            $citizenships = Citizenship::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
            $pfn = 0;
            if (Employee::where('organization_id', Auth::user()->organization_id)->orderBy('id', 'DESC')->count() == 0) {
                $pfn = 0;
            } else {
                $pfn = Employee::where('organization_id', Auth::user()->organization_id)->orderBy('id', 'DESC')->pluck('personal_file_number');
                $pfn = preg_replace('/\D/', '', $pfn);

            }
            return View::make('employees.create', compact('currency', 'citizenships', 'pfn', 'branches', 'departments', 'jobtitles', 'etypes', 'jgroups', 'banks', 'bbranches', 'educations'));
        }
    }

    /*
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'education' => 'required',
            'pin' => 'required|unique:x_employee',
            'swift_code' => 'unique:x_employee',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        try {
            $employee = new Employee;

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $name = time() . '-' . $file->getClientOriginalName();
                $file = $file->move('public/uploads/employees/photo', $name);
                $input['file'] = '/public/uploads/employees/photo' . $name;
                $employee->photo = $name;
            } else {
                $employee->photo = 'default_photo.png';
            }

            if ($request->hasFile('signature')) {

                $file = $request->file('signature');
                $name = time() . '-' . $file->getClientOriginalName();
                $file = $file->move('public/uploads/employees/signature/', $name);
                $input['file'] = '/public/uploads/employees/signature/' . $name;
                $employee->signature = $name;
            } else {
                $employee->signature = 'sign_av.jpg';
            }
            $employee->personal_file_number = $request->get('personal_file_number');
            $employee->first_name = $request->get('fname');
            $employee->last_name = $request->get('lname');
            $employee->middle_name = $request->get('mname');
            $employee->identity_number = $request->get('identity_number');
            $employee->military_id = $request->get('military_id');
            if ($request->get('passport_number') != null) {
                $employee->passport_number = $request->get('passport_number');
            } else {
                $employee->passport_number = null;
            }
            if ($request->get('pin') != null) {
                $employee->pin = $request->get('pin');
            } else {
                $employee->pin = null;
            }
            if ($request->get('social_security_number') != null) {
                $employee->social_security_number = $request->get('social_security_number');
            } else {
                $employee->social_security_number = null;
            }
            if ($request->get('hospital_insurance_number') != null) {
                $employee->hospital_insurance_number = $request->get('hospital_insurance_number');
            } else {
                $employee->hospital_insurance_number = null;
            }
            if ($request->get('work_permit_number') != null) {
                $employee->work_permit_number = $request->get('work_permit_number');
            } else {
                $employee->work_permit_number = null;
            }
            $employee->job_title = $request->get('jtitle');
            if ($request->get('education') == '') {
                $employee->education_type_id = null;
            } else {
                $employee->education_type_id = $request->get('education');
            }
            $a = str_replace(',', '', $request->get('pay'));
            $employee->basic_pay = $a;
            $employee->gender = $request->get('gender');
            $employee->marital_status = $request->get('status');
            $employee->yob = $request->get('dob');
            if ($request->get('citizenship') == '') {
                $employee->citizenship_id = null;
            } else {
                $employee->citizenship_id = $request->get('citizenship');
            }
            $employee->mode_of_payment = $request->get('modep');
            if ($request->get('bank_account_number') != null) {
                $employee->bank_account_number = $request->get('bank_account_number');
            } else {
                $employee->bank_account_number = null;
            }
            if ($request->get('bank_eft_code') != null) {
                $employee->bank_eft_code = $request->get('bank_eft_code');
            } else {
                $employee->bank_eft_code = null;
            }
            if ($request->get('swift_code') != null) {
                $employee->swift_code = $request->get('swift_code');
            } else {
                $employee->swift_code = null;
            }
            if ($request->get('email_office') != null) {
                $employee->email_office = $request->get('email_office');
            } else {
                $employee->email_office = null;
            }
            if ($request->get('email_personal') != null) {
                $employee->email_personal = $request->get('email_personal');
            } else {
                $employee->email_personal = null;
            }
            if ($request->get('telephone_mobile') != null) {
                $employee->telephone_mobile = $request->get('telephone_mobile');
            } else {
                $employee->telephone_mobile = null;
            }
            $employee->postal_address = $request->get('address');
            $employee->postal_zip = $request->get('zip');
            $employee->date_joined = date('Y-m-d', strtotime($request->get('djoined')));
            if ($request->get('bank_id') == '') {
                $employee->bank_id = null;
            } else {
                $employee->bank_id = $request->get('bank_id');
            }
            if ($request->get('bbranch_id') == '') {
                $employee->bank_branch_id = null;
            } else {
                $employee->bank_branch_id = $request->get('bbranch_id');
            }
            if ($request->get('branch_id') == '') {
                $employee->branch_id = null;
            } else {
                $employee->branch_id = $request->get('branch_id');
            }
            if ($request->get('department_id') == '') {
                $employee->department_id = null;
            } else {
                $employee->department_id = $request->get('department_id');
            }
            if ($request->get('jgroup_id') == '') {
                $employee->job_group_id = null;
            } else {
                $employee->job_group_id = $request->get('jgroup_id');
            }
            if ($request->get('type_id') == '') {
                $employee->type_id = null;
            } else {
                $employee->type_id = $request->get('type_id');
            }
            if ($request->get('i_tax') != null) {
                $employee->income_tax_applicable = '1';
            } else {
                $employee->income_tax_applicable = '0';
            }
            if ($request->get('i_tax_relief') != null) {
                $employee->income_tax_relief_applicable = '1';
            } else {
                $employee->income_tax_relief_applicable = '0';
            }
            if ($request->get('a_nhif') != null) {
                $employee->hospital_insurance_applicable = '1';
            } else {
                $employee->hospital_insurance_applicable = '0';
            }
            if ($request->get('a_nssf') != null) {
                $employee->social_security_applicable = '1';
            } else {
                $employee->social_security_applicable = '0';
            }
            $employee->custom_field1 = $request->get('omode');
            $employee->organization_id = Auth::user()->organization_id;
            $employee->start_date = $request->get('startdate');
            $employee->end_date = $request->get('enddate');
            if ($request->get('active') != null) {
                $employee->in_employment = 'Y';
            } else {
                $employee->in_employment = 'N';
            }
            $employee->save();

            Audit::logaudit('Employee', 'create', 'created: ' . $employee->personal_file_number . '-' . $employee->first_name . ' ' . $employee->last_name);

            $insertedId = $employee->id;
            if (($request->get('kin_first_name')[0]) !== null) {
                for ($i = 0; $i < count($request->get('kin_first_name')); $i++) {
                    if (($request->get('kin_first_name')[$i] != '' || $request->get('kin_first_name')[$i] != null) && ($request->get('kin_last_name')[$i] != '' || $request->get('kin_last_name')[$i] != null)) {
                        $kin = new Nextofkin;
                        $kin->employee_id = $insertedId;
                        $kin->kin_name = $request->get('kin_first_name')[$i] . ' ' . $request->get('kin_last_name')[$i] . ' ' . $request->get('kin_middle_name')[$i];
                        $kin->relation = $request->get('relationship')[$i];
                        $kin->contact = $request->get('contact')[$i];
                        $kin->id_number = $request->get('id_number')[$i];

                        $kin->save();

                        Audit::logaudit('NextofKins', 'create', 'created: ' . $request->get('kin_first_name')[$i] . ' for ' . Employee::getEmployeeName($insertedId));
                    }
                }
            }
            $files = $request->file('path');
            $j = 0;
            if (($request->get('doc_name')[0]) !== null) {
                foreach ($files as $file) {

                    if ($request->hasFile('path') && ($request->get('doc_name')[$j] != null || $request->get('doc_name')[$j] != '')) {
                        $document = new Document;

                        $document->employee_id = $insertedId;

                        $name = time() . '-' . $file->getClientOriginalName();
                        $file = $file->move('public/uploads/employees/documents/', $name);
                        $input['file'] = '/public/uploads/employees/documents/' . $name;
                        $extension = pathinfo($name, PATHINFO_EXTENSION);
                        $document->document_path = $name;
                        $document->document_name = $request->get('doc_name')[$j] . '.' . $extension;
                        $document->type = $request->get('type')[$j];
                        $document->save();

                        Audit::logaudit('Documents', 'create', 'created: ' . $request->get('doc_name')[$j] . ' for ' . Employee::getEmployeeName($insertedId));
                        $j = $j + 1;
                    }
                }
            }

            return Redirect::route('employees.index')->withFlashMessage('Employee successfully created!');
        } catch (\Exception $e) {
//            return Redirect::back()->withInput()->withErrors($e);
            return $e;
        }
    }

    public function getIndex()
    {
        return Redirect::route('employees.index')->withFlashMessage('Employee successfully created!');
    }

    public function exportTemplate()
    {
        return Excel::download(new EmployeeExport, 'EmployeeTemplate.xlsx');
    }

    /*
     * Import Employees
     * */
    public function importEmployees()
    {
        $import = Excel::import(new EmployeeImport, request()->file('file'));
        if ($import) {
            return redirect()->back()->withFlashMessage('Employee successfully Uploaded!');
        } else {
            return redirect()->back()->withFlashMessage('Employee successfully Uploaded!');
        }

    }

    public function serializeDoc(Request $request)
    {

        parse_str($request->get('docinfo'), $data);

        return $data;
    }

    /*
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return View::make('employees.show', compact('employee'));
    }

    /*
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $branches = Branch::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $departments = Department::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $jgroups = Jobgroup::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $etypes = EType::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $citizenships = Citizenship::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $contract = DB::table('x_employee')
            ->join('x_employee_type', 'x_employee.type_id', '=', 'x_employee_type.id')
            ->where('type_id', 2)
            ->first();
        $banks = Bank::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $bbranches = BBranch::where('bank_id', $employee->bank_id)->whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $educations = Education::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $kins = Nextofkin::where('employee_id', $id)->get();
        $docs = Document::where('employee_id', $id)->get();
        $countk = Nextofkin::where('employee_id', $id)->count();
        $countd = Document::where('employee_id', $id)->count();
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();


        return view('employees.edit', compact('currency', 'countk', 'countd', 'docs', 'kins', 'citizenships', 'contract', 'branches', 'educations', 'departments', 'etypes', 'jgroups', 'banks', 'bbranches', 'employee'));
    }

    /*
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $validator = Validator::make($request->all(), Employee::rolesUpdate($employee->id), Employee::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '-' . $file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/photo', $name);
            $input['file'] = '/public/uploads/employees/photo' . $name;
            $employee->photo = $name;
        } else {
            $employee->photo = $request->get('photo');
        }

        if ($request->hasFile('signature')) {

            $file = $request->file('signature');
            $name = time() . '-' . $file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/signature/', $name);
            $input['file'] = '/public/uploads/employees/signature/' . $name;
            $employee->signature = $name;
        } else {
            $employee->signature = $request->get('sign');
        }

        $employee->personal_file_number = $request->get('personal_file_number');
        $employee->first_name = $request->get('fname');
        $employee->last_name = $request->get('lname');
        $employee->middle_name = $request->get('mname');
        $employee->identity_number = $request->get('identity_number');
        if ($request->get('passport_number') != null) {
            $employee->passport_number = $request->get('passport_number');
        } else {
            $employee->passport_number = null;
        }
        if ($request->get('pin') != null) {
            $employee->pin = $request->get('pin');
        } else {
            $employee->pin = null;
        }
        if ($request->get('social_security_number') != null) {
            $employee->social_security_number = $request->get('social_security_number');
        } else {
            $employee->social_security_number = null;
        }
        if ($request->get('hospital_insurance_number') != null) {
            $employee->hospital_insurance_number = $request->get('hospital_insurance_number');
        } else {
            $employee->hospital_insurance_number = null;
        }
        if ($request->get('work_permit_number') != null) {
            $employee->work_permit_number = $request->get('work_permit_number');
        } else {
            $employee->work_permit_number = null;
        }
        $employee->job_title = $request->get('jtitle');
        if ($request->get('education') == '') {
            $employee->education_type_id = null;
        } else {
            $employee->education_type_id = $request->get('education');
        }
        $a = str_replace(',', '', $request->get('pay'));
        $employee->basic_pay = $a;
        $employee->gender = $request->get('gender');
        $employee->marital_status = $request->get('status');
        $employee->yob = $request->get('dob');
        if ($request->get('citizenship') == '') {
            $employee->citizenship_id = null;
        } else {
            $employee->citizenship_id = $request->get('citizenship');
        }
        $employee->mode_of_payment = $request->get('modep');
        if ($request->get('bank_account_number') != null) {
            $employee->bank_account_number = $request->get('bank_account_number');
        } else {
            $employee->bank_account_number = null;
        }
        if ($request->get('bank_eft_code') != null) {
            $employee->bank_eft_code = $request->get('bank_eft_code');
        } else {
            $employee->bank_eft_code = null;
        }
        if ($request->get('swift_code') != null) {
            $employee->swift_code = $request->get('swift_code');
        } else {
            $employee->swift_code = null;
        }
        if ($request->get('email_office') != null) {
            $employee->email_office = $request->get('email_office');
        } else {
            $employee->email_office = null;
        }
        if ($request->get('email_personal') != null) {
            $employee->email_personal = $request->get('email_personal');
        } else {
            $employee->email_personal = null;
        }
        if ($request->get('telephone_mobile') != null) {
            $employee->telephone_mobile = $request->get('telephone_mobile');
        } else {
            $employee->telephone_mobile = null;
        }
        $employee->postal_address = $request->get('address');
        $employee->postal_zip = $request->get('zip');
        $employee->date_joined = date('Y-m-d', strtotime($request->get('djoined')));
        if ($request->get('bank_id') == '') {
            $employee->bank_id = null;
        } else {
            $employee->bank_id = $request->get('bank_id');
        }
        if ($request->get('bbranch_id') == '') {
            $employee->bank_branch_id = null;
        } else {
            $employee->bank_branch_id = $request->get('bbranch_id');
        }
        if ($request->get('branch_id') == '') {
            $employee->branch_id = null;
        } else {
            $employee->branch_id = $request->get('branch_id');
        }
        if ($request->get('department_id') == '') {
            $employee->department_id = null;
        } else {
            $employee->department_id = $request->get('department_id');
        }
        if ($request->get('jgroup_id') == '') {
            $employee->job_group_id = null;
        } else {
            $employee->job_group_id = $request->get('jgroup_id');
        }
        if ($request->get('type_id') == '') {
            $employee->type_id = null;
        } else {
            $employee->type_id = $request->get('type_id');
        }
        if ($request->get('i_tax') != null) {
            $employee->income_tax_applicable = '1';
        } else {
            $employee->income_tax_applicable = '0';
        }
        if ($request->get('i_tax_relief') != null) {
            $employee->income_tax_relief_applicable = '1';
        } else {
            $employee->income_tax_relief_applicable = '0';
        }
        if ($request->get('a_nhif') != null) {
            $employee->hospital_insurance_applicable = '1';
        } else {
            $employee->hospital_insurance_applicable = '0';
        }
        if ($request->get('a_nssf') != null) {
            $employee->social_security_applicable = '1';
        } else {
            $employee->social_security_applicable = '0';
        }
        $employee->custom_field1 = $request->get('omode');
        $employee->organization_id = Auth::user()->organization_id;
        $employee->start_date = $request->get('startdate');
        $employee->end_date = $request->get('enddate');
        if ($request->get('active') != null) {
            $employee->in_employment = 'Y';
        } else {
            $employee->in_employment = 'N';
        }

        $employee->update();

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'update', 'updated: ' . $employee->personal_file_number . '-' . $employee->first_name . ' ' . $employee->last_name);

        Nextofkin::where('employee_id', $id)->delete();
        for ($i = 0; $i < count($request->get('kin_first_name')); $i++) {
            if (($request->get('kin_first_name')[$i] != '' || $request->get('kin_first_name')[$i] != null) && ($request->get('kin_last_name')[$i] != '' || $request->get('kin_last_name')[$i] != null)) {
                $kin = new Nextofkin;
                $kin->employee_id = $id;
                $kin->kin_name = $request->get('kin_first_name')[$i] . ' ' . $request->get('kin_last_name')[$i] . ' ' . $request->get('kin_middle_name')[$i];
                $kin->relation = $request->get('relationship')[$i];
                $kin->contact = $request->get('contact')[$i];
                $kin->id_number = $request->get('id_number')[$i];
                $kin->save();

                Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'create', 'created: ' . $request->get('kin_first_name')[$i] . ' for ' . Employee::getEmployeeName($id));
            }
        }

        Document::where('employee_id', $id)->delete();
        $files = $request->file('path');
        $j = 0;
        if ($files === null) {

        } else {
            foreach ($files as $file) {
                if ($request->get('doc_name')[$j] != null || $request->get('doc_name')[$j] != '') {
                    $document = new Document;
                    $document->employee_id = $id;
                    if ($file) {

                        $name = time() . '-' . $file->getClientOriginalName();
                        //dd($name);
                        $file = $file->store('uploads/employees/documents', 'public', $name);
                        $input['file'] = '/public/uploads/employees/documents/' . $name;
                        $extension = pathinfo($name, PATHINFO_EXTENSION);
                        $document->document_path = $name;
                        $document->document_name = $request->get('doc_name')[$j] . '.' . $extension;

                    } else {
                        $name = $request->get('curpath')[$j];
                        $extension = pathinfo($name, PATHINFO_EXTENSION);
                        $document->document_path = $name;
                        $document->document_name = $request->get('doc_name')[$j] . '.' . $extension;

                    }

                    //$document->description = $request->get('description')[$j];

                    //$document->from_date = $request->get('fdate')[$j];

                    //$document->expiry_date = $request->get('edate')[$j];

                    $document->save();

                    Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'create', 'created: ' . $request->get('doc_name')[$j] . ' for ' . Employee::getEmployeeName($id));
                    $j = $j + 1;
                }
            }
        }


        if (Auth::user()->user_type == 'employee') {
            return Redirect::to('dashboard');
        } else {
            return Redirect::route('employees.index')->withFlashMessage('Employee successfully updated!');
        }

    }

    /*
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        $employee = Employee::findOrFail($id);

        Employee::destroy($id);
        $date = now();
        $user = Auth::user()->username;
        Audit::logaudit($date, $user, 'deleted: ' . $employee->personal_file_number . '-' . $employee->first_name . ' ' . $employee->last_name);


        return Redirect::route('employees.index')->withDeleteMessage('Employee successfully deleted!');
    }

    public function deactivate($id)
    {

        $employee = Employee::findOrFail($id);

        DB::table('x_employee')->where('id', $id)->update(array('in_employment' => 'N', 'termination_date' => date('Y-m-d')));

        Audit::logaudit('Employee', 'deactivate', 'deactivated: ' . $employee->personal_file_number . '-' . $employee->first_name . ' ' . $employee->last_name . ' on ' . date('Y-m-d'));


        return Redirect::route('employees.index')->withDeleteMessage('Employee successfully deactivated!');
    }

    public function activate($id)
    {

        $employee = Employee::findOrFail($id);

        DB::table('x_employee')->where('id', $id)->update(array('in_employment' => 'Y', 'termination_date' => null));

        Audit::logaudit('Employee', 'activate', 'activated: ' . $employee->personal_file_number . '-' . $employee->first_name . ' ' . $employee->last_name . ' on ' . date('Y-m-d'));


        return Redirect::to('deactives')->withFlashMessage($employee->personal_file_number . '-' . $employee->first_name . ' ' . $employee->last_name . ' successfully activated!');
    }

    public function view($id)
    {
        $employee = Employee::find($id);

        $appraisals = Appraisal::where('employee_id', $id)->get();


        $kins = Nextofkin::where('employee_id', $id)->get();

        $occurences = Occurence::where('employee_id', $id)->get();

        $properties = Property::where('employee_id', $id)->get();

        $documents = Document::where('employee_id', $id)->get();

        $benefits = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->get();

        $count = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->count();

        $organization = Organization::find(Auth::user()->organization_id);
        return View::make('employees.view', compact('employee', 'appraisals', 'kins', 'documents', 'occurences', 'properties', 'count', 'benefits'));

    }

    public function viewdeactive($id)
    {

        $employee = Employee::find($id);

        $appraisals = Appraisal::where('employee_id', $id)->get();

        $kins = Nextofkin::where('employee_id', $id)->get();

        $occurences = Occurence::where('employee_id', $id)->get();

        $properties = Property::where('employee_id', $id)->get();

        $documents = Document::where('employee_id', $id)->get();

        $benefits = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->get();

        $count = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->count();

        $organization = Organization::find(Auth::user()->organization_id);

        return View::make('employees.viewdeactive', compact('employee', 'appraisals', 'kins', 'documents', 'occurences', 'properties', 'count', 'benefits'));

    }

    public function activateportal($id)
    {

        $employee = Employee::find($id);


        $password = strtoupper(str_random(8));


        $email = $employee->email_office;
        $name = $employee->first_name . ' ' . $employee->last_name;

        if ($email != null) {


            if (Mailsender::checkConnection() == false) {

                return Redirect::back()->with('notice', 'Employee has not been activated. Could not establish interenet connection. kindly check your mail settings');
            }

            DB::table('users')->insert(
                array('email' => $employee->email_office,
                    'username' => $employee->personal_file_number,
                    'password' => Hash::make($password),
                    'user_type' => 'employee',
                    'confirmation_code' => md5(uniqid(mt_rand(), true)),
                    'confirmed' => 1,
                    'organization_id' => Auth::user()->organization_id
                )
            );


            $employee->is_css_active = true;
            $employee->update();


            Mail::queue('emails.password', array('password' => $password, 'name' => $name), function ($message) use ($employee) {
                $message->to($employee->email_office)->subject('Self Service Portal Credentials');
            });


            return Redirect::back()->with('notice', 'Employee has been activated and login credentials emailed');

        } else {

            return Redirect::back()->with('notice', 'Employee has not been activated kindly update email address');

        }
    }


    public function deactivateportal($id)
    {


        $employee = Employee::find($id);

        DB::table('users')->where('username', '=', $employee->personal_file_number)->delete();

        $employee->is_css_active = false;
        $employee->update();


        return Redirect::back()->with('notice', 'Employee has been deactivated');;


    }
    /*public function promote_transfer(){

    $employee = Employee::findOrFail($id);

    $user_id = DB::table('users')->where('organization_id',Auth::user()->organization_id)->where('username', '=', $employee->personal_file_number)->pluck('id');

    $user = User::findOrFail($user_id);

    $user->password = Hash::make('123456');
    $user->update();

    return Redirect::back();

    }
     */
    /*
    public function promote_transfer(){
    $employeeid=$request->get('employee');
    $employee = Employee::findOrFail($employeeid);
    $promo=new Promotion;

    if(($request->get('operation'))=='promote')
    {

    $promo->employee()->associate($employee);
    $promo->salary=$request->get('salary');
    $promo->date=$request->get('pdate');
    $promo->department=$request->get('department');
    $promo->type='Promotion';
    $promo->reason=$request->get('reason');
    $promo->save();


    }
    if(($request->get('operation'))=='transfer')
    {

    $promo->employee()->associate($employee);
    $promo->salary=$request->get('salary');
    $promo->date=$request->get('tdate');
    $promo->stationto=$request->get('stationto');
    $promo->stationfrom=$request->get('stationfrom');
    $promo->reason=$request->get('reason');
    $promo->type='Transfer';
    $promo->save();



    }

    return Redirect::back();

    }*/


}
