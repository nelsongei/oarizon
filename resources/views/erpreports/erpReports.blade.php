@extends('layouts.main_hr')
@section('xara_cbs')

<div class="pcoded-inner-content">
  <div class="main-body">
      <div class="page-wrapper">
          <div class="page-body">
              <!-- [ page content ] start -->
              <div class="card">
                  <div class="card-header">
                      <h3>Erp Reports</h3>

                      @if (Session::has('flash_message'))

                          <div class="alert alert-success">
                              {{ Session::get('flash_message') }}
                          </div>
                      @endif

                      @if (Session::has('delete_message'))

                          <div class="alert alert-danger">
                              {{ Session::get('delete_message') }}
                          </div>
                      @endif

                  </div>
                  <div class="card-block">
                    <div class="col-lg-12">

                      <ul class="reports">
                        <li>
                              <a href="{{ URL::to('erpReports/selectSalesPeriod') }}">Sales</a>
                         </li>
                  
                         <li>
                              <a href="{{ URL::to('erpReports/sales_summary') }}" target="_blank">Sales Summary</a>
                         </li> 
                  
                         <li>
                              <a href="{{ URL::to('erpReports/selectPurchasesPeriod') }}">Purchases</a>
                         </li>
                  
                         <li>
                              <a href="{{ URL::to('erpReports/selectClientsPeriod') }}">Station</a>
                         </li>
                         <!--<li>
                              <a href="{{ URL::to('erpReports/quotationReport') }}">Quotations/Invoice</a>
                         </li>-->
                  
                         <li>
                            <a href="{{ URL::to('erpReports/selectItemsPeriod') }}">Items</a>
                         </li>
                  
                         <li>
                            <a href="{{ URL::to('erpReports/selectExpensesPeriod') }}">Expenses</a>
                         </li>
                      
                         <li>
                            <a href="{{ URL::to('erpReports/paymentmethods') }}" target="_blank">Payment Methods</a>
                         </li>  
                  
                         <li>
                           <a href="{{ URL::to('erpReports/selectPaymentsPeriod') }}">Payments</a>     
                         </li>
                  
                          <li>
                           <a href="{{ URL::to('erpReports/locations') }}" target="_blank">Stores</a>     
                         </li> 
                  
                          <li>
                           <a href="{{ URL::to('erpReports/selectStockPeriod') }}">Stock report </a>      
                         </li>
                  
                          <li>
                           <a href="{{ URL::to('erpReports/pricelist') }}" target="_blank">Price List </a>     
                         </li>
                  
                          <li>
                           <a href="{{ URL::to('erpReports/accounts') }}" target="_blank">Account Balances </a>     
                         </li>
                          <li>
                           <a href="{{ URL::to('erpReports/itemscategory') }}" target="_blank">Items Category </a>     
                         </li> 
                  
                        <!--<li>
                          <a href="reports/blank" target="_blank">Blank report template</a>
                        </li>
                        <li>
                          <a href="reports/blank" target="_blank">Claims Reports</a>
                        </li>
                        <li>
                          <a href="{{URL::to('usageGenerate')}}" target="_blank">Usage Report</a>
                        </li>-->
                      </ul>
                  
                    </div>

                  </div>
              </div>
              <!-- [ page content ] end -->
          </div>
      </div>
  </div>
</div>
@stop