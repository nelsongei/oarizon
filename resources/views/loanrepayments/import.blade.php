@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-lg-12">
                        @if(Session::get('notice'))
                            <div class="alert alert-success">{{ Session::get('notice') }}</div>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-header">
                            LOAN REPAYMENTS MIGRATION

                            <p><strong>Import Loan Repayments </strong></p>
                        </div>
                        <div class="card-block">

                            <form method="post" action="{{url('import_repayments')}}" accept-charset="UTF-8"
                                  enctype="multipart/form-data">@csrf
                                <div class="form-group">
                                    <label>Upload Repayment (Excel Sheet)</label>
                                    <input type="file" class="" name="repayments" value="{{asset('/Excel/banks.xls')}}" required/>
                                </div>
                                <button type="submit" class="btn btn-primary">Import Repayments</button>
                                &nbsp;
                                <a href="{{ url('repayments_template') }}" class="btn btn-success">Download Template</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
