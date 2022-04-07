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
                            <h3>New Currency</h3>


                        </div>
                        <div class="card-block">

                            <form method="POST" action="{{{ url('currencies') }}}" accept-charset="UTF-8">@csrf

                                <fieldset>
                                    <div class="form-group">
                                        <label for="username">Currency Name</label>
                                        <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ old('name') }}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Currency Code</label>
                                        <input class="form-control" placeholder="" type="text" name="shortname" id="shortname" value="{{{ old('shortname') }}}">
                                    </div>

                                    <div class="form-actions form-group">

                                        <button type="submit" class="btn btn-primary btn-sm">Create Currency</button>
                                    </div>

                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
