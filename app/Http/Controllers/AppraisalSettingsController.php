<?php
namespace App\Http\Controllers;

use App\Models\Appraisalcategory;
use App\Models\Appraisalquestion;
use App\Models\Audit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AppraisalSettingsController extends Controller {

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $appraisals = Appraisalquestion::where('organization_id',Auth::user()->organization_id)->get();

        Audit::logaudit(now('Africa/Nairobi'),\auth()->user()->username,'Appraisal Settings', 'view');

        return View::make('appraisalsettings.index', compact('appraisals'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Appraisalcategory::all();
        return View::make('appraisalsettings.create',compact('categories'));
    }

    public function createcategory(Request $request)
    {
        $postallowance = $request->all();
        $data = array('name' => $postallowance['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('appraisalcategories')->insertGetId( $data );

        if($check > 0){

            Audit::logaudit('Appraisalcategories', 'create', 'created: '.$postallowance['name']);
            return $check;
        }else{
            return 1;
        }

    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Appraisalquestion::$rules,
            Appraisalquestion::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $appraisal = new Appraisalquestion;

        $appraisal->appraisalcategory_id = $request->input('category');

        $appraisal->question = $request->input('question');

        $appraisal->rate = $request->input('rate');

        $appraisal->organization_id = Auth::user()->organization_id;

        $appraisal->save();

        Audit::logaudit('Appraisal Question', 'create', 'created: '.$appraisal->question);


        return Redirect::route('AppraisalSettings.index')->withFlashMessage('Appraisal Settings successfully created!');
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $appraisal = Appraisalquestion::findOrFail($id);
        $categories = Appraisalcategory::all();
        return View::make('appraisalsettings.show', compact('categories'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $appraisal = Appraisalquestion::find($id);
        $categories = Appraisalcategory::all();
        return View::make('appraisalsettings.edit', compact('appraisal','categories'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $appraisal = Appraisalquestion::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Appraisalquestion::$rules,Appraisalquestion::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $appraisal->appraisalcategory_id = $request->input('category');

        $appraisal->question = $request->input('question');

        $appraisal->rate = $request->input('rate');

        $appraisal->update();

        Audit::logaudit('Appraisal Question', 'update', 'updated: '.$appraisal->question);


        return Redirect::route('AppraisalSettings.index')->withFlashMessage('Appraisal Settings successfully updated!');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $appraisal = Appraisalquestion::findOrFail($id);

        $app  = DB::table('Appraisals')->where('Appraisalquestion_id',$id)->count();
        if($app>0){
            return Redirect::route('AppraisalSettings.index')->withDeleteMessage('Cannot delete this appraisal question because its assigned to appraisal(s)!');
        }else{

            Appraisalquestion::destroy($id);

            Audit::logaudit('Appraisal Question', 'delete', 'deleted: '.$appraisal->question);

            return Redirect::route('AppraisalSettings.index')->withDeleteMessage('Appraisal Settings successfully deleted!');
        }
    }

}
