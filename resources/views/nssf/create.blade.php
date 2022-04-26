@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>New Nssf Rate</h3>

                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif
                                    <form method="POST" action="{{{ URL::to('nssf') }}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">Tier <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="tier"
                                                       id="tier"
                                                       value="{{{ old('tier') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Income From <span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text" name="i_from"
                                                       id="i_from"
                                                       value="{{{ old('i_from') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Income To <span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text" name="i_to"
                                                       id="i_to"
                                                       value="{{{ old('i_to') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Employee Amount <span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text"
                                                       name="employee_amount"
                                                       id="employee_amount" value="{{{ old('employee_amount') }}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Employer Amount <span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text"
                                                       name="employer_amount"
                                                       id="employer_amount" value="{{{ old('employer_amount') }}}">
                                            </div>
                                            <div class="form-actions form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">Create Nssf Rate
                                                </button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
