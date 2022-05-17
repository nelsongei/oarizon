@extends('layouts.main_hr')
@section('xara_cbs')

<div class="pcoded-inner-content">
  <div class="main-body">
      <div class="page-wrapper">
          <div class="page-body">
              <!-- [ page content ] start -->
              <div class="card">
                  <div class="card-header">
                      <h3>Select Sales Period</h3>

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
                    <div class="col-lg-5">

    
		
                      @if ($errors->count())
                         <div class="alert alert-danger">
                             @foreach ($errors->all() as $error)
                                 {{ $error }}<br>        
                             @endforeach
                         </div>
                         @endif
                 
                      <form method="POST" action="{{URL::to('erpReports/sales')}}" accept-charset="UTF-8" target="_blank">
                    
                     <fieldset>
                 
                     <div class="form-group">
                             <label for="username">Clients <span style="color:red">*</span> :</label>
                             <select name="client" class="form-control" required>
                             <option> select client ... </option>
                             <option></option>
                             <option value="all">All Clients</option>
                                 @foreach($clients as $client)
                                 <option value="{{$client->id}}">{{$client->name}}</option>
                                 @endforeach               
                             </select>
                         </div>  
                 
                         <div class="form-group">
                                         <label for="username">From<span style="color:red">*</span></label>
                                         <div class="right-inner-addon ">
                                         <i class="glyphicon glyphicon-calendar"></i>
                                         <input required class="form-control date" readonly="readonly" placeholder="" type="text" name="from" id="from" value="{{{ Request::old('from') }}}">
                                     </div>
                        </div>
                 
                        <div class="form-group">
                                         <label for="username">To <span style="color:red">*</span></label>
                                         <div class="right-inner-addon ">
                                         <i class="glyphicon glyphicon-calendar"></i>
                                         <input required class="form-control date" readonly="readonly" placeholder="" type="text" name="to" id="to" value="{{{ Request::old('to') }}}">
                                     </div>
                        </div>
                         
                       
                        
                      
                 
                         <div class="form-actions form-group">
                         
                           <button type="submit" class="btn btn-primary btn-sm" >Select</button>
                         </div>
                 
                     </fieldset>
                 </form>
                     
                 
                   </div>

                  </div>
              </div>
              <!-- [ page content ] end -->
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
    $('.date').datepicker({  
       format: 'mm-dd-yyyy'
     });  
</script> 
@stop