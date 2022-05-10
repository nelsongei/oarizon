<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Zizaco\Confide\Confide;

class Transact extends Model
{

    public $table = "x_transact";

    protected $fillable = [];

    public static function getUser($id)
    {
        $user = User::find($id);
        return $user->name;
    }

    public static function getTransact($month, $year)
    {
        $period = $month . '-' . $year;
        $statutories = DB::table('x_transact')
            ->join('x_employee', 'x_transact.employee_id', '=', 'x_employee.personal_file_number')
            ->where('x_employee.organization_id', Auth::user()->organization_id)
            ->where('financial_month_year', '=', str_replace(' ', '', $period))
            ->get();
        return $statutories;
    }

}
