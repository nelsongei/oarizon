<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Department;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\JobTitle;
use App\Models\Organization;
use App\Models\Promotion;
use App\Models\Stations;
use Barryvdh\DomPDF\Facade as PDF;
//use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PromotionsController extends Controller
{

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $promotions = Promotion::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();

        Audit::logaudit(now('Africa/Nairobi'), Auth::user()->username, 'create', 'created: ');

        return View::make('promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $employees = Employee::all();
        $stations = Stations::all();
        $departments = Department::all();
        $jobtitles = JobTitle::whereNull('organization_id')
            ->orWhere('organization_id', Auth::user()->organization_id)->get();

        //$employees = Employee::where('organization_id',Auth::user()->organization_id)->get();
        return View::make('promotions.create', compact('employees', 'stations', 'jobtitles', 'departments'));
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $employeeid = request('employee');
//        dd($employeeid);
        $employee = Employee::findOrFail($employeeid);

        $validator = Validator::make($data = request()->all(), Promotion::$rules, Promotion::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        /**$promotion = new Promotion;
         *
         * $promotion->employee_id = Input::get('employee');
         *
         * $promotion->reason = Input::get('reason');
         *
         * $promotion->type = Input::get('type');
         *
         * $promotion->promotion_date = Input::get('date');
         *
         * $promotion->organization_id = Auth::user()->organization_id;
         *
         * $promotion->save();*/

        if ((request('operation')) == 'promote') {
            $promo = new Promotion;

            $promo->employee()->associate($employee);
            $promo->salary = request('salary');
            $promo->date = request('pdate');
            $promo->department = request('department');
            $promo->type = 'Promotion';
            $promo->position = 1;
            $promo->reason = request('reason');
            $promo->organization_id = Auth::user()->organization_id;

            $promo->save();
            Audit::logaudit(now('Africa/Nairobi'), Auth::user()->username, 'create', 'created: ');
            return Redirect::route('promotions.index')->withFlashMessage('Promotion successfully created!');


        }
        if ((request('operation')) == 'transfer') {
            $promo = new Promotion;

            $promo->employee()->associate($employee);
            $promo->salary = request('salary');
            $promo->date = request('tdate');
            $promo->stationto = request('stationto');
            $promo->stationfrom = request('stationfrom');
            $promo->reason = request('reason');
            $promo->organization_id = Auth::user()->organization_id;

            $promo->type = 'Transfer';
            $promo->save();
            Audit::logaudit(now('Africa/Nairobi'), Auth::user()->username, 'create', 'created: ');
            return Redirect::route('promotions.index')->withFlashMessage('Transfer successfully created!');


        }
        return Redirect::back();


        /** if(Input::get('type') == 'Promotion'){
         * return Redirect::route('promotions.index')->withFlashMessage('Promotion successfully created!');
         * }else if(Input::get('type') == 'Demotion'){
         * return Redirect::route('promotions.index')->withFlashMessage('Demotion successfully created!');
         * } */
    }

    /**
     * Display the specified branch.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $promotion = Promotion::findOrFail($id);

        $employees = Employee::where('organization_id', Auth::user()->organization_id)->get();

        return View::make('promotions.show', compact('promotion', 'employees'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $promotion = Promotion::find($id);

        $employees = Employee::where('organization_id', Auth::user()->organization_id)->get();

        return View::make('promotions.edit', compact('promotion', 'employees'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $promo = Promotion::findOrFail($id);
        $validator = Validator::make($data = request()->all(), Promotion::$rules, Promotion::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        if ((request('operation')) == 'promote') {


            //$promo->employee()->associate($employee);
            $promo->salary = request('salary');
            $promo->date = request('pdate');
            $promo->department = request('department');
            $promo->type = 'Promotion';
            $promo->reason = request('reason');
            $promo->organization_id = Auth::user()->organization_id;

            $promo->update();
            return Redirect::route('promotions.index')->withFlashMessage('Promotion successfully updated!');


        }
        if ((request('operation')) == 'transfer') {
            //$promo->employee()->associate($employee);
            $promo->salary = request('salary');
            $promo->date = request('tdate');
            $promo->stationto = request('stationto');
            $promo->stationfrom = request('stationfrom');
            $promo->reason = request('reason');
            $promo->organization_id = Auth::user()->organization_id;

            $promo->type = 'Transfer';
            $promo->update();
            return Redirect::route('promotions.index')->withFlashMessage('Transfer successfully updated!');
        }
        Audit::logaudit(now('Africa/Nairobi'), Auth::user()->username, 'create', 'created: ');
        return Redirect::back();


        /**$promotion->employee_id = Input::get('employee');
         *
         * $promotion->reason = Input::get('reason');
         *
         * $promotion->type = Input::get('type');
         *
         * $promotion->promotion_date = Input::get('date');
         *
         * $promotion->update();
         *
         * Audit::logaudit('Promotion', 'update', 'updated: '.$promotion->type);
         *
         * if(Input::get('type') == 'Promotion'){
         * return Redirect::to('promotions')->withFlashMessage('Promotion successfully updated!');
         * }else if(Input::get('type') == 'Demotion'){
         * return Redirect::to('promotions')->withFlashMessage('Demotion successfully updated!');
         * }*/
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param int $id
     * @return Response
     */
    public function promotionletter($id)
    {
        $promotion = Promotion::find($id);
        $type = $promotion->type;
        $employee = Employee::where('id', '=', $promotion->employee_id)->get();
        $department = Department::where('id', '=', $promotion->department)->get();
        $organization = Organization::find(1);

        //$promotions = Promotion::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();

        $pdf = PDF::loadView('pdf.promotionletter', compact('type', 'employee', 'organization', 'promotion'))->setPaper('a4')->setOrientation('potrait');

        return $pdf->stream('Promotion Letter pdf');
    }

    public function transferletter($id)
    {
        $promotion = Promotion::find($id);
        $type = $promotion->type;
        $employee = Employee::where('id', '=', $promotion->employee_id)->first();
        $stationto = Stations::where('id', '=', $promotion->stationto)->first();
        $stationfrom = Stations::where('id', '=', $promotion->stationfrom)->first();
        $organization = Organization::find(1);
        //$promotions = Promotion::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();

        $pdf = PDF::loadView('pdf.transferletter', compact('type', 'stationto', 'stationfrom', 'employee', 'organization', 'promotion'))
            ->setPaper('a4');

        return $pdf->download('Transfer Letter pdf');
    }


    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);

        Promotion::destroy($id);

        Audit::logaudit('promotion', 'delete', 'deleted: ' . $promotion->type);

        if ($promotion->type == 'Promote') {
            return Redirect::route('promotions.index')->withFlashMessage('Promotion successfully deleted!');
        } else if ($promotion->type == 'transfer') {
            return Redirect::route('promotions.index')->withFlashMessage('Transfer successfully deleted!');
        }

    }

}
