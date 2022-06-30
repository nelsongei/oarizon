<?php

namespace App\Http\Controllers;

use App\Models\OvertimeSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OvertimeSettingsController extends Controller
{
    //
    public function index()
    {
        $settings = OvertimeSettings::query()->where('organization_id',Auth::user()->organization_id)->get();
        return  view('overtime_setting.index',compact('settings'));
    }
}
