@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>New Supplier</h3>

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

		 <form method="POST" action="{{{ URL::to('suppliers') }}}" accept-charset="UTF-8">

    <fieldset>
        <div class="form-group">
            <label for="username">Supplier Name <span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ Request::old('name') }}}" required>
        </div>

         <div class="form-group">
            <label for="username">Email:</label>
            <input class="form-control" placeholder="" data-parsley-trigger="focusout focusin" type="email" name="email_office" id="email_office" value="{{{Request::old('email_office') }}}" >
        </div>

        <div class="form-group">
            <label for="username">Phone:</label>
            <input class="form-control" placeholder="" data-parsley-trigger="change focusout" data-parsley-type="number" minlenght="10" type="text" name="office_phone" id="office_phone" value="{{{ Request::old('office_phone') }}}">
        </div>

        <div class="form-group">
            <label for="username">Address:</label>
            <input class="form-control" placeholder="" type="text" name="address" id="address" value="{{{ Request::old('email_personal') }}}">
        </div>

        <div class="form-group">
            <label for="username">Contact Name :</label>
            <input class="form-control" placeholder="" type="text" name="cname" id="cname" value="{{{ Request::old('cname') }}}">
        </div>

        <div class="form-group">
            <label for="username">Contact Personal Email:</label>
            <input class="form-control" placeholder=""data-parsley-trigger="focuout focusin" type="email" name="email_personal" id="email_personal" value="{{{ Request::old('email_personal') }}}">
        </div>

        <div class="form-group">
            <label for="username">Contact Personal Contact:</label>
            <input class="form-control" placeholder="" type="text" name="mobile_phone" id="mobile_phone" value="{{{ Request::old('address') }}}">
        </div>

				<!--<div class="form-group">
						<input type="hidden" class="form-check-input" name="type" value="Supplier">
						<label class="username" for="exampleCheck1" value="Supplier">Supplier</label>
				</div>-->
                <input type="hidden" name="type" value="Supplier">


        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary btn-sm">Create Supplier</button>
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