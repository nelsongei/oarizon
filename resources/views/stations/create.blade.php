@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>New Station</h3>

                            @if ($errors->count())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{{ URL::to('stations') }}}" accept-charset="UTF-8">
                                @csrf
                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Station Name <span style="color:red">*</span> :</label>
                                        <input class="form-control" placeholder="" type="text" name="station_name"
                                               id="name" value="{{{ Request::old('name') }}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Location <span style="color:red">*</span> :</label>
                                        <input class="form-control" placeholder="" type="text" name="location" id="name"
                                               value="{{{ Request::old('name') }}}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Description <span style="color:red">*</span> :</label>
                                        <input class="form-control" placeholder="" type="text" name="description"
                                               id="name" value="{{{ Request::old('name') }}}" required>
                                    </div>


                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Create Station</button>
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
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            /*$("#purchase_price").hide();*/
            $('#product').click(function () {

                if ($('#product').is(":checked")) {
                    $('#product:checked').each(function () {

                        $("#purchase_price").show();

                        $("#selling_price").show();

                        $("#reorderlevel").show();

                        $("#store_unit").show();

                    });
                } else {

                    $("#purchase_price").hide();

                    $("#selling_price").hide();
                }
            });


            $('#service').click(function () {

                if ($('#service').is(":checked")) {
                    $('#service:checked').each(function () {
                        $("#purchase_price").hide();
                        $("#selling_price").show();
                        $("#reorderlevel").hide();
                        $("#store_unit").hide();

                    });
                } else {

                    $("#selling_price").hide();
                    $("#reorderlevel").show();
                    $("#store_unit").show();
                }
            });

        });
    </script>
@stop
