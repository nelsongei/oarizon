<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Organization;


class MpesaController extends Controller
{
    //
    public function index()
    {
        //Get Modules
        $endpoint = 'http://127.0.0.1/licensemanager/public/api/module/license';
        $data = new \GuzzleHttp\Client(['base_uri' => $endpoint]);
        $response = $data->request('GET', $endpoint);
        $modules = json_decode($response->getBody(), true);
        //Transactions
        $id = Organization::pluck('id')->first();
        $uri = "http://127.0.0.1/licensemanager/public/api/v1/transactions/".$id;
        $resp = $data->request('GET',$uri);
        $transactions = json_decode($resp->getBody(),true);

        //Licenses
        $licences = License::orderBy('created_at')->get();
        return view('mpesa.index', compact('modules','transactions','licences'));
    }

    public function getLicenseData()
    {
        $endpoint = 'http://127.0.0.1/licensemanager/public/api/module/license';
        $data = new \GuzzleHttp\Client(['base_uri' => $endpoint]);
        $response = $data->request('GET', $endpoint);
        $modules = json_decode($response->getBody(), true);
        return $modules;

    }

    public function getModuleData($id)
    {
        $endpoint = 'http://127.0.0.1/licensemanager/public/api/module/license/' . $id;
        $data = new \GuzzleHttp\Client(['base_uri' => $endpoint]);
        $response = $data->request('GET', $endpoint);
        $modules = json_decode($response->getBody(), true);
        return $modules;

    }

    public function transaction($id)
    {
        $uri = "http://127.0.0.1/licensemanager/public/api/v1/transactions/".$id;
        $data = new \GuzzleHttp\Client(['base_uri'=>$uri]);
        $response = $data->request('GET',$uri);
        $transactions = json_decode($response->getBody(),true);
        return $transactions;
    }
    public function view($id,$transaction)
    {
        $endPoint = "http://127.0.0.1/licensemanager/public/api/v1/transactions/".$id."/".$transaction;
        $data  = new \GuzzleHttp\Client(['base_uri'=>$endPoint]);
        $response = $data->request('GET',$endPoint);
        $transaction = json_decode($response->getBody(),true);
        return view('mpesa.view',compact('transaction'));
    }
}
