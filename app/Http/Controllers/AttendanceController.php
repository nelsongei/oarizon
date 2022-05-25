<?php

namespace App\Http\Controllers;

use App\Http\traits\MonthlyWorkedHours;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\FingerPrints;
use App\Models\Holiday;
use App\Models\OfficeShift;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\DataTables;


class AttendanceController extends BaseController
{
    use MonthlyworkedHours;

    public $date_attendance = [];
    public $date_range = [];
    public $work_days = 0;


    public function index(Request $request)
    {
        $selected_date = Carbon::parse(request('filter_month_year'))->format('Y-m-d') ?? Carbon::now()->format('Y-m-d');
//        $selected_date = '2022-05-17';
        $day = strtolower(Carbon::parse(request('filter_month_year'))->format('l')) . '_in' ?? strtolower(Carbon::now()->format('l')) . '_in';
        if ($request->ajax()) {
            $employee = Employee::with(['office_shift', 'employee_attendance' => function ($query) use ($selected_date) {
                $query->where('attendace_date', $selected_date);
            },
                'office_shift',
                'organization',
                'leaves' => function ($query) use ($selected_date) {
                    $query->where('applied_start_date', '>=', $selected_date)
                        ->where('applied_end_date', '<=', $selected_date);
                }
            ])
                ->select('id', 'organization_id', 'first_name', 'last_name')
                ->where('date_joined', '<=', $selected_date);
            // ->where('id','=', Auth::user()->id)
            //->get();
            $holidays = Holiday::select('id', 'organization_id', 'date')
                ->where('date', '<=', $selected_date)
                ->where('date', '>=', $selected_date)
                //->where('is_published',1)
                ->first();
            //echo "<pre>"; print_r($employee); echo "</pre>"; die();
            return DataTables::of($employee)
                ->setRowId(function ($employee) {
                    return $employee->id;
                })
                ->addColumn('employee_name', function ($employee) {
                    return $employee->first_name.' '.$employee->last_name;
                })
                ->addColumn('attendance_date', function ($employee) use ($selected_date) {
                    //if there is no employee attendance
                    if ($employee->employee_attendance->isEmpty()) {
                        return Carbon::parse($selected_date)->format(Config::get('app.date_format'));
                    } else {
                        //if there are employee attendance,get the first record
                        $attendance_row = $employee->employee_attendance->first();

                        return $attendance_row->attendance_date;
                    }
                })
                ->addColumn('attendance_status', function ($employee) use ($holidays, $day) {
                    //if there are employee attendance,get the first record
                    if ($employee->employee_attendance->isEmpty()) {
                        if (is_null($employee->office_shift->$day ?? null) || ($employee->office_shift->$day == '')) {
                            return "Off Day";
                        }

                        if ($holidays) {
                            if ($employee->organization_id == $holidays->organization_id) {
                                return "Holiday";
                            }
                        }


                        if ($employee->employeeLeave->isEmpty()) {
                            return "Absent";
                        }

                        return "On Leave";

                    } else {
                        $attendance_row = $employee->employee_attendance->first();
                        return $attendance_row->attendance_status;
                    }
                })
                ->addColumn('clock_in', function ($employee) {
                    if ($employee->employee_attendance->isEmpty()) {
                        return '---';
                    } else {
                        $attendance_row = $employee->employee_attendance->first();

                        return $attendance_row->clock_in;
                    }
                })
                ->addColumn('clock_out', function ($employee) {
                    if ($employee->employee_attendance->isEmpty()) {
                        return '---';
                    } else {
                        $attendance_row = $employee->employee_attendance->last();

                        return $attendance_row->clock_out;
                    }
                })
                ->addColumn('time_late', function ($employee) {
                    if ($employee->employee_attendance->isEmpty()) {
                        return '---';
                    } else {
                        $attendance_row = $employee->employee_attendance->first();

                        return $attendance_row->time_late;
                    }
                })
                ->addColumn('early_leaving', function ($employee) {
                    if ($employee->employee_attendance->isEmpty()) {
                        return '---';
                    } else {
                        $attendance_row = $employee->employee_attendance->last();

                        return $attendance_row->early_leaving;
                    }
                })
                ->addColumn('overtime', function ($employee) {
                    if ($employee->employee_attendance->isEmpty()) {
                        return '---';
                    } else {

                        $total = 0;
                        foreach ($employee->employee_attendance as $attendance_row) {
                            sscanf($attendance_row->overtime, '%d:%d', $hour, $min);
                            $total += $hour * 60 + $min;
                        }
                        if ($h = floor($total / 60)) {
                            $total %= 60;
                        }

                        return sprintf('%02d:%02d', $h, $total);
                    }
                })
                ->addColumn('total_work', function ($employee) {
                    if ($employee->employee_attendance->isEmpty()) {
                        return '---';
                    } else {
                        $total = 0;
                        foreach ($employee->employee_attendance as $attendance_row) {
                            sscanf($attendance_row->total_work, '%d:%d', $hour, $min);
                            $total += $hour * 60 + $min;
                        }
                        if ($h = floor($total / 60)) {
                            $total %= 60;
                        }

                        return sprintf('%02d:%02d', $h, $total);
                    }
                })
                ->addColumn('total_rest', function ($employee) {
                    if ($employee->employee_attendance->isEmpty()) {
                        return '---';
                    } else {
                        $total = 0;
                        foreach ($employee->employee_attendance as $attendance_row) {
                            //formatting in hour:min and separating them
                            sscanf($attendance_row->total_rest, '%d:%d', $hour, $min);
                            //converting in minute
                            $total += $hour * 60 + $min;
                        }
                        // if minute is greater than hour then $h= hour
                        if ($h = floor($total / 60)) {
                            $total %= 60;
                        }

                        //returning back to hour:minute format
                        return sprintf('%02d:%02d', $h, $total);
                    }
                })
//                ->rawColumns(['action'])
                ->make(true);

        }
        // echo "<pre>"; print_r(json_decode($holidays)); echo "</pre>"; die();
        $employees = Employee::orderBy('id','asc')->get(['id','first_name','last_name']);
        $shifts = OfficeShift::orderBy('id')->get();
        return View::make('timesheet.attendance.attendances',compact('employees','shifts'));
    }

    public function collectBioAtt($id)
    {
        $emp_id = FingerPrints::where("fid", $id)->pluck('employee_id');
        $employee = Employee::with('office_shift')->findOrFail($emp_id);

        $current_day_in = strtolower(Carbon::now()->format('l')) . '_in';
        $current_day_out = strtolower(Carbon::now()->format('l')) . '_out';
        $shift_in = $employee->office_shift->$current_day_in;
        $shift_out = $employee->office_shift->$current_day_out;
        $shift_name = $employee->office_shift->shift_name;
        //echo "<pre>"; print_r($shift_in); die();
        return $this->employeeAttendance($emp_id, $shift_in, $shift_out);

    }

    public function employeeAttendance($id, $shift_in, $shift_out)
    {
        $data = [];

        //current day
        $current_day = Carbon::now()->format(Config::get('app.date_format'));

        //getting latest instance of employee_attendance
        $employee_last_attendance = Attendance::where('attendance_date', Carbon::now()->format('Y-m-d'))
                ->where('employee_id', $id)
                ->orderBy('id', 'desc')->first() ?? null;

        //shift in-shift out timing
        try {
            $shift_in = new DateTime($shift_in);
            $shift_out = new DateTime($shift_out);
            $current_time = new DateTime(Carbon::now());
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $data['employee_id'] = $id;
        $data['attendance_date'] = $current_day;

        //if employee attendance record was not found
        //Clock IN
        if (!$employee_last_attendance) {
            // echo "<pre>"; print_r($shift_in->diff($current_time)->format('%H:%I')); die();
            //if employee is late
            if ($current_time > $shift_in) {
                $timeDifference = $shift_in->diff($current_time)->format('%H:%I');
                $data['clock_in'] = $current_time->format('H:i');
                $data['time_late'] = $timeDifference;
            }//if employee is early or on time
            else {
                $data['clock_in'] = $shift_in->format('H:i');
            }
            $data['attendance_status'] = 'present';
            $data['clock_in_out'] = 1;
            //$data['clock_in_ip'] = $request->ip();

            //creating new attendance record
            Attendance::create($data);

            $this->setSuccessMessage('Clocked in Successfully');

            return Response::json([
                "status" => "Clocked IN successfully"
            ]);
        }

        //if there is a record of employee attendance
        //CLOCK OUT
        if ($employee_last_attendance) {
            //checking if employee is not both clocked in + out
            if ($employee_last_attendance->clock_in_out == 1) {
                //if employee is leaving early
                if ($current_time < $shift_out) {
                    $timeDifference = $shift_out->diff($current_time)->format('%H:%I');
                    $data['clock_out'] = $current_time->format('H:i');
                    $data['early_leaving'] = $timeDifference;
                }//if employee is doing overtime
                elseif ($current_time > $shift_out) {
                    $timeDifference = $shift_out->diff($current_time)->format('%H:%I');
                    $data['clock_out'] = $current_time->format('H:i');
                    $data['overtime'] = $timeDifference;
                } else {
                    $data['clock_out'] = $shift_out->format('H:i');
                }

                try {
                    //last clock in (needed for calculation of overtime)
                    $employee_last_clock_in = new DateTime($employee_last_attendance->clock_in);
                } catch (Exception $e) {
                    return $e;
                }

                //if employee clocked in after shift time is over
                if ($employee_last_attendance->clock_in > $shift_out) {
                    $data['overtime'] = $employee_last_clock_in->diff($current_time)->format('%H:%I');
                }

                // $data['clock_out_ip'] = $request->ip();

                //calculating total work
                $total_work = $employee_last_clock_in->diff($current_time)->format('%H:%I');
                $data['total_work'] = $total_work;
                $data['clock_in_out'] = 0;

                //updating record
                $attendance = Attendance::findOrFail($employee_last_attendance->id);
                $attendance->update($data);
                $this->setSuccessMessage('Clocked out Successfully');
                return Response::json([
                    'status' => 'Clocked Out successfully'
                ]);
            }
            //if employee is both clocked in + out
            if ($employee_last_attendance->clock_in_out == 0) {
                //new clock in on that day
                $data['clock_in'] = $current_time->format('H:i');
                // $data['clock_in_ip'] = $request->ip();
                $data['clock_in_out'] = 1;

                try {
                    //last check out (needed for calculation of rest time)
                    $employee_last_clock_out = new DateTime($employee_last_attendance->clock_out);
                } catch (Exception $e) {
                    return $e;
                }

                //calculating total rest (last clock out ~ current clock in)
                $data['total_rest'] = $employee_last_clock_out->diff($current_time)->format('%H:%I');

                Attendance::create($data);

                $this->setSuccessMessage('Clocked in successfully');

                return Response::json([
                    'status' => 'Clocked In successfully'
                ]);
            }
        }

        return Response::json([
            'status' => 'Success'
        ]);
    }

    public function updateAttendanceStore()
    {
        $data = $this->attendanceHandler(Input::all());
        Attendance::create($data);
        return Response::json(['success' => 'Data is Successfully Updated']);
    }

    public function attendanceHandler($request)
    {
        $employee_id = $request->employee_id;
        $attendance_date = $request->attendance_date;
        $clock_in = $request->clock_in;
        $clock_out = $request->clock_out;

        try {
            $clock_in = new DateTime($clock_in);
            $clock_out = new DateTime($clock_out);
        } catch (\Exception $e) {
            return $e;
        }

        $att_date_day = Carbon::parse($request->attendance_date)->format('l');

        $employee = Employee::with('office_shift')->findOrFail($employee_id);

        $current_day_in = strtolower($att_date_day) . '_in';
        $current_day_out = strtolower($att_date_day) . '_out';

        $shift_in = $employee->office_shift->$current_day_in;
        $shift_out = $employee->office_shift->$current_day_out;

        if ($shift_in == null) {
            $data['employee_id'] = $employee_id;
            $data['attendance_date'] = $attendance_date;
            $data['clock_in'] = $clock_in->format('H:i');
            $data['clock_out'] = $clock_out->format('H:i');
            $data['attendance_status'] = 'present';

            $total_work = $clock_in->diff($clock_out)->format('%H:%I');
            $data['total_work'] = $total_work;
            $data['early_leaving'] = '00:00';
            $data['time_late'] = '00:00';
            $data['overtime'] = '00:00';
            $data['clock_in_out'] = 0;

            return $data;
        }

        try {
            $shift_in = new DateTime($shift_in);
            $shift_out = new DateTime($shift_out);
        } catch (\Exception $e) {
            return $e;
        }

        $data['employee_id'] = $employee_id;
        $data['attendance_date'] = $attendance_date;

        //if employee is late
        if ($clock_in > $shift_in) {
            $timeDifference = $shift_in->diff($clock_in)->format('%H:%I');
            $data['clock_in'] = $clock_in->format('H:i');
            $data['time_late'] = $timeDifference;
        }//if employee is early or on time
        else {
            $data['clock_in'] = $shift_in->format('H:i');
            $data['time_late'] = '00:00';
        }
        if ($clock_out < $shift_out) {
            $timeDifference = $shift_out->diff($clock_out)->format('%H:%I');
            $data['clock_out'] = $clock_out->format('H:i');
            $data['early_leaving'] = $timeDifference;
        }//if employee is doing overtime
        elseif ($clock_out > $shift_out) {
            $timeDifference = $shift_out->diff($clock_out)->format('%H:%I');
            $data['clock_out'] = $clock_out->format('H:i');
            $data['overtime'] = $timeDifference;
            $data['early_leaving'] = '00:00';
        }//if clocked out in time
        else {
            $data['clock_out'] = $shift_out->format('H:i');
            $data['overtime'] = '00:00';
            $data['early_leaving'] = '00:00';
        }
        $data['attendance_status'] = 'present';

        $total_work = $clock_in->diff($clock_out)->format('%H:%I');
        $data['total_work'] = $total_work;
        $data['clock_in_out'] = 0;

        return $data;
    }

    public function monthlyTotalWorked($month_yr, $employeeId)
    {
        $year = date('Y', strtotime($month_yr));
        $month = date('m', strtotime($month_yr));

        $total = 0;

        $att = Employee::with(['employee_attendance' => function ($query) use ($year, $month) {
            $query->whereYear('attendance_date', $year)->whereMonth('attendance_date', $month);
        }])
            ->select('id', 'organization_id', 'first_name', 'last_name', 'office_shift_id')
            ->whereId($employeeId)
            ->get();

        foreach ($att[0]->employee_attendance as $key => $a) {
            sscanf($a->total_work, '%d:%d', $hour, $min);
            $total += $hour * 60 + $min;
        }

        if ($h = floor($total / 60)) {
            $total %= 60;
        }
        return sprintf('%02d:%02d', $h, $total);
    }

    public function dateWiseAttendance()
    {
        $logged_user = Auth::user();

        $organizations = Organization::all();

        $start_date = Carbon::parse(Input::get('filter_start_date'))->format('Y-m-d') ?? '';
        $end_date = Carbon::parse(Input::get('filter_end_date'))->format('Y-m-d') ?? "";

        if (Request::ajax()) {
            if (Input::get('employee_id')) {
                $emp = Employee::find(Input::get('employee_id'));
                $joining_date = Carbon::parse($emp->joining_date)->format('Y-m-d') ?? '';

                if (($joining_date >= $start_date) && ($joining_date <= $end_date)) {
                    $start_date = $joining_date;
                }

                $employee = Employee::with(['office_shift', 'employee_attendance' => function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('attendance_date', [$start_date, $end_date]);// start_date = joining_date
                },
                    'employeeLeave',
                    'organization',
                    'organization.holidays'
                ])
                    ->select('id', 'company_id', 'first_name', 'last_name', 'office_shift_id')
                    ->findOrFail(Input::get('employee_id'));


                $all_attendances_array = $employee->employeeAttendance->groupBy('attendance_date')->toArray();


                $leaves = $employee->employeeLeave;

                $shift = $employee->office_shift->toArray();

                $holidays = $employee->organization->holidays;


                $begin = new DateTime($start_date);
                $end = new DateTime($end_date);
                $end->modify('+1 day');

                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($begin, $interval, $end);

                $date_range = [];
                foreach ($period as $dt) {
                    $date_range[] = $dt->format(Config::get('app.date_format'));
                }
            } else {
                $date_range = [];
                $employee = null;
                $all_attendances_array = [];
                $leaves = [];
                $holidays = [];
                $shift = null;
            }

            return Datatables::of($date_range)
                ->setRowId(function ($row) use ($employee) {
                    return $employee->id;
                })
                ->addColumn('employee_name', function ($row) use ($employee) {
                    return $employee->full_name;
                })
                ->addColumn('organization', function ($row) use ($employee) {
                    return $employee->organization->name;
                })
                ->addColumn('attendance_date', function ($row) {
                    return Carbon::parse($row)->format(Config::get('app.date_format'));
                })
                ->addColumn('attendance_status', function ($row) use ($all_attendances_array, $leaves, $holidays, $shift) {
                    $day = strtolower(Carbon::parse($row)->format('l')) . '_in';

                    if (empty($shift[$day])) {
                        return "Off Day";
                    }

                    if (array_key_exists($row, $all_attendances_array)) {
                        return "Present";
                    } else {
                        foreach ($leaves as $leave) {
                            if ($leave->start_date <= $row && $leave->end_date >= $row) {
                                return "On Leave";
                            }
                        }
                        foreach ($holidays as $holiday) {
                            if ($holiday->start_date <= $row && $holiday->end_date >= $row) {
                                return "On Holiday";
                            }
                        }

                        return "Absent";
                    }
                })
                ->addColumn('clock_in', function ($row) use ($all_attendances_array) {
                    if (array_key_exists($row, $all_attendances_array)) {
                        $first = current($all_attendances_array[$row])['clock_in'];
                        return $first;
                    } else {
                        return '---';
                    }
                })
                ->addColumn('clock_out', function ($row) use ($all_attendances_array) {
                    if (array_key_exists($row, $all_attendances_array)) {
                        $last = end($all_attendances_array[$row])['clock_out'];
                        return $last;
                    } else {
                        return '----';
                    }
                })
                ->addColumn('time_late', function ($row) use ($all_attendances_array) {
                    if (array_key_exists($row, $all_attendances_array)) {
                        $first = current($all_attendances_array[$row])['time_late'];
                        return $first;
                    } else {
                        return '---';
                    }
                })
                ->addColumn('early_leaving', function ($row) use ($all_attendances_array) {
                    if (array_key_exists($row, $all_attendances_array)) {
                        $last = end($all_attendances_array[$row])['early_leaving'];
                        return $last;
                    } else {
                        return '---';
                    }
                })
                ->addColumn('overtime', function ($row) use ($all_attendances_array) {
                    if (array_key_exists($row, $all_attendances_array)) {
                        $total = 0;
                        foreach ($all_attendances_array[$row] as $all_attendance_item) {
                            sscanf($all_attendance_item['overtime'], '%d:%d', $hour, $min);
                            $total += $hour * 60 + $min;
                        }
                        if ($h = floor($total / 60)) {
                            $total %= 60;
                        }
                        return sprintf('%02d:%02d', $h, $total);
                    } else {
                        return '---';
                    }
                })
                ->addColumn('total_work', function ($row) use ($all_attendances_array) {
                    if (array_key_exists($row, $all_attendances_array)) {
                        $total = 0;
                        foreach ($all_attendances_array[$row] as $all_attendance_item) {
                            sscanf($all_attendance_item['total_work'], '%d:%d', $hour, $min);
                            $total += $hour * 60 + $min;
                        }
                        if ($h = floor($total / 60)) {
                            $total %= 60;
                        }
                        $sum_total = 0 + $total;

                        return sprintf('%02d:%02d', $h, $total);
                    } else {
                        return '---';
                    }
                })
                ->addColumn('total_rest', function ($row) use ($all_attendances_array) {
                    if (array_key_exists($row, $all_attendances_array)) {
                        $total = 0;
                        foreach ($all_attendances_array[$row] as $attendance_item) {
                            //formatting in hour:min and separating them
                            sscanf($attendance_item['total_rest'], '%d:%d', $hour, $min);
                            //convert to minutes
                            $total += $hour * 60 + $min;
                        }
                        //if minutes are greater than hours then $h = hour
                        if ($h = floor($total / 60)) {
                            //$total = minutes (after excluding hour)
                            $total %= 60;
                        }
                        //return backt to hour:min format
                        return sprintf('%02d:%02d', $h, $total);
                    } else {
                        return '---';
                    }
                })
                ->make(true);
        }

        return View::make('timesheet.attendance.dateWiseAttendance', compact('organizations'));
    }

    public function monthlyAttendance()
    {
        $logged_user = Auth::user();
        $organizations = Organization::all();
        $month_year = Input::get("filter_month_year");

        $first_date = date('Y-m-d', strtotime('first day of ' . $month_year));
        $last_date = date('Y-m-d', strtotime('last day of ' . $month_year));

        $begin = new DateTime($first_date);
        $end = new DateTime($last_date);

        $end->modify('+1 day');

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
            $this->date_range[] = $dt->format("d D");
            $this->date_attendance[] = $dt->format(Config::get("app.date_format"));
        }

        if (Request::ajax()) {
            if (!($logged_user->can('view-attendance'))) {
                $employee = Employee::with(['office_shift', 'employee_attendance' => function ($query) use ($first_date, $last_date) {
                    $query->whereBetween('attendance_date', [$first_date, $last_date]);
                },
                    'employeeLeave',
                    'organization',
                    'organization.holidays'
                ])
                    ->select('id', 'organization_id', 'first_name', 'last_name', 'office_shift_id')
                    ->whereId($logged_user->id);
                //->get();
            } else {
                if (!empty(Input::get('filter_company') && Input::get('filter_employee'))) {
                    $employee = Employee::with(['office_shift', 'employee_attendance' => function ($query) use ($first_date, $last_date) {
                        $query->whereBetween('attendance_date', [$first_date, $last_date]);
                    },
                        'employeeLeave',
                        'organization',
                        'organization.holidays'
                    ])
                        ->select('id', 'organization_id', 'first_name', 'last_name', 'office_shift_id')
                        ->whereId(Input::get('filter_employee'));
                    //->get();
                } elseif (!empty(Input::get('filter_company'))) {
                    $employee = Employee::with(['office_shift', 'employee_attendance' => function ($query) use ($first_date, $last_date) {
                        $query->whereBetween('attendance_date', [$first_date, $last_date]);
                    },
                        'employeeLeave',
                        'organization',
                        'organization.holidays'
                    ])
                        ->select('id', 'organization_id', 'first_name', 'last_name', 'office_shift_id')
                        ->where('organization_id', Input::get('filter_company'));
                    //->get();
                } else {
                    $employee = Employee::with(['office_shift', 'employee_attendance' => function ($query) use ($first_date, $last_date) {
                        $query->whereBetween('attendance_date', [$first_date, $last_date]);
                    },
                        'employeeLeave',
                        'organization',
                        'organization.holidays'
                    ])
                        ->select('id', 'organization_id', 'first_name', 'last_name', 'office_shift_id');
                    // ->get();
                }
            }

            return Datatables::of($employee)
                ->setRowId(function ($row) {
                    $this->work_days = 0;
                    return $row->id;
                })
                ->addColumn('employee_name', function ($row) {
                    $name = $row->full_name;
                    return $name;
                })
                ->addColumn('day1', function ($row) {
                    return $this->checkAttendanceStatus($row, 0);
                })
                ->addColumn('day2', function ($row) {
                    return $this->checkAttendanceStatus($row, 1);
                })
                ->addColumn('day3', function ($row) {
                    return $this->checkAttendanceStatus($row, 2);
                })
                ->addColumn('day4', function ($row) {
                    return $this->checkAttendanceStatus($row, 3);
                })
                ->addColumn('day5', function ($row) {
                    return $this->checkAttendanceStatus($row, 4);
                })
                ->addColumn('day6', function ($row) {
                    return $this->checkAttendanceStatus($row, 5);
                })
                ->addColumn('day7', function ($row) {
                    return $this->checkAttendanceStatus($row, 6);
                })
                ->addColumn('day8', function ($row) {
                    return $this->checkAttendanceStatus($row, 7);
                })
                ->addColumn('day9', function ($row) {
                    return $this->checkAttendanceStatus($row, 8);
                })
                ->addColumn('day10', function ($row) {
                    return $this->checkAttendanceStatus($row, 9);
                })
                ->addColumn('day11', function ($row) {
                    return $this->checkAttendanceStatus($row, 10);
                })
                ->addColumn('day12', function ($row) {
                    return $this->checkAttendanceStatus($row, 11);
                })
                ->addColumn('day13', function ($row) {
                    return $this->checkAttendanceStatus($row, 12);
                })
                ->addColumn('day14', function ($row) {
                    return $this->checkAttendanceStatus($row, 13);
                })
                ->addColumn('day15', function ($row) {
                    return $this->checkAttendanceStatus($row, 14);
                })
                ->addColumn('day16', function ($row) {
                    return $this->checkAttendanceStatus($row, 15);
                })
                ->addColumn('day17', function ($row) {
                    return $this->checkAttendanceStatus($row, 16);
                })
                ->addColumn('day18', function ($row) {
                    return $this->checkAttendanceStatus($row, 17);
                })
                ->addColumn('day19', function ($row) {
                    return $this->checkAttendanceStatus($row, 18);
                })
                ->addColumn('day20', function ($row) {
                    return $this->checkAttendanceStatus($row, 19);
                })
                ->addColumn('day21', function ($row) {
                    return $this->checkAttendanceStatus($row, 20);
                })
                ->addColumn('day22', function ($row) {
                    return $this->checkAttendanceStatus($row, 21);
                })
                ->addColumn('day23', function ($row) {
                    return $this->checkAttendanceStatus($row, 22);
                })
                ->addColumn('day24', function ($row) {
                    return $this->checkAttendanceStatus($row, 23);
                })
                ->addColumn('day25', function ($row) {
                    return $this->checkAttendanceStatus($row, 24);
                })
                ->addColumn('day26', function ($row) {
                    return $this->checkAttendanceStatus($row, 25);
                })
                ->addColumn('day27', function ($row) {
                    return $this->checkAttendanceStatus($row, 26);
                })
                ->addColumn('day28', function ($row) {
                    return $this->checkAttendanceStatus($row, 27);
                })
                ->addColumn('day29', function ($row) {
                    return $this->checkAttendanceStatus($row, 28);
                })
                ->addColumn('day30', function ($row) {
                    return $this->checkAttendanceStatus($row, 29);
                })
                ->addColumn('day31', function ($row) {
                    return $this->checkAttendanceStatus($row, 30);
                })
                ->addColumn('worked_days', function ($row) {
                    return $this->work_days;
                })
                ->addColumn('total_worked_hours', function ($row) {
                    return $this->totalWorkedHours($row);
                })
                ->set_row_data(['date_range' => $this->date_range])
                ->make(true);
        }

        return View::make('timesheet.attendance.monthly_attendance', compact('organizations'));
    }

    public function checkAttendanceStatus($emp, $index)
    {
        if (count($this->date_attendance) <= $index) {
            return '';
        } else {

//            $leave = $emp->employeeLeave->where('start_date','<=',$this->date_attendance[$index])
//                    ->where('end_date','>=', $this->date_attendance[$index]);
//

            $leave = DB::table('employee')
                ->where('employee.id', $emp->id)
                ->join('leaveapplications', 'employee.id', '=', 'leaveapplications.employee_id')
                ->where('start_date', '<=', $this->date_attendance[$index])
                ->where('end_date', '>=', $this->date_attendance[$index])
                ->get();

            $present = DB::table('employee')
                ->where('employee.id', $emp->id)
                ->join('attendances', 'employee.id', '=', 'attendances.employee_id')
                ->select(DB::raw('DISTINCT(attendance_date)'))
                ->where('attendance_date', $this->date_attendance[$index])
                ->get();


            //$present = $emp->employee_attendance->where('attendance_date',$this->date_attendance[$index]);

            $holiday = DB::table('employee')
                ->where('employee.id', $emp->id)
                ->leftjoin('organizations', 'employee.id', '=', 'employee.organization_id')
                ->join('holidays', 'organizations.id', '=', 'holidays.organization_id')
                ->where('holidays.start_date', '<=', $this->date_attendance[$index])
                ->where('holidays.end_date', '>=', $this->date_attendance[$index])
                ->get();

//            $holiday = $emp->organization->holidays->where('start_date','<=',$this->date_attendance[$index])
//                   ->where('end_date','>=',$this->date_attendance[$index]);
//

            $day = strtolower(Carbon::parse($this->date_attendance[$index])->format('l')) . '_in';

            if ($present != null) {
                $this->work_days++;
                return 'P';
            } elseif (!$emp->office_shift->$day) {
                return "O";
            } elseif ($leave != null) {
                return "L";
            } elseif ($holiday != null) {
                return 'H';
            } else {
                return 'A';
            }
        }
    }
}
