<?php

namespace App\Http\Controllers;

use App\models\License;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\ArrayToXml\ArrayToXml;

class LicenseController extends Controller
{
    //
    public function store(Request $request)
    {
        $update = License::where('module_id', \request()->module_id)->where('organization_id', \request()->organization_id)->findOrFail(request()->module_id);
        $update->organization_id = \request()->organization_id;
        $update->module_id = \request()->module_id;
        $update->start_date = request()->start_date;
        $update->end_date = request()->end_date;
        if (License::where('module_id', \request()->module_id)->exists()) {
        } else {
            $store = new License();
            $store->organization_id = \request()->organization_id;
            $store->start_date = \request()->start_date;
            $store->end_date = \request()->end_date;
            $store->module_id = \request()->module_id;
            $store->status = true;
            $store->save();
            return $store;
        }
    }

    public function stkPush(Request $request)
    {
        $data = new \GuzzleHttp\Client();
        $post = $data->post('http://127.0.0.1/licensemanager/public/api/v1/stk/push', [
            'form_params' => [
                'phone' => $request->phone,
                'amount' => $request->amount
            ]
        ]);
        return $post;

    }

    public function updateDates($org, $module, $end)
    {
        $start = now('Africa/Nairobi')->toDateString();
        $date = Carbon::createFromDate(now('Africa/Nairobi'))->addDays($end);
        $data = License::where('organization_id', $org)->where('module_id', $module)->exists();
        if (!empty($data)) {
            DB::update('update licenses set start_date=?,end_date=? where organization_id=? AND module_id=?', [$start, $date, $org, $module]);
            return 'Data';
        } else {
            $license = new  License();
            $license->organization_id = $org;
            $license->module_id = $module;
            $license->start_date = $start;
            $license->status = true;
            $license->end_date = $date;
            $license->save();
            return $module + 1;
        }
    }
}
