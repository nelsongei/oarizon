<?php namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Allowance;
use App\Models\Audit;
use App\Models\Currency;
use App\Models\Dailypay;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Earningsetting;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\Jobgroup;
use App\Models\Lockpayroll;
use App\Models\Nontaxable;
use App\Models\Organization;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Models\Relief;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Classes\PHPExcel;
use Maatwebsite\Excel\Facades\Excel;
use Zizaco\Entrust\Entrust;

class PayrollController extends Controller {

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {

        $accounts = Account::where('organization_id',Auth::user()->organization_id)->get();

        $department = Department::whereNull('organization_id')
        ->orWhere('organization_id',Auth::user()->organization_id)
        ->where('name','Management')->first();
        $jgroup = Jobgroup::where(function($query){
                  $query->whereNull('organization_id')
                        ->orWhere('organization_id',Auth::user()->organization_id);
                  })->where('job_group_name','Management')
                    ->first();
        if($jgroup != null){
          $type = Employee::where('organization_id',Auth::user()->organization_id)->where('job_group_id',$jgroup->id)->where('personal_file_number',Auth::user()->username)->count();
        }else{
          $type = Employee::where('organization_id',Auth::user()->organization_id)->/*where('job_group_id',$jgroup->id)->*/where('personal_file_number',Auth::user()->username)->count();
        }
        return View::make('payroll.index', compact('accounts','type'));
    }

    public function unlockindex()
    {

        $transacts = DB::table('x_transact')->where('organization_id',Auth::user()->organization_id)->orderBy('id','Desc')->get();
//        $transacts = DB::table('x_transact')->where('organization_id',Auth::user()->organization_id)->groupBy('financial_month_year','id','organization_id')->orderBy('id','Desc')->get();

        return View::make('payroll.unlockindex', compact('transacts'));
    }

    public function viewpayroll($id)
    {

        $transact = DB::table('transact')->find($id);

        return View::make('payroll.viewpayroll', compact('transact'));
    }

    public function unlockpayroll($id)
    {

        $transact = DB::table('transact')->find($id);

        if(Lockpayroll::where('period',$transact->financial_month_year)->count() > 0){
          return Redirect::to('unlockpayroll/index');
        }

        $users = User::where('user_type','admin')->where('id','!=',Auth::user()->id)->get();

        return View::make('payroll.unlockpayroll', compact('transact','users'));
    }

    public function dounlockpayroll()
    {

        if(Lockpayroll::where('period',Input::get('period'))->count() == 0){

        $unlock = new Lockpayroll;
        $unlock->user_id = Input::get('userid');
        $unlock->authorized_by = Auth::user()->id;
        $unlock->period = Input::get('period');
        $unlock->save();

        $user = User::find(Input::get('userid'));

        return Redirect::to('unlockpayroll/index')->with('notice','Payroll for period '.Input::get('period').' successfully unlocked to user '.$user->username);
      }else{
        return Redirect::to('unlockpayroll/index');
      }
    }

    public function createaccount()
  {
      $postaccount = Input::all();
      $data = array('name' => $postaccount['name'],
                    'code' => $postaccount['code'],
                    'category' => $postaccount['category'],
                    'active' => 1,
                    'organization_id' => Auth::user()->organization_id,
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'));
      $check = DB::table('accounts')->insertGetId( $data );

    if($check > 0){

      Audit::logaudit('Accounts', 'create', 'created: '.$postaccount['name']);
      return $check;
    }else{
      return 1;
    }

  }

    public function preview_payroll()
    {

        $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('employee.organization_id',Auth::user()->organization_id)
                  ->get();

        $earnings = Earningsetting::all();

        //print_r($accounts);

        Audit::logaudit('Payroll', 'preview', 'previewed payroll');


        return View::make('payroll.preview', compact('employees','earnings'));
    }

    public function valid()
    {
        $period = Input::get('period');

        //print_r($accounts);

        return View::make('payroll.valid', compact('period'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return Response
     */
    public function create()
    {

      $unlock = Lockpayroll::where('user_id',Auth::user()->id)->where('period',Input::get('period'))->count();

      if(!Entrust::can('reprocess_payroll') && $unlock == 0){

      $check = DB::table('transact')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->count();

      if($check > 0){
       return Redirect::back()->with('notice','Payroll for this month is already processed! Please contact the admin if you wish to re-process it...');
      }
      }

      $period = Input::get('period');

      $start  = date('Y-m-01', strtotime("01-".$period));
      $end    = date('Y-m-t', strtotime("01-".$period));

       $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->whereDate('date_joined','<=', $end)
                  ->get();

      $department = Department::where('department_name','Management')

                  ->where(function($query){
                         $query->whereNull('organization_id')
                               ->orWhere('organization_id',Auth::user()->organization_id);
                 })->first();


      $jgroup = Jobgroup::where('job_group_name','Management')
                  ->where(function($query){
                         $query->whereNull('organization_id')
                               ->orWhere('organization_id',Auth::user()->organization_id);
                 })->first();

       if(Input::get('type') == 'management'){

         $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->where('job_group_id',$jgroup->id)
                  ->whereDate('date_joined','<=', $end)
                  ->get();
       }else{
          $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->where('job_group_id','!=',$jgroup->id)
                  ->whereDate('date_joined','<=', $end)
                  ->get();
       }


        $type = Input::get('type');
        $account = Input::get('account');
        $earnings = Earningsetting::where('organization_id',Auth::user()->organization_id)->orWhereNull('organization_id')->get();
        //$pays = Dailypay::where('organization_id',Auth::user()->organization_id)->get();
        $overtimes = Overtime::all();
        $allowances = Allowance::where('organization_id',Auth::user()->organization_id)
        ->orWhereNull('organization_id')->get();
        $nontaxables = Nontaxable::where('organization_id',Auth::user()->organization_id)
        ->orWhereNull('organization_id')->get();
        $reliefs = Relief::where('organization_id',Auth::user()->organization_id)
        ->orWhereNull('organization_id')->get();
        $deductions = Deduction::where('organization_id',Auth::user()->organization_id)
        ->orWhereNull('organization_id')->get();
        //print_r($accounts);

        Audit::logaudit('Payroll', 'preview', 'previewed payroll');

        return View::make('payroll.preview', compact('employees','period','account','nontaxables','earnings','overtimes','allowances','reliefs','deductions','type'));
    }

    public function del_exist()
    {
    $postedit = Input::all();
    $part1    = $postedit['period1'];
    $part2    = $postedit['period2'];
    $part3    = $postedit['period3'];
    $type     = $postedit['type'];

    $period   = $part1.$part2.$part3;

    DB::table('employee_allowances')
              ->join('transact_allowances','employee_allowances.id','=','transact_allowances.employee_allowance_id')
              ->where('transact_allowances.organization_id',Auth::user()->organization_id)
              ->where('process_type',$type)
              ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
              ->increment('instalments');

    DB::table('employeenontaxables')
              ->join('transact_nontaxables','employeenontaxables.id','=','transact_nontaxables.employee_nontaxable_id')
              ->where('financial_month_year', '=', $period)
              ->where('transact_nontaxables.organization_id',Auth::user()->organization_id)
              ->where('process_type',$type)
              ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
              ->increment('instalments');

     DB::table('employee_deductions')
              ->join('transact_deductions','employee_deductions.id','=','transact_deductions.employee_deduction_id')
              ->where('financial_month_year', '=', $period)
              ->where('transact_deductions.organization_id',Auth::user()->organization_id)
              ->where('process_type',$type)
              ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
              ->increment('instalments');

    DB::table('earnings')
              ->join('transact_earnings','earnings.id','=','transact_earnings.earning_id')
              ->where('financial_month_year', '=', $period)
              ->where('transact_earnings.organization_id',Auth::user()->organization_id)
              ->where('process_type',$type)
              ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
              ->increment('instalments');

    DB::table('overtimes')
              ->join('transact_overtimes','overtimes.id','=','transact_overtimes.overtime_id')
              ->where('financial_month_year', '=', $period)
              ->where('transact_overtimes.organization_id',Auth::user()->organization_id)
              ->where('process_type',$type)
              ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
              ->increment('instalments');

        //DB::table('dailypays')->where('period',$period)->where('status',1)->update(array("status"=>0));




    $data     = DB::table('transact')->where('process_type',$type)->where('organization_id',Auth::user()->organization_id)->where('financial_month_year',$period)->delete();
    $data2    = DB::table('transact_allowances')->where('process_type',$type)->where('organization_id',Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
    $data3    = DB::table('transact_deductions')->where('process_type',$type)->where('organization_id',Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
    $data4    = DB::table('transact_earnings')->where('process_type',$type)->where('organization_id',Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
    $data5    = DB::table('transact_overtimes')->where('process_type',$type)->where('organization_id',Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
    $data6    = DB::table('transact_reliefs')->where('process_type',$type)->where('organization_id',Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
    $data7    = DB::table('transact_nontaxables')->where('process_type',$type)->where('organization_id',Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
    $data8    = DB::table('transact_pensions')->where('organization_id',Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();

    if($data > 0){
      return 0;
    }else{
      return 1;
    }


    exit();
    }


    public function disp(){
      $display = "";
      $postedit = Input::all();
      parse_str(Input::get('formdata'), $postedit);
      $gross = str_replace( ',', '', $postedit['gross']);

        $paye = number_format(Payroll::payecalc($gross),2);
        $nssf = number_format(Payroll::nssfcalc($gross),2);
        $nhif = number_format(Payroll::nhifcalc($gross),2);
        $net  = Payroll::asMoney(Payroll::netcalc($gross));

         return json_encode(["paye"=>$paye,"nssf"=>$nssf,"nhif"=>$nhif,"net"=>$net,"gross"=>number_format($gross, 2)]);
        //echo json_encode(array("paye"=>$paye,"nssf"=>$nssf,"nhif"=>$nhif));
        //$net = number_format(Payroll::netcalc($employee->id,$fperiod),2);
       /*

        $display .="
          <input class='form-control' placeholder='' type='text' name='gross' id='gross' value='$gross'>
          <input readonly class='form-control' placeholder='' type='text' name='paye' id='paye' value='$paye'>
          <input readonly class='form-control' placeholder='' type='text' name='nssf' id='nssf' value='$nssf'>
          <input readonly class='form-control' placeholder='' type='text' name='nssf' id='nhif' value='$nhif'>
          <input readonly class='form-control' placeholder='' type='text' name='net' id='net' value='0'>

        ";

        return $display;
        exit();*/
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();
        //return View::make('payroll.payroll_calculator', compact('gross','paye','nssf','nhif','currency'));


        echo json_encode(array("paye"=>$paye,"nssf"=>$nssf,"nhif"=>$nhif));
        //return $display;
        exit();

    }


  public static function grosscalc($net){

        $total = 0;
        $gross = $net;
        $y =0 ;
        $x =0 ;

        for($i=$net;$i>0;$i--){

        $total = $net-Payroll::payencalc($net)-Payroll::nssfncalc($net)-Payroll::nhifncalc($net);

        $gross=($gross-$total)+$net;
        $net=$total;
        $y=$x;
        $x=($gross-$net)/2;
        $i=$x-$y;
        }

    return round($gross,2);

    }


    public function previewprint($period){

        $data = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->get();
        $period = $period;
        $account = Input::get('account');
        $earnings = Earningsetting::all();
        $overtimes = Overtime::all();
        $allowances = Allowance::all();
        $reliefs = Relief::all();
        $deductions = Deduction::all();

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();

        $organization = Organization::find(Auth::user()->organization_id);

        $part = explode("-", $period);

              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }

              $month = $m."_".$part[1];


  Excel::create('Payroll_Preview_'.$month, function($excel) use($data,$month,$period,$earnings,$overtimes,$allowances,$reliefs,$deductions) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel();
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0);


    $excel->sheet('Payroll_Preview_'.$month, function($sheet) use($data,$month,$period,$earnings,$overtimes,$allowances,$reliefs,$deductions){
              $earnname = '';
              $earns = array();
              $allws = array();
              $rels = array();
              $deds = array();

              foreach($earnings as $earning){
               $earns[] = "'".$earning->earning_name."'";
              }

              $earnname = implode(',',$earns);

              foreach($allowances as $allowance){
               $allws[] = $allowance->allowance_name;
              }

              foreach($reliefs as $relief){
               $rels[] = $relief->relief_name;
              }

              foreach($deductions as $deduction){
               $deds[] = $deduction->deduction_name;
              }



              $sheet->row(2, array(
              'Payroll Preview for '.$period
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');
                $cell->setAlignment('center');
              });


              $sheet->mergeCells('A2:K2');

              $sheet->row(3, array(
              '#','PF Number', 'Employee','Basic Pay',$earnname,'Overtime-Hourly','Overtime-Daily',implode(",",$allws),
              'Gross Pay','Total Tax','Tax Relief',implode(",",$rels),'Paye','Nssf','Nhif',implode(",",$deds),'Total Deductions','Net Pay'
              ));

               $sheet->cells('A3:D3', array(
              '#','PF Number', 'Employee','Basic Pay'
              ));

              $sheet->row(3, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');

              });

            $row = 4;


            for($i = 0; $i<count($data); $i++){

             $sheet->row($row, array(
             $i+1,$data[$i]->personal_file_number,$data[$i]->first_name.' '.$data[$i]->last_name,number_format(floatval($data[$i]->basic_pay), 2)
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('E'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('F'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('G'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('I'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('J'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('K'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;

             }
             /*$sheet->row($row, array(
             '','Total: ',number_format(floatval($total_pay), 2),number_format(floatval($total_earning), 2),number_format(floatval($total_gross), 2),number_format(floatval($total_paye), 2),number_format(floatval($total_nssf), 2),number_format(floatval($total_nhif), 2),number_format(floatval($total_others), 2),number_format(floatval($total_deds), 2),number_format(floatval($total_net), 2)
             ));*/
            /*$sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');

              });
            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('E'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('F'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('G'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('I'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('J'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('K'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->row($row+1, array(
             '','','','','','','','','','Total Net: ',number_format(floatval($total_net), 2)
             ));
            $sheet->row($row+1, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');

              });
            $sheet->cell('K'.($row+1), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });*/

    });

  })->download('xls');
}

public function asMoney($value){

        return number_format($value, 2);

    }

    public function dispgross(){
      $display = "";
      $postedit = Input::all();
      parse_str(Input::get('formdata'), $postedit);
      $net = str_replace( ',', '', $postedit['net1']);
      //print_r($searcharray['net1']);

       $total = 0;
        $gross = $net;
        $y =0 ;
        $x =0 ;
        $a =0 ;
        $z =  str_replace( ',', '', $postedit['net1']);


        $paye1 = 0;
        $nssf1 = 0;
        $nhif1 = 0;

    for($i=$net;;$i--){

    /*$nssf1 = DB::table('social_security')->whereNull('organization_id')->whereRaw($gross.' between income_from and income_to')->pluck('ss_amount_employee');

    $nhif1 = DB::table('hospital_insurance')->whereNull('organization_id')->whereRaw($gross.' between income_from and income_to')->pluck('hi_amount');    */

    $nssf1 = Payroll::nssfcalc($gross);
    $nhif1 = Payroll::nhifcalc($gross);

    $taxable = $gross-$nssf1;

    if($taxable>=13686 && $taxable<23884){
    $paye1 = (1229.8+($taxable-12298)*15/100)-1408.00;
    }else if($taxable>=23884 && $taxable<35470){
    $paye1 = ((1229.8+((11586.92)*0.15))+($taxable-23884)*20/100)-1408.00;
    }else if($taxable>=35470 && $taxable<47059){
    $paye1 = ((1229.8+(11586.92*0.15)+((11586.92)*0.2))+($taxable-35470)*25/100)-1408.00;
    }else if($taxable>=47059){
    $paye1 = ((1229.8+(11586.92*0.15)+(11586.92*0.2)+((11586.92)*0.25))+($taxable-47059)*30/100)-1408.00;
    }else{
    $paye1 = 0.00;
    }
    $total = $net-$paye1-$nssf1-$nhif1;
    $gross=($z-$total)+$net;
    $net=$total;
    $y=$x;
    $x=($gross-$net)/2;
    if($net+$x == 40000){
    $i=($x-$y);
    }else{
    if(round($a-($x-$y),2) == 0){
      if($gross<0){
        $gross = 0;
      }else{
        $gross=$gross;
      }
      break;
    }else{
    $i=$a-($x-$y);
    }
    }
    $a= ($x-$y);
    //echo $gross.'<br>';
    }


   // echo $nssf1;
        //return $display;

     return json_encode(["paye1"=>number_format($paye1,2),"nssf1"=>number_format($nssf1,2),"nhif1"=>number_format($nhif1,2),"netv"=>number_format($z,2),"gross1"=>number_format($gross, 2)]);

        //$net = number_format(Payroll::netcalc($employee->id,$fperiod),2);

   $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();

        /*$display .="
        <br/>

<div class='row'>
    <div class='col-lg-12'>
  <h3>Payroll Calculator</h3>

<hr>
</div>
</div>


<div class='row'>
    <div class='col-lg-5'>

      <div role='tabpanel'>

  <!-- Nav tabs -->
  <ul class='nav nav-tabs' role='tablist'>
    <li role='presentation'><a href='#grosstonet' aria-controls='grosstonet' role='tab' data-toggle='tab'>Gross to Net</a></li>
    <li role='presentation' class='active'><a href='#nettogross' aria-controls='nettogross' role='tab' data-toggle='tab'>Net to Gross</a></li>
  </ul>

  <!-- Tab panes -->
  <div class='tab-content'>


  <div role='tabpanel' class='tab-pane' id='grosstonet' class='displayrecord'>
    <form method='POST' action=".URL::to('shownet')." accept-charset='UTF-8'>
    <fieldset>";


       $a = str_replace( ',', '', Input::get('gross'));


   $display .="
       <div class='form-group'>
        <label for='username'>Gross Pay:</label>
        <div class='input-group'>
        <span class='input-group-addon'>".$currency->shortname."</span>
        <input class='form-control' placeholder='' type='text' name='gross' id='gross' value='0.00'>
        </div>
       </div>

        <div class='form-group'>
        <label for='username'>Paye:</label>
        <div class='input-group'>
            <span class='input-group-addon'>".$currency->shortname."</span>
         <input readonly class='form-control' placeholder='' type='text' name='paye' id='paye' value='0.00'>
        </div>

        <div class='form-group insts' id='insts'>
            <label for='username'>NSSF: </label>
            <div class='input-group'>
            <span class='input-group-addon'>".$currency->shortname."</span>
            <input readonly class='form-control' placeholder='' type='text' name='nssf' id='nssf' value='0.00'>
        </div>
      </div>

        <div class='form-group'>
            <label for='username'>NHIF: <span style='color:red'>*</span> </label>
            <div class='input-group'>
            <span class='input-group-addon'>".$currency->shortname."</span>
            <input readonly class='form-control' placeholder='' type='text' name='nhif' id='nhif' value='0.00'>
           </div>
        </div>

        <div class='form-group'>
        <label for='username'>Net:</label>
        <div class='input-group'>
            <span class='input-group-addon'>".$currency->shortname."</span>
         <input readonly class='form-control' placeholder='' type='text' name='net' id='net' value='0.00'>
        </div>
      </div>

    </fieldset>

    <div align='right' style='margin-top:0px;display:none;'' class='form-actions form-group'>

          <button class='btn btn-primary btn-sm process'>Get Net</button>
        </div>

        </form>


</div>



<div role='tabpanel' class='tab-pane active' id='nettogross'>
  <form method='POST' action=".URL::to('showgross')." accept-charset='UTF-8'>
    <fieldset>";

       $a = str_replace( ',', '', Input::get('net1'));

$display .="
       <div class='form-group'>
        <label for='username'>Gross Pay:</label>
        <div class='input-group'>
          <span class='input-group-addon'>".$currency->shortname."</span>
        <input class='form-control' readonly placeholder='' type='text' name='gross1' id='gross1' value='$gross'>
       </div>
       </div>

        <div class='form-group'>
        <label for='username'>Paye:</label>
        <div class='input-group'>
            <span class='input-group-addon'>".$currency->shortname."</span>
        <input readonly class='form-control' placeholder='' type='text' name='paye1' id='paye1' value='$paye1'>
        </div>
      </div>

        <div class='form-group insts' id='insts'>
            <label for='username'>NSSF: </label>
            <div class='input-group'>
            <span class='input-group-addon'>".$currency->shortname."</span>
        <input readonly class='form-control' placeholder='' type='text' name='nssf1' id='nssf1' value='$nssf1'>
        </div>
      </div>

        <div class='form-group'>
            <label for='username'>NHIF: <span style='color:red'>*</span> </label>
            <div class='input-group'>
            <span class='input-group-addon'>".$currency->shortname."</span>
        <input readonly class='form-control' placeholder='' type='text' name='nhif1' id='nhif1' value='$nhif1'>
        </div>
      </div>

        <div class='form-group'>
        <label for='username'>Net:</label>
        <div class='input-group'>
            <span class='input-group-addon'>".$currency->shortname."</span>
        <input class='form-control' placeholder='' type='text' name='net1' id='net1' value='$z'>
       </div>
        </div>
      </div>

    </fieldset>
    <div align='right' style='margin-top:0px;display:none;' class='form-actions form-group'>

          <button class='btn btn-primary btn-sm process' >Get Gross</button>
        </div>

        </form>
</div>


  </div>

</div>

</div>

</div> ";

        return $display;
        exit();*/

//return View::make('payroll.payroll_calculator', compact('net','paye1','nssf1','nhif1','gross','currency'));




    }


    public function display(){
      $display = "";
      $postedit = Input::all();
      $part1    = $postedit['period1'];
      $part2    = $postedit['period2'];
      $part3    = $postedit['period3'];
      $type     = $postedit['type'];

      $fperiod   = $part1.$part2.$part3;

      $start  = date('Y-m-01', strtotime("01-".$fperiod));
      $end   = date('Y-m-t', strtotime("01-".$fperiod));


      $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->whereDate('date_joined','<=',$end)
                  ->get();

      $department = Department::where('department_name','Management')
                  ->where(function($query){
                         $query->whereNull('organization_id')
                               ->orWhere('organization_id',Auth::user()->organization_id);
                 })->first();

      $jgroup = Jobgroup::where('job_group_name','Management')
                  ->where(function($query){
                         $query->whereNull('organization_id')
                               ->orWhere('organization_id',Auth::user()->organization_id);
                 })->first();

       if($type == 'management'){

         $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->where('job_group_id',$jgroup->id)
                  ->whereDate('date_joined','<=',$end)
                  ->get();
       }else{
          $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->where('job_group_id','!=',$jgroup->id)
                  ->whereDate('date_joined','<=',$end)
                  ->get();
       }

        $i=1;
        $salary   = 0.00;
        $earningA = 0;
        $hourly = 0;
        $Daily = 0;
        $allowanceA = 0;
        $nontaxableA = 0;
        $reliefA = 0;
        $deductionA = 0;
        $taxrelief = 0.00;
         $totalsalary = 0.00;
         $totalearning = 0.00;
         $totalhourly = 0.00;
         $totaldaily = 0.00;
         $totalallowance = 0.00;
         $totalnontaxable = 0.00;
         $totalrelief = 0.00;
         $totalgross = 0.00;
         $totaltax = 0.00;
         $totaltaxrelief = 0.00;
         $totalpaye = 0.00;
         $totalnssf = 0.00;
         $totalnhif = 0.00;
         $totalpension = 0.00;
         $otherdeduction = 0.00;
         $totaldeduction = 0.00;
         $totalnet = 0.00;


        $earnings = Earningsetting::where('organization_id',Auth::user()->organization_id)
        ->orWhereNull('organization_id')->get();
        $pays = Dailypay::where('organization_id',Auth::user()->organization_id)->get();
        $overtimes = Overtime::all();
        $allowances = Allowance::where('organization_id',Auth::user()->organization_id)
        ->orWhereNull('organization_id')->get();
        $nontaxables = Nontaxable::where('organization_id',Auth::user()->organization_id)
        ->orWhereNull('organization_id')->get();
        $reliefs = Relief::where('organization_id',Auth::user()->organization_id)->orWhereNull('organization_id')->get();
        $deductions = Deduction::where('organization_id',Auth::user()->organization_id)->orWhereNull('organization_id')->get();


        foreach($employees as $employee){

         $salary = number_format(Payroll::basicpay($employee->id,Input::get('period')),2);

         $hourly = number_format(Payroll::overtimes($employee->id,'Daily',$fperiod),2);
         $daily  = number_format(Payroll::overtimes($employee->id,'Hourly',$fperiod),2);
         $gross = number_format(Payroll::gross($employee->id,$fperiod),2);
         $tax = number_format(Payroll::totaltax($employee->id,$fperiod),2);
         if($employee->income_tax_applicable == 1 && (double)Payroll::gross($employee->id,$fperiod)>=11180 && $employee->income_tax_relief_applicable == 1){
          $taxrelief = number_format('1408',2);
          }else{
          $taxrelief = number_format('0.00',2);
          }
         $paye = number_format(Payroll::tax($employee->id,$fperiod),2);
         $nssf = number_format(Payroll::nssf($employee->id,$fperiod),2);
         $nhif = number_format(Payroll::nhif($employee->id,$fperiod),2);
         $pension = number_format(Payroll::pension($employee->id,$fperiod),2);
         $total_deductions = number_format(Payroll::total_deductions($employee->id,$fperiod),2);
         $net = number_format(Payroll::net($employee->id,$fperiod),2);

          $totalsalary = $totalsalary + (double)Payroll::basicpay($employee->id,Input::get('period'));
          $totalhourly = $totalhourly + (double)Payroll::overtimes($employee->id,'Hourly',$fperiod);
          $totaldaily = $totaldaily + (double)Payroll::overtimes($employee->id,'Daily',$fperiod);
          $totalgross = $totalgross + (double)Payroll::gross($employee->id,$fperiod);
          $totaltax = $totaltax + (double)Payroll::totaltax($employee->id,$fperiod);
          if($employee->income_tax_applicable == 1 && (double)Payroll::gross($employee->id,$fperiod)>=11180 && $employee->income_tax_relief_applicable == 1){
           $totaltaxrelief = $totaltaxrelief + 1408;
          }
           $totalpaye = $totalpaye + (double)Payroll::tax($employee->id,$fperiod);
           $totalnssf = $totalnssf + (double)Payroll::nssf($employee->id,$fperiod);
           $totalnhif = $totalnhif + (double)Payroll::nhif($employee->id,$fperiod);
           $totalpension = $totalpension + (double)Payroll::pension($employee->id,$fperiod);
           $totaldeduction = $totaldeduction + (double)Payroll::total_deductions($employee->id,$fperiod);
           $totalnet = $totalnet + (double)Payroll::net($employee->id,$fperiod);

        $display .="
        <tr>

          <td> $i </td>
          <td >$employee->personal_file_number</td>
          <td>$employee->first_name $employee->last_name </td>
          <td align='right'>$salary</td>
          ";
          foreach($earnings as $earning){
           $earningA = number_format(Payroll::earnings($employee->id,$earning->id,$fperiod),2);
           $display .="<td align='right'>$earningA</td>";
          }
          $display .="<td align='right'>$hourly</td>
          <td align='right'>$daily</td>";
          foreach($allowances as $allowance){
          $allowanceA = number_format(Payroll::allowances($employee->id,$allowance->id,$fperiod),2);
          $display .="<td align='right'>$allowanceA</td>";
          }
          $display .="<td align='right'>$gross</td>";
          foreach($nontaxables as $nontaxable){
          $nontaxableA = number_format(Payroll::nontaxables($employee->id,$nontaxable->id,$fperiod),2);
          $display .="<td align='right'>$nontaxableA</td>";
          }
          $display .="<td align='right'>$tax</td>
                      <td align='right'>$taxrelief</td>
          ";
          foreach($reliefs as $relief){
          $reliefA = number_format(Payroll::reliefs($employee->id,$relief->id,$fperiod),2);
          $display .="<td align='right'>$reliefA</td>";
          }
          $display .="<td align='right'>$paye</td>
          <td align='right'>$nssf</td>
          <td align='right'>$nhif</td>";
          foreach($deductions as $deduction){
          $deductionA = number_format(Payroll::deductions($employee->id,$deduction->id,$fperiod),2);
          $display .="<td align='right'>$deductionA</td>";
          }
          $display .="<td align='right'>$pension</td><td align='right'>$total_deductions</td>
          <td align='right'>$net</td>

          </tr>";
          $i++;

          }

          $display .="<tr style='background:#EEE;'>
          <td style='border-right:0 #FFF;'><span style='display:none'>$i</span></td>
          <td></td>
          <td align='right'><strong>Totals</strong></td>
          <td align='right'><strong>".number_format($totalsalary,2)."</strong></td>";
           foreach($earnings as $earning){
           $totalearning.$earning->id = $totalearning + (double)Payroll::totalearnings($earning->id,$fperiod,'');
           $display .="<td align='right'><strong>".number_format($totalearning.$earning->id,2)."</strong></td>";
           }
           $display .="<td align='right'><strong>".number_format($totalhourly,2)."</strong></td>
           <td align='right'><strong>".number_format($totaldaily,2)."</strong></td>";
           foreach($allowances as $allowance){
           $totalallowance.$allowance->id = $totalallowance + (double)Payroll::totalallowances($allowance->id,$fperiod,'');
           $display .="<td align='right'><strong>".number_format($totalallowance.$allowance->id,2)."</strong></td>";
           }

           $display .="<td align='right'><strong>".number_format($totalgross,2)."</strong></td>";
           foreach($nontaxables as $nontaxable){
           $totalnontaxable.$nontaxable->id = $totalnontaxable + (double)Payroll::totalnontaxable($nontaxable->id,$fperiod,'');
           $display .="<td align='right'><strong>".number_format($totalnontaxable.$nontaxable->id,2)."</strong></td>";
           }
          $display .="<td align='right'><strong>$totaltax</strong></td>
          <td align='right'><strong>".number_format($totaltaxrelief,2)."</strong></td>";
          foreach($reliefs as $relief){
           $totalrelief.$relief->id = $totalrelief + (double)Payroll::totalreliefs($relief->id,$fperiod,'');
           $display .="<td align='right'><strong>".number_format($totalrelief.$relief->id,2)."</strong></td>";
           }
          $display .="<td align='right'><strong>".number_format($totalpaye,2)."</strong></td>
          <td align='right'><strong>".number_format($totalnssf,2)."</strong></td>
          <td align='right'><strong>".number_format($totalnhif,2)."</strong></td>";
          foreach($deductions as $deduction){
           $otherdeduction.$deduction->id = $otherdeduction + (double)Payroll::totaldeductions($deduction->id,$fperiod,'');
           $display .="<td align='right'><strong>".number_format($otherdeduction.$deduction->id,2)."</strong></td>";
           }
          $display .="<td align='right'><strong>".number_format((double)Payroll::pension($employee->id,$fperiod),2)."</strong></td><td align='right'><strong>".number_format($totaldeduction,2)."</strong></td>
          <td align='right'><strong>".number_format($totalnet,2)."</strong></td>
        </tr>
        ";

        return $display;
        exit();

    }

    /**
     * Store a newly created branch in storage.
     *
     * @return Response
     */
    public function store()
    {

      $period = Input::get('period');

      $start  = date('Y-m-01', strtotime("01-".$period));
      $end   = date('Y-m-t', strtotime("01-".$period));

        $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->whereDate('date_joined','<=',$end)
                  ->get();


        $department = Department::where('department_name','Management')
                  ->where(function($query){
                         $query->whereNull('organization_id')
                               ->orWhere('organization_id',Auth::user()->organization_id);
                 })->first();


        $jgroup = Jobgroup::where('job_group_name','Management')
                  ->where(function($query){
                         $query->whereNull('organization_id')
                               ->orWhere('organization_id',Auth::user()->organization_id);
                 })->first();

       if(Input::get('type') == 'management'){

         $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->where('job_group_id',$jgroup->id)
                  ->whereDate('date_joined','<=',$end)
                  ->get();
       }else{
          $employees = DB::table('employee')
                  ->where('in_employment','=','Y')
                  ->where('organization_id',Auth::user()->organization_id)
                  ->where('job_group_id','!=',$jgroup->id)
                  ->whereDate('date_joined','<=',$end)
                  ->get();
       }

        foreach ($employees as $employee) {
        $payroll = new Payroll;

        $payroll->employee_id = $employee->personal_file_number;

        $payroll->user_id = Auth::user()->id;

        $payroll->basic_pay = Payroll::basicpay($employee->id,Input::get('period'));

        $payroll->earning_amount = Payroll::total_benefits($employee->id,Input::get('period'));
        $payroll->taxable_income = Payroll::gross($employee->id,Input::get('period'));
        $payroll->paye = Payroll::tax($employee->id,Input::get('period'));
        $payroll->relief = 1408;
        $payroll->nssf_amount = Payroll::nssf($employee->id,Input::get('period'));
        $payroll->nhif_amount = Payroll::nhif($employee->id,Input::get('period'));
        $payroll->other_deductions = Payroll::deductionall($employee->id,Input::get('period'));
        $payroll->total_deductions = Payroll::total_deductions($employee->id,Input::get('period'));
        $payroll->net = Payroll::net($employee->id,Input::get('period'));
        $payroll->financial_month_year = Input::get('period');
        $payroll->account_id = Input::get('account');
        $payroll->process_type = Input::get('type');
        $payroll->organization_id = Auth::user()->organization_id;
        $payroll->save();

        }


        $part = explode("-", $period);
        $start = $part[1]."-".$part[0]."-01";
        $end  = date('Y-m-t', strtotime($start));

        //DB::table('dailypays')->where('period',$period)->where('status',0)->update(array("status"=>1));

        if(Input::get('type') == 'management'){

        $allws = DB::table('employee_allowances')
            ->join('allowances', 'employee_allowances.allowance_id', '=', 'allowances.id')
            ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('employee.id as eid','employee_allowances.id as id','allowance_name','allowance_id','allowance_amount')
            ->get();

        $count_a = DB::table('employee_allowances')
            ->join('allowances', 'employee_allowances.allowance_id', '=', 'allowances.id')
            ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('employee.id as eid','employee_allowances.id as id','allowance_name','allowance_id','allowance_amount')
            ->count();

        if($count_a>0){
        foreach($allws as $allw){
        DB::table('transact_allowances')->insert(
        ['employee_id' => $allw->eid,
        'employee_allowance_id' => $allw->id,
        'organization_id' => Auth::user()->organization_id,
        'allowance_name' => $allw->allowance_name,
        'allowance_id' => $allw->allowance_id,
        'allowance_amount' => $allw->allowance_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type'),
        ]
        );
        }

         DB::table('employee_allowances')
             ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->whereDate('date_joined','<=',$end)
             ->where('job_group_id',$jgroup->id)
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->decrement('instalments');

        }


        $nontaxes = DB::table('employeenontaxables')
            ->join('nontaxables', 'employeenontaxables.nontaxable_id', '=', 'nontaxables.id')
            ->join('employee', 'employeenontaxables.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('employee.id as eid','employeenontaxables.id as id','name','nontaxable_id','nontaxable_amount')
            ->get();

        $count_ntax = DB::table('employeenontaxables')
            ->join('nontaxables', 'employeenontaxables.nontaxable_id', '=', 'nontaxables.id')
            ->join('employee', 'employeenontaxables.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('employee.id as eid','employeenontaxables.id as id','name','nontaxable_id','nontaxable_amount')
            ->count();

        if($count_ntax>0){
        foreach($nontaxes as $nontax){
        DB::table('transact_nontaxables')->insert(
        ['employee_id' => $nontax->eid,
        'organization_id' => Auth::user()->organization_id,
        'employee_nontaxable_id' => $nontax->id,
        'nontaxable_name' => $nontax->name,
        'nontaxable_id' => $nontax->nontaxable_id,
        'nontaxable_amount' => $nontax->nontaxable_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type'),
        ]
        );
        }

         DB::table('employeenontaxables')
             ->join('employee', 'employeenontaxables.employee_id', '=', 'employee.id')
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->where('job_group_id',$jgroup->id)
             ->whereDate('date_joined','<=',$end)
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->decrement('instalments');

        }

        $deds = DB::table('employee_deductions')
            ->join('deductions', 'employee_deductions.deduction_id', '=', 'deductions.id')
            ->join('employee', 'employee_deductions.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('employee.id as eid','employee_deductions.id as id','deduction_name','deduction_id','formular','instalments','deduction_amount')
            ->get();

        $count = DB::table('employee_deductions')
            ->join('deductions', 'employee_deductions.deduction_id', '=', 'deductions.id')
            ->join('employee', 'employee_deductions.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('employee.id as eid','employee_deductions.id as id','deduction_name','deduction_id','formular','instalments','deduction_amount')
            ->count();

        if($count>0){
        foreach($deds as $ded){
        DB::table('transact_deductions')->insert(
        ['employee_id' => $ded->eid,
        'organization_id' => Auth::user()->organization_id,
        'employee_deduction_id' => $ded->id,
        'deduction_name' => $ded->deduction_name,
        'deduction_id' => $ded->deduction_id,
        'deduction_amount' => $ded->deduction_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type')
        ]
        );
        }

        DB::table('employee_deductions')
             ->join('employee', 'employee_deductions.employee_id', '=', 'employee.id')
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->where('job_group_id',$jgroup->id)
             ->whereDate('date_joined','<=',$end)
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->decrement('instalments');

        }


        $part = explode("-", Input::get('period'));
        $month = '';
       if($part[0] == 01){
         $month = 'Jan';
        }else if($part[0] == 02){
         $month = 'Feb';
        }else if($part[0] == 03){
         $month = 'Mar';
        }else if($part[0] == 04){
         $month = 'Apr';
        }else if($part[0] == 05){
         $month = 'May';
        }else if($part[0] == 06){
         $month = 'Jun';
        }else if($part[0] == 07){
         $month = 'Jul';
        }else if($part[0] == 8){
         $month = 'Aug';
        }else if($part[0] == 9){
         $month = 'Sep';
        }else if($part[0] == 10){
         $month = 'Oct';
        }else if($part[0] == 11){
         $month = 'Nov';
        }else if($part[0] == 12){
         $month = 'Dec';
        }

        $cp = DB::table('pensions')
            ->join('employee', 'pensions.employee_id', '=', 'employee.id')
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->count();

        $pensions = DB::table('pensions')
            ->join('employee', 'pensions.employee_id', '=', 'employee.id')
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->get();

        if($cp>0){

        foreach($pensions as $pension){
        DB::table('transact_pensions')->insert(
        ['employee_id' => $pension->employee_id,
        'organization_id' => Auth::user()->organization_id,
        'employee_amount' => $pension->employee_contribution,
        'employer_amount' => $pension->employer_contribution,
        'employee_percentage' => $pension->employee_percentage,
        'employer_percentage' => $pension->employer_percentage,
        'financial_month_year'=>Input::get('period'),
        'month'=>$part[0],
        'year'=>$part[1]
        ]
        );
        }

        }


        $earns = DB::table('earnings')
            ->join('employee', 'earnings.employee_id', '=', 'employee.id')
            ->join('earningsettings', 'earnings.earning_id', '=', 'earningsettings.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('job_group_id',$jgroup->id)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('earnings.employee_id','earnings.id as id','earning_name','earnings_amount','formular','instalments')
            ->get();

        $ct = DB::table('earnings')
            ->join('employee', 'earnings.employee_id', '=', 'employee.id')
            ->join('earningsettings', 'earnings.earning_id', '=', 'earningsettings.id')
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
           ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('earnings.employee_id','earnings.id as id','earning_name','earnings_amount','formular','instalments')
            ->count();

        if($ct>0){
        foreach($earns as $earn){
        DB::table('transact_earnings')->insert(
        ['employee_id' => $earn->employee_id,
        'earning_id' => $earn->id,
        'organization_id' => Auth::user()->organization_id,
        'earning_name' => $earn->earning_name,
        'earning_amount' => $earn->earnings_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type')
        ]
        );
        }

        DB::table('earnings')
             ->join('employee', 'earnings.employee_id', '=', 'employee.id')
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->where('job_group_id',$jgroup->id)
             ->whereDate('date_joined','<=',$end)
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->decrement('instalments');

        }

        $overtimes = DB::table('overtimes')
            ->join('employee', 'overtimes.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('job_group_id',$jgroup->id)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('overtimes.employee_id','overtimes.id','overtimes.type','overtimes.period','overtimes.amount')
            ->get();

         $co = DB::table('overtimes')
            ->join('employee', 'overtimes.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('first_day_month','<=',$start)
                             ->where('job_group_id',$jgroup->id);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('last_day_month','>=',$start)
                              ->where('job_group_id',$jgroup->id);
                        })
            ->select('overtimes.employee_id','overtimes.id','overtimes.type','overtimes.period','overtimes.amount')
            ->count();

        if($co>0){

        foreach($overtimes as $overtime){
        DB::table('transact_overtimes')->insert(
        ['employee_id' => $overtime->employee_id,
        'organization_id' => Auth::user()->organization_id,
        'overtime_type' => $overtime->type,
        'overtime_id' => $overtime->id,
        'overtime_period' => $overtime->period,
        'overtime_amount' => $overtime->amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type')
        ]
        );
        }

        DB::table('overtimes')
             ->join('employee', 'overtimes.employee_id', '=', 'employee.id')
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->where('job_group_id',$jgroup->id)
             ->whereDate('date_joined','<=',$end)
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->decrement('instalments');

        }

        $rels = DB::table('employee_relief')
            ->join('relief', 'employee_relief.relief_id', '=', 'relief.id')
            ->join('employee', 'employee_relief.employee_id', '=', 'employee.id')
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('job_group_id',$jgroup->id)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->select('employee.id as eid','employee_relief.id as id','relief_name','relief_id','relief_amount')
            ->get();

        foreach($rels as $rel){
        DB::table('transact_reliefs')->insert(
        ['employee_id' => $rel->eid,
        'organization_id' => Auth::user()->organization_id,
        'employee_relief_id' => $rel->id,
        'relief_name' => $rel->relief_name,
        'relief_id' => $rel->relief_id,
        'relief_amount' => $rel->relief_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type')
        ]
        );
        }
        }else{
         $allws = DB::table('employee_allowances')
            ->join('allowances', 'employee_allowances.allowance_id', '=', 'allowances.id')
            ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('employee.id as eid','employee_allowances.id as id','allowance_name','allowance_id','allowance_amount')
            ->get();

        $count_a = DB::table('employee_allowances')
            ->join('allowances', 'employee_allowances.allowance_id', '=', 'allowances.id')
            ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->whereDate('date_joined','<=',$end)
            ->where('job_group_id','!=',$jgroup->id)
            ->where('in_employment','Y')
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('employee.id as eid','employee_allowances.id as id','allowance_name','allowance_id','allowance_amount')
            ->count();

        if($count_a>0){
        foreach($allws as $allw){
        DB::table('transact_allowances')->insert(
        ['employee_id' => $allw->eid,
        'employee_allowance_id' => $allw->id,
        'organization_id' => Auth::user()->organization_id,
        'allowance_name' => $allw->allowance_name,
        'allowance_id' => $allw->allowance_id,
        'allowance_amount' => $allw->allowance_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type'),
        ]
        );
        }

         DB::table('employee_allowances')
             ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
             ->whereDate('date_joined','<=',$end)
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->where('job_group_id','!=',$jgroup->id)
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->decrement('instalments');

        }


        $nontaxes = DB::table('employeenontaxables')
            ->join('nontaxables', 'employeenontaxables.nontaxable_id', '=', 'nontaxables.id')
            ->join('employee', 'employeenontaxables.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('employee.id as eid','employeenontaxables.id as id','name','nontaxable_id','nontaxable_amount')
            ->get();

        $count_ntax = DB::table('employeenontaxables')
            ->join('nontaxables', 'employeenontaxables.nontaxable_id', '=', 'nontaxables.id')
            ->join('employee', 'employeenontaxables.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('employee.id as eid','employeenontaxables.id as id','name','nontaxable_id','nontaxable_amount')
            ->count();

        if($count_ntax>0){
        foreach($nontaxes as $nontax){
        DB::table('transact_nontaxables')->insert(
        ['employee_id' => $nontax->eid,
        'organization_id' => Auth::user()->organization_id,
        'employee_nontaxable_id' => $nontax->id,
        'nontaxable_name' => $nontax->name,
        'nontaxable_id' => $nontax->nontaxable_id,
        'nontaxable_amount' => $nontax->nontaxable_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type'),
        ]
        );
        }

         DB::table('employeenontaxables')
             ->join('employee', 'employeenontaxables.employee_id', '=', 'employee.id')
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->where('job_group_id','!=',$jgroup->id)
             ->whereDate('date_joined','<=',$end)
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->decrement('instalments');

        }

        $deds = DB::table('employee_deductions')
            ->join('deductions', 'employee_deductions.deduction_id', '=', 'deductions.id')
            ->join('employee', 'employee_deductions.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('employee.id as eid','employee_deductions.id as id','deduction_name','deduction_id','formular','instalments','deduction_amount')
            ->get();

        $count = DB::table('employee_deductions')
            ->join('deductions', 'employee_deductions.deduction_id', '=', 'deductions.id')
            ->join('employee', 'employee_deductions.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where('job_group_id','!=',$jgroup->id)
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('employee.id as eid','employee_deductions.id as id','deduction_name','deduction_id','formular','instalments','deduction_amount')
            ->count();

        if($count>0){
        foreach($deds as $ded){
        DB::table('transact_deductions')->insert(
        ['employee_id' => $ded->eid,
        'organization_id' => Auth::user()->organization_id,
        'employee_deduction_id' => $ded->id,
        'deduction_name' => $ded->deduction_name,
        'deduction_id' => $ded->deduction_id,
        'deduction_amount' => $ded->deduction_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type')
        ]
        );
        }

        DB::table('employee_deductions')
             ->join('employee', 'employee_deductions.employee_id', '=', 'employee.id')
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->where('job_group_id','!=',$jgroup->id)
             ->whereDate('date_joined','<=',$end)
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->decrement('instalments');

        }

        $part = explode("-", Input::get('period'));
        $month = '';
       if($part[0] == 01){
         $month = 'Jan';
        }else if($part[0] == 02){
         $month = 'Feb';
        }else if($part[0] == 03){
         $month = 'Mar';
        }else if($part[0] == 04){
         $month = 'Apr';
        }else if($part[0] == 05){
         $month = 'May';
        }else if($part[0] == 06){
         $month = 'Jun';
        }else if($part[0] == 07){
         $month = 'Jul';
        }else if($part[0] == 8){
         $month = 'Aug';
        }else if($part[0] == 9){
         $month = 'Sep';
        }else if($part[0] == 10){
         $month = 'Oct';
        }else if($part[0] == 11){
         $month = 'Nov';
        }else if($part[0] == 12){
         $month = 'Dec';
        }

        $cp = DB::table('pensions')
            ->join('employee', 'pensions.employee_id', '=', 'employee.id')
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->count();

        $pensions = DB::table('pensions')
            ->join('employee', 'pensions.employee_id', '=', 'employee.id')
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->get();

        if($cp>0){

        foreach($pensions as $pension){
        DB::table('transact_pensions')->insert(
        ['employee_id' => $pension->employee_id,
        'organization_id' => Auth::user()->organization_id,
        'employee_amount' => $pension->employee_contribution,
        'employer_amount' => $pension->employer_contribution,
        'employee_percentage' => $pension->employee_percentage,
        'employer_percentage' => $pension->employer_percentage,
        'financial_month_year'=>Input::get('period'),
        'month'=>$part[0],
        'year'=>$part[1]
        ]
        );
        }

        }


        $earns = DB::table('earnings')
            ->join('employee', 'earnings.employee_id', '=', 'employee.id')
            ->join('earningsettings', 'earnings.earning_id', '=', 'earningsettings.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('earnings.employee_id','earnings.id as id','earning_name','earnings_amount','formular','instalments')
            ->get();

        $ct = DB::table('earnings')
            ->join('employee', 'earnings.employee_id', '=', 'employee.id')
            ->join('earningsettings', 'earnings.earning_id', '=', 'earningsettings.id')
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
           ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('earnings.employee_id','earnings.id as id','earning_name','earnings_amount','formular','instalments')
            ->count();

        if($ct>0){
        foreach($earns as $earn){
        DB::table('transact_earnings')->insert(
        ['employee_id' => $earn->employee_id,
        'earning_id' => $earn->id,
        'organization_id' => Auth::user()->organization_id,
        'earning_name' => $earn->earning_name,
        'earning_amount' => $earn->earnings_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type')
        ]
        );
        }

        DB::table('earnings')
             ->join('employee', 'earnings.employee_id', '=', 'employee.id')
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->where('job_group_id','!=',$jgroup->id)
             ->whereDate('date_joined','<=',$end)
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->decrement('instalments');

        }

        $overtimes = DB::table('overtimes')
            ->join('employee', 'overtimes.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('overtimes.employee_id','overtimes.id','overtimes.type','overtimes.period','overtimes.amount')
            ->get();

         $co = DB::table('overtimes')
            ->join('employee', 'overtimes.employee_id', '=', 'employee.id')
            ->where('instalments','>',0)
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('job_group_id','!=',$jgroup->id)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->where(function ($query) use ($start,$jgroup){
                       $query->where('formular', '=', 'Recurring')
                             ->where('job_group_id','!=',$jgroup->id)
                             ->where('first_day_month','<=',$start);
                       })
            ->orWhere(function ($query) use ($start,$jgroup) {
                        $query->where('first_day_month','<=',$start)
                              ->where('job_group_id','!=',$jgroup->id)
                              ->where('last_day_month','>=',$start);
                        })
            ->select('overtimes.employee_id','overtimes.id','overtimes.type','overtimes.period','overtimes.amount')
            ->count();

        if($co>0){

        foreach($overtimes as $overtime){
        DB::table('transact_overtimes')->insert(
        ['employee_id' => $overtime->employee_id,
        'organization_id' => Auth::user()->organization_id,
        'overtime_type' => $overtime->type,
        'overtime_id' => $overtime->id,
        'overtime_period' => $overtime->period,
        'overtime_amount' => $overtime->amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type')
        ]
        );
        }

        DB::table('overtimes')
             ->join('employee', 'overtimes.employee_id', '=', 'employee.id')
             ->where('employee.organization_id',Auth::user()->organization_id)
             ->where('job_group_id','!=',$jgroup->id)
             ->whereDate('date_joined','<=',$end)
             ->where(function($query){
                $query->where('formular','=','One Time')
                      ->orWhere('formular','=','Instalments');
               })
             ->where('instalments','>',0)
             ->decrement('instalments');

        }

        $rels = DB::table('employee_relief')
            ->join('relief', 'employee_relief.relief_id', '=', 'relief.id')
            ->join('employee', 'employee_relief.employee_id', '=', 'employee.id')
            ->where('in_employment','Y')
            ->whereDate('date_joined','<=',$end)
            ->where('job_group_id','!=',$jgroup->id)
            ->where('employee.organization_id',Auth::user()->organization_id)
            ->select('employee.id as eid','employee_relief.id as id','relief_name','relief_id','relief_amount')
            ->get();

        foreach($rels as $rel){
        DB::table('transact_reliefs')->insert(
        ['employee_id' => $rel->eid,
        'organization_id' => Auth::user()->organization_id,
        'employee_relief_id' => $rel->id,
        'relief_name' => $rel->relief_name,
        'relief_id' => $rel->relief_id,
        'relief_amount' => $rel->relief_amount,
        'financial_month_year'=>Input::get('period'),
        'process_type'=>Input::get('type')
        ]
        );
        }
        }

        $period = Input::get('period');
        Audit::logaudit('Payroll', 'process', 'processed payroll for '.$period);

    return Redirect::route('payroll.index')->withFlashMessage('Payroll successfully processed!');


    }



    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $payroll = Payroll::findOrFail($id);

        return View::make('payroll.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $deduction = Deduction::find($id);

        return View::make('deductions.edit', compact('deduction'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $deduction = Deduction::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Deduction::$rules, Deduction::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $deduction->deduction_name = Input::get('name');
        $deduction->update();

        return Redirect::route('deductions.index');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Deduction::destroy($id);

        return Redirect::route('deductions.index');
    }

}
