<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Leaveapplication extends Model
{
    protected $table = 'x_leaveapplications';
    // Add your validation rules here
    public static $rules = [
        'applied_start_date' => 'required'
    ];

    public static $messages = array(
        'applied_start_date.required' => 'Please select start date!',
        'applied_end_date.required' => 'Please select end date!',
    );

    // Don't forget to fill this array
    protected $fillable = [];

    public function organization()
    {

        return $this->belongsTo(Organization::class);
    }


    public function employee()
    {

        return $this->belongsTo(Employee::class);
    }


    public function leavetype()
    {

        return $this->belongsTo(Leavetype::class);
    }


    public static function createLeaveApplication($data)
    {

        $organization = Organization::getUserOrganization();

        $employee = Employee::find(Arr::get($data, 'employee_id'));

        $leavetype = Leavetype::find(Arr::get($data, 'leavetype_id'));

        $application = new Leaveapplication;

        $application->applied_start_date = Arr::get($data, 'applied_start_date');
        $application->applied_end_date = Arr::get($data, 'applied_end_date');
        $application->status = 'applied';
        $application->application_date = date('Y-m-d');
        $application->employee()->associate($employee);
        $application->leavetype()->associate($leavetype);
        $application->organization()->associate($organization);
        $application->is_supervisor_approved = 0;
        if (Arr::get($data, 'weekends') == null) {
            $application->is_weekend = 0;
        } else {
            $application->is_weekend = 1;
        }
        if (Arr::get($data, 'holidays') == null) {
            $application->is_holiday = 0;
        } else {
            $application->is_holiday = 1;
        }

        $application->save();

        /*$supervisor = Supervisor::where('employee_id',$application->employee_id)->first();

        $employee = Employee::where('id',$supervisor->employee_id)->first();

		$name = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;


		Mail::send( 'emails.leavecreate', array('application'=>$application, 'name'=>$name), function( $message ) use ($employee)
		{

    		$message->to($employee->email_office )->subject( 'Leave Application' );
		});*/

    }


    public static function amendLeaveApplication($data, $id)
    {
        $leavetype = Leavetype::find(Arr::get($data, 'leavetype_id'));

        $application = Leaveapplication::find($id);

        $application->applied_start_date = Arr::get($data, 'applied_start_date');
        $application->applied_end_date = Arr::get($data, 'applied_end_date');
        $application->status = 'amended';
        $application->date_amended = date('Y-m-d');
        $application->leavetype()->associate($leavetype);
        $application->is_weekend = Arr::get($data, 'weekends');
        $application->is_holiday = Arr::get($data, 'holidays');
        $application->update();

    }


    public static function approveLeaveApplication($data, $id)
    {
        $application = Leaveapplication::find($id);

        $application->approved_start_date = Arr::get($data, 'approved_start_date');
        $application->approved_end_date = Arr::get($data, 'approved_end_date');
        $application->status = 'approved';
        $application->date_approved = date('Y-m-d');

        $application->update();


        $employeeid = DB::table('x_leaveapplications')->where('id', '=', $application->id)->pluck('employee_id')->first();
        $employee = Employee::findorfail($employeeid);

//        $name = $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name;


        /*Mail::send( 'emails.leaveapprove', array('application'=>$application, 'name'=>$name), function( $message ) use ($employee)
        {

            $message->to($employee->email_office )->subject( 'Leave Approval' );
        });*/

    }


    public static function cancelLeaveApplication($id)
    {


        $application = Leaveapplication::find($id);


        $application->status = 'cancelled';
        $application->date_cancelled = date('Y-m-d');

        $application->update();

    }


    public static function rejectLeaveApplication($id)
    {


        $application = Leaveapplication::find($id);


        $application->status = 'rejected';
        $application->date_rejected = date('Y-m-d');

        $application->update();

    }


    public static function getLeaveDays($start_date, $end_date)
    {

        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        //$start = strototime($start_date);
        //$end = strototime($end_date);

        //$diff =$end - $start;

        //$diff=date_diff($end, $start);


        $interval = $end->diff($start);

        $interval->format('%m');
        $days = $interval->days;

        return $days;

        //return strtotime($diff);


    }

    public static function getDays($start_date, $end_date, $weekends, $holidays)
    {

        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        $interval = $end->diff($start);

        $interval->format('%m');
        $days = $interval->days;

        if ($weekends == 1 && $holidays == 0) {
            $weekendcount = Leaveapplication::getHoliday($start_date, $end_date);

            return $days - $weekendcount;
        }
        if ($weekends == 0 && $holidays == 1) {
            $holidaycount = Leaveapplication::getWeekend($start_date, $end_date);

            return $days - $holidaycount;
        }
        if ($weekends == 1 && $holidays == 1) {
            return $days;
        }
        if ($weekends == 0 && $holidays == 0) {
            $weekendholidaycount = Leaveapplication::getHoliday($start_date, $end_date) + Leaveapplication::getWeekend($start_date, $end_date);

            return $days - $weekendholidaycount;
        }


    }


    public static function checkWeekend($date)
    {

        return (date('N', strtotime($date)) >= 6);


    }


    public static function checkHoliday($date)
    {


        $holiday = DB::table('holidays')->where('date', '=', $date)->count();

        if ($holiday >= 1) {

            return true;
        } else {

            return false;
        }


    }


    public static function getDaysTaken($employee, $leavetype)
    {


        $leavestaken = DB::table('x_leaveapplications')->where('employee_id', '=', $employee->id)->where('leavetype_id', '=', $leavetype->id)->where('status', '=', 'approved')->get();

        $daystaken = 0;
        foreach ($leavestaken as $leavetaken) {


            $taken = Leaveapplication::getLeaveDays($leavetaken->approved_start_date, $leavetaken->approved_end_date);

            $daystaken = $daystaken + $taken;


        }

        return $daystaken;

    }


    public static function getBalanceDays($employee, $leavetype)
    {

        $currentyear = date('Y');

        $joined_year = date('Y', strtotime($employee->date_joined));

        if ($currentyear == $joined_year) {
            $years = 1;
        } else {

            $years = $currentyear - $joined_year;

        }


        $entitled = ($years * $leavetype->days);

        $daystaken = Leaveapplication::getDaysTaken($employee, $leavetype);

        $balance = $entitled - $daystaken;

        return $balance;

    }


    public static function getRedeemLeaveDays($employee, $leavetype)
    {

        $payrate = $employee->basic_pay / 30;

        $balancedays = Leaveapplication::getBalanceDays($employee, $leavetype);

        $amount = $balancedays * $payrate;

        return $amount;
    }

    public static function checkBalance($id, $lid, $d)
    {

        $total = 0;
        $balance = 0;

        $currentyear = date('Y');

        $employee = DB::table('employee')
            ->where('id', $id)
            ->first();

        $joined_year = date('Y', strtotime($employee->date_joined));

        if ($currentyear == $joined_year) {
            $years = 1;
        } else {

            $years = $currentyear - $joined_year;

        }


        //$entitled = ($years * $leavetype->days);


        $leaveapplications = DB::table('leaveapplications')
            ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
            ->where('employee_id', $id)
            ->where('leavetype_id', $lid)
            ->where('date_approved', '<>', '')
            ->get();
        foreach ($leaveapplications as $leaveapplication) {
            $total += Leaveapplication::getLeaveDays($leaveapplication->applied_start_date, $leaveapplication->applied_end_date);

        }
        $balance = 0;
        if ($lid == 1) {
            $leavedays = DB::table('leavetypes')
                ->where('id', 1)
                ->first();
            $balance = ($years * $leavedays->days) - $total - $d;
        } else {
            $leavedays = DB::table('leavetypes')
                ->where('id', $lid)
                ->first();
            $balance = $leavedays->days - $d;
        }


        return $balance;
    }


    public static function RedeemLeaveDays($employee, $leavetype)
    {

        $payrate = $employee->basic_pay / 30;

        $balancedays = Leaveapplication::getBalanceDays($employee, $leavetype);

        $amount = $balancedays * $payrate;

        Earnings::insert($employee->id, 'Leave earning', 'redeemed leave days', $amount);
    }

    public static function getWeekend($startdate, $end_date)
    {


        $count = 0;
        $start = new DateTime($startdate);
        $end = new DateTime($end_date);


        $interval = $end->diff($start);

        $interval->format('%m');
        $days = $interval->days;

        $chkdate = $end_date;

        do {

            $weekend = Leaveapplication::checkWeekend($chkdate);

            if ($weekend == true) {

                $count = $count + 1;
                $add_days = 1;
                $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
                $days = $days - 1;
            } else {

                $days = $days - 1;
                $add_days = 1;
                $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
            }


        } while ($days > 0);

        return $count;

        //print_r($count);

    }

    public static function getHoliday($startdate, $end_date)
    {


        $count = 0;
        $start = new DateTime($startdate);
        $end = new DateTime($end_date);


        $interval = $end->diff($start);

        $interval->format('%m');
        $days = $interval->days;

        $chkdate = $end_date;

        do {

            $hol = Leaveapplication::checkHoliday($chkdate);

            if ($hol == true) {

                $count = $count + 1;
                $add_days = 1;
                $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
                $days = $days - 1;
            } else {

                $days = $days - 1;
                $add_days = 1;
                $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
            }


        } while ($days > 0);

        return $count;

        //print_r($count);

    }


    public static function getEndDate($startdate, $days, $weekends, $holidays)
    {

        $sdate = $startdate;
        $chkdate = $sdate;
        $i = $days;
        $edate = $sdate;

        if ($holidays == 1 && $weekends == 0) {
            do {
                $hol = Leaveapplication::checkWeekend($chkdate);
                if ($hol == false) {
                    $edate = $chkdate;
                    $add_days = 1;
                    $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
                    $i = $i - 1;
                } else if ($hol == true) {
                    $add_days = 1;
                    $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
                }
            } while ($i > 0);
        }
        if ($weekends == 1 && $holidays == 0) {
            do {
                $wk = Leaveapplication::checkHoliday($chkdate);
                if ($wk == false) {
                    $edate = $chkdate;
                    $add_days = 1;
                    $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
                    $i = $i - 1;
                } else if ($wk == true) {
                    $add_days = 1;
                    $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
                }
            } while ($i > 0);
        }
        if ($weekends == 1 && $holidays == 1) {
            #$edate = Leaveapplication::getLeaveDays($leaveapplication->approved_end_date,$leaveapplication->approved_start_date)+1;
        }
        if ($weekends == 0 && $holidays == 0) {

            do {
                $wk = Leaveapplication::checkWeekend($chkdate);
                $hol = Leaveapplication::checkHoliday($chkdate);
                if ($wk == false && $hol == false) {
                    $edate = $chkdate;
                    $add_days = 1;
                    $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
                    $i = $i - 1;
                } else if ($hol == true || $wk == true) {
                    $add_days = 1;
                    $chkdate = date('Y-m-d', strtotime($chkdate . ' +' . $add_days . ' days'));
                }
            } while ($i > 0);
        }
        return $edate;

    }

}
