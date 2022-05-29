<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FingerPrintDevice;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class BiometricsController extends  BaseController
{
    public function index()
    {
        FingerPrintDevice::all();
        return View::make('');
    }

    public function employees()
    {
        $employees = Employee::select("id","first_name","last_name","personal_file_number")->get();

        return Response::json([
            "data" => $employees
        ]);
    }

    public function store()
    {
//        Log::info('FP Endpoint Hit', Input::all());
//        $prints = new FingerPrints;
//        $prints->fid = Input::get("fid");
//        $image = Input::file("print");
//        $contents = $image->openFile()->fread($image->getSize());
//        Log::info('FP Endpoint content', $contents);
//        $prints->fingerprint = Input::get("print");
//        $prints->employee_id = 1;
//        $prints->save();
//
//        DB::table('biometrics')->insert();
//
//        Return Response::json([
//            'status'=>'success'
//        ]);
    }

    public function getEmpId($id){
        $prints = Employee::where("id",$id)->get();
        return Response::json([
            'data' => $prints
        ]);
    }

    public function getPrintCount(){
        $count = DB::table('biometrics')->select('id')->count();
        return Response::json([
            'data' => $count
        ]);
    }

    public function getPresentdays($id, $period){

        $first_date = date('Y-m-d',strtotime('first_day_of'.$period));
        $last_date = date('Y-m-d',strtotime('last_day_of',$period));

        $begin = new DateTime($first_date);
        $end = new DateTime($last_date);

        $days_present = DB::table('attendances')->where('employee_id',$id)
            ->whereBetween('attendance_date',[$first_date,$last_date])
            ->sum('attendance_date');

        return Response::json([
            'data'=> $days_present
        ]);
    }


}
