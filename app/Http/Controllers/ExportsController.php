<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Concerns\Exportable;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ExportsController extends Controller
{
    //
    use Exportable;
    public function p9Form()
    {
        return Excel::download(function ($excel){

        },'file.xls');
    }
}
