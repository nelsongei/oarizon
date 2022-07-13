<?php
namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class DepartmentsController extends Controller {

    /*
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $departments = Department::where('organization_id',Auth::user()->organization_id)->get();

        $date = now();
        $user = Auth::user()->username;

        Audit::logaudit($date, $user, 'viewed departments');

        return View::make('departments.index', compact('departments'));
    }

    /*
     * Show the form for creating a new branch
     *
     * @return Response
     */
    public function create()
    {
        return View::make('departments.create');
    }

    /*
     * Store a newly created branch in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = request()->all(), Department::$rules,Department::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $department = new Department;

        $department->codes = request()->input('code');

        $department->name = request()->input('name');

        $department->organization_id = Auth::user()->organization_id;

        $department->save();

        Audit::logaudit(date('Y-m-d'),Auth::user()->username,'Department', 'created: '.$department->department_name);

        return Redirect::route('departments.index')->withFlashMessage('Department successfully updated!');
    }

    /*
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $department = Department::findOrFail($id);

        return View::make('departments.show', compact('department'));
    }

    /*
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $department = Department::find($id);

        return View::make('departments.edit', compact('department'));
    }

    /*
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $department = Department::findOrFail($id);
        $validator = Validator::make($data = request()->all(), Department::$rules,Department::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $department->codes = request()->input('code');

        $department->name = request()->input('name');
        $department->update();

        $date = now();
        $user = Auth::user()->username;

        Audit::logaudit(date('Y-m-d'),Auth::user()->username,'Department',  'updated: '.$department->department_name);

        return Redirect::route('departments.index')->withFlashMessage('Department successfully updated!');
    }

    /*
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $dept  = DB::table('x_employee')->where('department_id',$id)->count();
        if($dept>0){
            return Redirect::route('departments.index')->withDeleteMessage('Cannot delete this departments because its assigned to an employee(s)!');
        }else{
            Department::destroy($id);

            Audit::logaudit(date('Y-m-d'),'Department', 'delete', 'deleted: '.$department->department_name);
            return Redirect::route('departments.index')->withDeleteMessage('Deduction successfully deleted!');
        }

    }

}
