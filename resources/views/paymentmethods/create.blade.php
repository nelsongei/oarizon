@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>New Payment Method</h3>

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

		 <form method="POST" action="{{{ URL::to('paymentmethods') }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Payment Method <span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ Request::old('name') }}}" required>
        </div>

        <div class="form-group">
            <label for="username">Account</label><span style="color:red">*</span> :
           <select name="account" class="form-control" required>
                           <option></option>
                           @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                           @endforeach
                        </select>
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create</button>
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
@stop