<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leaveapplication;
use App\Models\User;
use Illuminate\Http\Request;

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
        $male = Employee::where('gender', 'male')->count();
        $female = Employee::where('gender', 'female')->count();
        //Leave Chart
        $approved = Leaveapplication::where('status', 'approved')->count();
        $cancelled = Leaveapplication::where('status', 'cancelled')->count();
        $applied = Leaveapplication::where('status', 'applied')->count();
        //Leave History
        for ($i = 0; $i < 12; $i++) {
            $months[] = date("Y-M", strtotime(date('Y-m-01') . " -$i months"));
        }
        $month1 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[0])),date('Y-m-30 H:m:s',strtotime($months[0]))])->count();
        $month2 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[1])),date('Y-m-30 H:m:s',strtotime($months[1]))])->count();
        $month3 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[2])),date('Y-m-30 H:m:s',strtotime($months[2]))])->count();
        $month4 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[3])),date('Y-m-30 H:m:s',strtotime($months[3]))])->count();
        $month5 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[4])),date('Y-m-30 H:m:s',strtotime($months[4]))])->count();
        $month6 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[5])),date('Y-m-30 H:m:s',strtotime($months[5]))])->count();
        $month7 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[6])),date('Y-m-30 H:m:s',strtotime($months[6]))])->count();
        $month8 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[7])),date('Y-m-30 H:m:s',strtotime($months[7]))])->count();
        $month9 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[8])),date('Y-m-30 H:m:s',strtotime($months[8]))])->count();
        $month10 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[9])),date('Y-m-30 H:m:s',strtotime($months[9]))])->count();
        $month11 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[10])),date('Y-m-30 H:m:s',strtotime($months[10]))])->count();
        $month12 = Leaveapplication::whereBetween('created_at',[date('Y-m-01 H:m:s',strtotime($months[11])),date('Y-m-30 H:m:s',strtotime($months[11]))])->count();
        //Home Stats
        $employees = Employee::count();
        $leaves = Leaveapplication::count();
        $users = User::count();
        return view('home', compact('male', 'female', 'approved', 'applied', 'cancelled','month1','month2','month3','month4','month5'
        ,'month6','month7','month8','month9','month10','month11','month12','employees','users','leaves'));
    }
}
