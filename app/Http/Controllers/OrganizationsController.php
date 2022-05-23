<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organization;
//use App\Models\Smslog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class OrganizationsController extends Controller {

    /*
     * Display a listing of organizations
     *
     * @return Response
     */
    public function index()
    {
        $organization = DB::table('x_organizations')->where('id', '=', 1)->first();
        return View::make('organizations.index', compact('organization'));
    }

    /*
     * Show the form for creating a new organization
     *
     * @return Response
     */
    public function create()
    {
        return View::make('organizations.create');
    }

    /*
     * Store a newly created organization in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Organization::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $organization = new Organization;




        return Redirect::route('organizations.index');
    }

    /*
     * Display the specified organization.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);

        return View::make('organizations.show', compact('organization'));
    }

    /*
     * Show the form for editing the specified organization.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $organization = Organization::find($id);

        return View::make('organizations.edit', compact('organization'));
    }

    /*
     * Update the specified organization in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $organization = Organization::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Organization::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $organization->name = $request->get('name');
        $organization->phone = $request->get('phone');
        $organization->email = $request->get('email');
        $organization->address = $request->get('address');
        $organization->website = $request->get('website');
        $organization->update();

        return Redirect::route('organizations.index');
    }

    /*
     * Remove the specified organization from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Organization::destroy($id);

        return Redirect::route('organizations.index');
    }





    public function generate_license_key(Request $request){

        $license_code = $request->get('license_code');
        $org_name = $request->get('name');



        $organization = new Organization;


        $license_key = $organization->license_key_generator($license_code);


        return View::make('admin.license_view', compact('license_key','org_name','license_code'));


    }



    public function activate_license_form($id){

        $organization = Organization::findOrFail($id);


        return View::make('activate', compact('organization'));
    }

    public function activate_annual_license_form($id){

        $organization = Organization::findOrFail($id);


        return View::make('annual_activate', compact('organization'));
    }


    public function annual_subscription_license(Request $request){

        $organization = Organization::findOrFail($request->get('org_id'));

        $license_key = $request->get('license_key');

        $license_k = explode('-', $license_key);
        $valid = $organization->annual_key_validator($license_key, $organization->license_code, $organization->name);
        $annual_key_name=$organization->decode_annual_subkey($license_key, 5);
        $year = substr($annual_key_name, 0, 4);
        $month  = substr($annual_key_name,4 , 2);
        $day  = substr($annual_key_name, 6, 2);

        $date=date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));


        if($valid){

            $organization->license_key = $license_k[0];
            $organization->annual_support_key = $license_key;
            $organization->license_type = 'commercial';
            $organization->licensed = 100;
            $organization->licence_due_date=$date;
            $organization->update();

            return Redirect::to('/');

        } else {

            return View::make('annual_activate', compact('organization'))->withErrors('License renewal failed. Annual Support Key not valid');

        }


    }

    public function activate_license(Request $request){

        $organization = Organization::findOrFail($request->get('org_id'));

        $license_key = $request->get('license_key');


        $valid = $organization->license_key_validator($license_key, $organization->license_code, $organization->name);


        if($valid){

            $organization->license_key = $license_key;
            $organization->license_type = 'commercial';
            $organization->licensed = 1000;
            $organization->update();

            return Redirect::to('/');

        } else {

            return View::make('activate', compact('organization'))->withErrors('License activation failed. License Key not valid');

        }


    }


    public function sms_view(Request $request,$id){

        $smscount=Smslog::all();
        $allsms=count($smscount);
        $date = $request->get('month');
        $total = Smslog::whereMonth('date','=',$date)->sum('monthlySmsCount');
        $members=Smslog::whereMonth('date','=',$date)->distinct('user')->pluck('user');

        $organization = Organization::findOrFail($id);


        return View::make('system.sms', compact('organization','total','members','date','allsms'));
    }




    public function logo(Request $request,$id){

        if($request->hasFile('photo')){

            $destination = public_path().'/uploads/logo/';

            $filename = str_random(12);

            $ext = $request->file('photo')->getClientOriginalExtension();
            $photo = $filename.'.'.$ext;


            $request->file('photo')->move($destination, $photo);


            $organization = Organization::findOrFail($id);

            $organization->logo = $photo;
            $organization->update();
        }
        return Redirect::action('OrganizationsController@index');

    }



    public function language($lang){
        Session::put('lang', $lang);

        return Redirect::back();
    }



}
