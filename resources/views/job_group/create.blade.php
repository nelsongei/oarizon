@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>New Job Group</h3>
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
                                    <form method="POST" action="{{{ URL::to('job_group') }}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">Job Group Name <span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text" name="name"
                                                       id="name"
                                                       value="{{{ old('name') }}}">
                                            </div>
                                            <div class="form-actions form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">Create Job Group
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
    <div class="row">
        <div class="col-lg-5">


        </div>

    </div>

@stop
