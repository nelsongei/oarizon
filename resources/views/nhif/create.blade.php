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
                            <h3>New Nhif Rate</h3>
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
                                    <form method="POST" action="{{{ url('nhif') }}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">Income From <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="date" name="i_from" id="i_from"
                                                       value="{{{ old('i_from') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Income To <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="date" name="i_to" id="i_to"
                                                       value="{{{ old('i_to') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Amount <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="amount" id="amount"
                                                       value="{{{ old('amount') }}}">
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Nhif Rate</button>
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
    <div class="row">
    </div>
    <div class="row">
        <div class="col-lg-5">

        </div>

    </div>

@stop
