<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {

            $this->layout = View::make($this->layout);
        }
    }

    public function setSuccessMessage($msg)
    {
        Session::flash('msg',$msg);
        Session::flash('type','success');
    }

    public function setErrorMessage($msg)
    {
        Session::flash('msg',$msg);
        Session::flash('type','danger');
    }

}
