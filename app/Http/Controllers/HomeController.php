<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leaveapplication;
use App\Models\Transact;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //gender Count Chart
        $male = Employee::where('organization_id',Auth::user()->organization_id)->where('gender', 'male')->count();
        $female = Employee::where('organization_id',Auth::user()->organization_id)->where('gender', 'female')->count();
        //Leave Chart
        $approved = Leaveapplication::where('organization_id',Auth::user()->organization_id)->where('status', 'approved')->count();
        $cancelled = Leaveapplication::where('organization_id',Auth::user()->organization_id)->where('status', 'cancelled')->count();
        $applied = Leaveapplication::where('organization_id',Auth::user()->organization_id)->where('status', 'applied')->count();
        //Leave History
        for ($i = 0; $i < 12; $i++) {
            $months[] = date("Y-M", strtotime(date('Y-m-01') . " -$i months"));
        }
        $month1 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[0])),date('Y-m-t 23:59:59',strtotime($months[0]))])->count();
        $month2 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[1])),date('Y-m-t 23:59:59',strtotime($months[1]))])->count();
        $month3 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[2])),date('Y-m-t 23:59:59',strtotime($months[2]))])->count();
        $month4 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[3])),date('Y-m-t 23:59:59',strtotime($months[3]))])->count();
        $month5 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[4])),date('Y-m-t 23:59:59',strtotime($months[4]))])->count();
        $month6 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[5])),date('Y-m-t 23:59:59',strtotime($months[5]))])->count();
        $month7 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[6])),date('Y-m-t 23:59:59',strtotime($months[6]))])->count();
        $month8 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[7])),date('Y-m-t 23:59:59',strtotime($months[7]))])->count();
        $month9 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[8])),date('Y-m-t 23:59:59',strtotime($months[8]))])->count();
        $month10 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[9])),date('Y-m-t 23:59:59',strtotime($months[9]))])->count();
        $month11 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[10])),date('Y-m-t 23:59:59',strtotime($months[10]))])->count();
        $month12 = Leaveapplication::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[11])),date('Y-m-t 23:59:59',strtotime($months[11]))])->count();
        //dd(date('Y-m-t H:m:s',strtotime($months[0])));
        $monthss1 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[0])),date('Y-m-t 23:59:59',strtotime($months[0]))])->count();
        $monthss2 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[1])),date('Y-m-t 23:59:59',strtotime($months[1]))])->count();
        $monthss3 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[2])),date('Y-m-t 23:59:59',strtotime($months[2]))])->count();
        $monthss4 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[3])),date('Y-m-t 23:59:59',strtotime($months[3]))])->count();
        $monthss5 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[4])),date('Y-m-t 23:59:59',strtotime($months[4]))])->count();
        $monthss6 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[5])),date('Y-m-t 23:59:59',strtotime($months[5]))])->count();
        $monthss7 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[6])),date('Y-m-t 23:59:59',strtotime($months[6]))])->count();
        $monthss8 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[7])),date('Y-m-t 23:59:59',strtotime($months[7]))])->count();
        $monthss9 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[8])),date('Y-m-t 23:59:59',strtotime($months[8]))])->count();
        $monthss10 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[9])),date('Y-m-t 23:59:59',strtotime($months[9]))])->count();
        $monthss11 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[10])),date('Y-m-t 23:59:59',strtotime($months[10]))])->count();
        $monthss12 = Transact::where('organization_id',Auth::user()->organization_id)->whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[11])),date('Y-m-t 23:59:59',strtotime($months[11]))])->count();
        //Home Stats
        $employees = Employee::where('organization_id',Auth::user()->organization_id)->count();
        $leaves = Leaveapplication::where('organization_id',Auth::user()->organization_id)->count();
        $users = User::where('organization_id',Auth::user()->organization_id)->count();
        $departments = Department::with('employees')->get();
        return view('home', compact('male', 'female','departments', 'approved', 'applied', 'cancelled','month1','month2','month3','month4','month5'
        ,'month6','month7','month8','month9','month10','month11','month12','employees','users','leaves','monthss1','monthss2','monthss3','monthss4','monthss5'
            ,'monthss6','monthss7','monthss8','monthss9','monthss10','monthss11','monthss12'));
    }
}
