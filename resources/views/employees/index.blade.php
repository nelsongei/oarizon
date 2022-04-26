@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
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
                        <div class="card-header">
                            <h4>Deactivated Employees</h4>
                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('employees/create')}}">New Employee</a>
                            </div>
                        </div>


                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="order-table" class="table table-striped table-bordered nowrap">

                                    <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>PFN</th>
                                        <th style="width:150px;" >Employee Name</th>
                                        <th>ID</th>
                                        <th>Kra Pin</th>
                                        <th>Nssf NO.</th>
                                        <th>Nhif NO.</th>
                                        <th>Gender</th>
                                        <th>Branch</th>
                                        <th>Department</th>
                                        <th></th>
                                    </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i = 1; ?>
                                    @foreach($employees as $employee)

                                        <tr>

                                            <td> {{ $i }}</td>
                                            <td>{{ $employee->personal_file_number }}</td>
                                            @if($employee->middle_name == null || $employee->middle_name == '')
                                                <td style="width: 150px;">{{ $employee->first_name.' '.$employee->last_name}}</td>
                                            @else
                                                <td style="width: 150px;">{{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name}}</td>
                                            @endif
                                            <td>{{ $employee->identity_number }}</td>
                                            <td>{{ $employee->pin }}</td>
                                            <td>{{ $employee->social_security_number }}</td>
                                            <td>{{ $employee->hospital_insurance_number }}</td>
                                            <td>{{ $employee->gender }}</td>
                                            @if( $employee->branch_id!=0)
                                                <td>{{ App\Models\Branch::getName($employee->branch_id) }}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if( $employee->department_id != 0)
                                                <td>{{ App\Models\Department::getName($employee->department_id).' ('.App\Models\Department::getCode($employee->department_id).')'}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">

                                                        <li><a href="{{url('employees/view/'.$employee->id)}}">View</a></li>

                                                        <li><a href="{{url('employees/edit/'.$employee->id)}}">Update</a></li>

                                                        <li><a href="{{url('employees/deactivate/'.$employee->id)}}" onclick="return (confirm('Are you sure you want to deactivate this employee?'))">Deactivate</a></li>

                                                    </ul>
                                                </div>

                                            </td>
                                        </tr>

                                        <?php $i++; ?>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>PFN</th>
                                        <th style="width:150px;">Employee Name</th>
                                        <th>ID</th>
                                        <th>Kra Pin</th>
                                        <th>Nssf NO.</th>
                                        <th>Nhif NO.</th>
                                        <th>Gender</th>
                                        <th>Branch</th>
                                        <th>Department</th>
                                        <th></th>
                                    </tr>


                                    </tfoot>


                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
