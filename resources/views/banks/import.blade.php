@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-lg-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>DATA MIGRATION</h3>

                            @if (Session::get('notice'))
                                <div class="alert alert-success">{{ Session::get('notice') }}</div>
                            @endif
                        </div>
                        <div class="card-block">

                            <form method="post" action="{{url('import/banks')}}" accept-charset="UTF-8" enctype="multipart/form-data">@csrf

                                <div class="form-group">

                                    <label>Upload Banks (excel)</label>
                                    <input type="file" class="" name="banks" value="{{asset('/Excel/banks.xls')}}" />

                                </div>

                                <button type="submit" class="btn btn-primary">Import Bank</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
