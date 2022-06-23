@extends('layouts.main')
<style type="text/css"></style>
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            Work Shifts
                            <hr>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
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
                                    <div class="mb-2">
                                        <a class="btn btn-info btn-sm"
                                           href="{{ URL::to('timesheet/work_shift/create')}}">Add Shift</a>
                                    </div>
                                    <table id="users"
                                           class="table table-condensed table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Organization</th>
                                            <th width="150">Shift</th>
                                            <th>Monday</th>
                                            <th>Tuesday</th>
                                            <th>Wednesday</th>
                                            <th>Thursday</th>
                                            <th>Friday</th>
                                            <th>Saturday</th>
                                            <th>Sunday</th>

                                            <th>Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <?php $i = 1; ?>
                                        @foreach($shifts as $shift)

                                            <tr>

                                                <td> {{ $i }}</td>
                                                <td> Oarizon</td>
                                                <td>{{ $shift->shift_name }}</td>
                                                <td>{{ $shift->monday_in }}<br>{{$shift->monday_out}}</td>
                                                <td>{{ $shift->tuesday_in }}<br>{{$shift->tuesday_out}}</td>
                                                <td>{{ $shift->wednesday_in }}<br>{{$shift->wednesday_out}}</td>
                                                <td>{{ $shift->thursday_in }}<br>{{$shift->thursday_out}}</td>
                                                <td>{{ $shift->friday_in }}<br>{{$shift->friday_out}}</td>
                                                <td>{{ $shift->saturday_in }}<br>{{$shift->saturday_out}}</td>
                                                <td>{{ $shift->sunday_in }}<br>{{$shift->sunday_out}}</td>

                                                <td>

                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            {{--                                            <li><a href="{{URL::to('timesheet/work_shift/edit/'.$shift->id)}}">Update</a></li>--}}
                                                            <li>
                                                                <a href="{{URL::to('timesheet/work_shift/deactivate/'.$shift->id)}}"
                                                                   onclick="return (confirm('Are you sure you want to deactivate this employee?'))">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
