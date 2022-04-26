@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Update Promotion/ Demotion</h3>

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

                                    <form method="POST" action="{{{ URL::to('promotions/update/'.$promotion->id) }}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">Employee <span style="color:red">*</span></label>
                                                <select name="employee" class="form-control">
                                                    <option></option>
                                                    @foreach($employees as $employee)
                                                        <option
                                                            value="{{ $employee->id }}"<?= ($promotion->employee_id == $employee->id) ? 'selected="selected"' : ''; ?>> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Reason<span style="color:red">*</span> </label>
                                                <textarea class="form-control" name="reason"
                                                          id="reason">{{$promotion->reason}}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Type <span style="color:red">*</span></label>
                                                <select name="type" id="type" class="form-control forml">
                                                    <option></option>
                                                    <option id="sus"
                                                            value="Promotion"<?= ($promotion->type == 'Promotion') ? 'selected="selected"' : ''; ?>>
                                                        Promotion
                                                    </option>
                                                    <option
                                                        value="Warning"<?= ($promotion->type == 'Demotion') ? 'selected="selected"' : ''; ?>>
                                                        Demotion
                                                    </option>

                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="username">Date <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input class="form-control" placeholder="" type="date"
                                                           name="date" id="date"
                                                           value="{{ $promotion->promotion_date }}">
                                                </div>
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#d').hide();
            $('#action').change(function () {
                if ($(this).val() === "Suspension") {
                    $('#d').show();
                } else {
                    $('#d').hide();
                }
            });
            $('#action option#sus').each(function () {
                if (this.selected) {
                    $('#d').show();
                } else {
                    $('#d').hide();
                }
            });

        });
    </script>
    {{--    <script type="text/javascript">--}}
    {{--        $(function () {--}}

    {{--            $('.allowancedate').datepicker({--}}
    {{--                format: 'yyyy-mm-dd',--}}
    {{--                startDate: '-60y',--}}
    {{--                autoclose: true--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
@stop
