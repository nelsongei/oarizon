<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function index()
    {
        //Get Modules
        $endpoint = 'http://127.0.0.1/licensemanager/public/api/module/license';
        $data = new \GuzzleHttp\Client(['base_uri' => $endpoint]);
        $response = $data->request('GET', $endpoint);
        $modules = json_decode($response->getBody(), true);
        return view('register.index',compact('modules'));
    }
}
