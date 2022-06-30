<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RegistrationController extends Controller
{
    //
    public function index()
    {
        //Get Modules
        $endpoint = 'http://127.0.0.1/licensemanager/public/api/module/license';
        $data = new \GuzzleHttp\Client(['base_uri' => $endpoint]);
        $response = $data->request('GET', $endpoint);
        $modules = json_decode($response->getBody(), true);
        return view('register.index', compact('modules'));
    }

    public function store(Request $request)
    {
        $data = Http::post('http://127.0.0.1/licensemanager/public/api/v1/create/organization', [
            'fname' => $request->firstname,
            'surname' => $request->surname,
            'lname' => null,
            'cname' => $request->company_name,
            'mobno' => $request->email,
            'email' => $request->phone,
            'password' => $request->password,
            'website' => $request->website,
            'address' => $request->address,
            'module' => $request->module_id,
            'pin' => null,
            'paid_via' => $request->paid_via,
            'trxn_id' => $request->trxn_id,
        ]);
        if ($data) {
            $organization = new Organization();
            $organization->name = $request->company_name;
            $organization->email = $request->email;
            $organization->website = $request->website;
            $organization->address = $request->address;
            $organization->installation_date = date('Y-m-d');
            $organization->phone = $request->phone;
            $organization->licensed = 10;
            $organization->save();
            $orgId = $organization->id;
            $user = new User();
            $user->username = $request->firstname;
            $user->name = $request->firstname . ' ' . $request->surname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 'admin';
            $user->organization_id = $orgId;
            $user->save();
            //Role Assign
            $this->roleAssign($user, $orgId);
            $this->department($orgId);
            $this->education($orgId);
            $this->type($orgId);
            $this->banks($orgId);
            $this->deduction($orgId);
            $this->nhifNssf($orgId);
        }
        return $data;
    }

    public function roleAssign($user, $orgId)
    {
        $role = Role::first();
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        Currency::create([
            'name' => 'Kenyan Shilling',
            'shortname' => 'KES',
            'organization_id' => $orgId,
        ]);
        DB::table('x_job_group')->insert(array(
            array('job_group_name' => 'Junior Staff', 'organization_id' => $orgId),
            array('job_group_name' => 'Management', 'organization_id' => $orgId),
            array('job_group_name' => 'Marketing', 'organization_id' => $orgId),
        ));
    }

    public function department($orgId)
    {
        DB::table('x_departments')->insert(array(
            array('name' => 'Information Technology', 'organization_id' => $orgId, 'codes' => '001'),
            array('name' => 'Management', 'organization_id' => $orgId, 'codes' => '002'),
            array('name' => 'Marketing', 'organization_id' => $orgId, 'codes' => '003'),
            array('name' => 'Finance', 'organization_id' => $orgId, 'codes' => '004'),
            array('name' => 'Human Resource', 'organization_id' => $orgId, 'codes' => '005'),
        ));
    }

    public function education($orgId)
    {
        DB::table('education')->insert(array(
            array('education_name' => 'Primary School', 'organization_id' => $orgId),
            array('education_name' => 'Secondary School', 'organization_id' => $orgId),
            array('education_name' => 'College - Certificate', 'organization_id' => $orgId),
            array('education_name' => 'College - Diploma', 'organization_id' => $orgId),
            array('education_name' => 'Degree', 'organization_id' => $orgId),
            array('education_name' => 'Masters Degree', 'organization_id' => $orgId),
            array('education_name' => 'PHD', 'organization_id' => $orgId),
            array('education_name' => 'None', 'organization_id' => $orgId),
        ));
    }
    public function type($orgId)
    {
        DB::table('x_employee_type')->insert(array(
            array('employee_type_name' => 'Full Time','organization_id' => $orgId),
            array('employee_type_name' => 'Contract','organization_id' => $orgId),
            array('employee_type_name' => 'Internship','organization_id' => $orgId),
        ));
    }
    public function banks($orgId)
    {
        DB::table('banks')->insert(array(
            array('bank_name' => 'Equity Bank','organization_id' => $orgId),
            array('bank_name' => 'Krep Bank','organization_id' => $orgId),
            array('bank_name' => 'CO-Operative Bank','organization_id' => $orgId),
            array('bank_name' => 'Family Bank','organization_id' => $orgId),
            array('bank_name' => 'Barclays Bank','organization_id' => $orgId),
            array('bank_name' => 'Kenya Commercial Bank','organization_id' => $orgId),
            array('bank_name' => 'Chase Bank','organization_id' => $orgId),
            array('bank_name' => 'Bank of Africa','organization_id' => $orgId),
            array('bank_name' => 'COnsolidated Bank','organization_id' => $orgId),
            array('bank_name' => 'CFC Stanbic Holdings Bank','organization_id' => $orgId),
            array('bank_name' => 'Diamond Trust Bank','organization_id' => $orgId),
        ));
    }
    public function deduction($orgId)
    {
        DB::table('x_deductions')->insert(array(
            array('deduction_name' => 'Salary Advance','organization_id' => $orgId),
            array('deduction_name' => 'Loans','organization_id' => $orgId),
            array('deduction_name' => 'Savings','organization_id' => $orgId),
            array('deduction_name' => 'Breakages and spoilages','organization_id' => $orgId),
        ));
    }
    public function nhifNssf($orgId)
    {
        DB::table('x_social_security')->insert(array(
            array('tier' => 'Tier I','income_from' => '0.00', 'income_to' => '0.00', 'ss_amount_employee' => '0.00', 'ss_amount_employer' => '0.00', 'organization_id' => $orgId),
            array('tier' => 'Tier I','income_from' => '1.00', 'income_to' => '99000000.00', 'ss_amount_employee' => '200.00', 'ss_amount_employer' => '200.00', 'organization_id' => $orgId),
        ));
        DB::table('x_hospital_insurance')->insert(array(
            array('income_from' => '0.00', 'income_to' => '0.00', 'hi_amount' => '0.00', 'organization_id' => $orgId),
            array('income_from' => '1.00', 'income_to' => '5999.00', 'hi_amount' => '150.00', 'organization_id' => $orgId),
            array('income_from' => '6000.00', 'income_to' => '7999.00', 'hi_amount' => '300.00', 'organization_id' => $orgId),
            array('income_from' => '8000.00', 'income_to' => '11999.00', 'hi_amount' => '400.00', 'organization_id' => $orgId),
            array('income_from' => '12000.00', 'income_to' => '14999.00', 'hi_amount' => '500.00', 'organization_id' => $orgId),
            array('income_from' => '15000.00', 'income_to' => '19999.00', 'hi_amount' => '600.00', 'organization_id' => $orgId),
            array('income_from' => '20000.00', 'income_to' => '24999.00', 'hi_amount' => '750.00', 'organization_id' => $orgId),
            array('income_from' => '25000.00', 'income_to' => '29999.00', 'hi_amount' => '850.00', 'organization_id' => $orgId),
            array('income_from' => '30000.00', 'income_to' => '34999.00', 'hi_amount' => '900.00', 'organization_id' => $orgId),
            array('income_from' => '35000.00', 'income_to' => '39999.00', 'hi_amount' => '950.00', 'organization_id' => $orgId),
            array('income_from' => '40000.00', 'income_to' => '44999.00', 'hi_amount' => '1000.00', 'organization_id' => $orgId),
            array('income_from' => '45000.00', 'income_to' => '49999.00', 'hi_amount' => '1100.00', 'organization_id' => $orgId),
            array('income_from' => '50000.00', 'income_to' => '59999.00', 'hi_amount' => '1200.00', 'organization_id' => $orgId),
            array('income_from' => '60000.00', 'income_to' => '69999.00', 'hi_amount' => '1300.00', 'organization_id' => $orgId),
            array('income_from' => '70000.00', 'income_to' => '79999.00', 'hi_amount' => '1400.00', 'organization_id' => $orgId),
            array('income_from' => '80000.00', 'income_to' => '89999.00', 'hi_amount' => '1500.00', 'organization_id' => $orgId),
            array('income_from' => '90000.00', 'income_to' => '99999.00', 'hi_amount' => '1600.00', 'organization_id' => $orgId),
            array('income_from' => '100000.00', 'income_to' => '99000000.00', 'hi_amount' => '1700.00', 'organization_id' => $orgId),
        ));
    }
}
