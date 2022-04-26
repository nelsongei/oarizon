@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
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
                                </div>


                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table class="table table-condensed table-bordered table-hover">

                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PFN</th>
                                                <th style="width: 150px" >Employee Name</th>
                                                <th>ID</th>
                                                <th>KRA PIN</th>
                                                <th>NSSF NO.</th>
                                                <th>NHIF NO.</th>
                                                <th>Gender</th>
                                                <th>Branch</th>
                                                <th>Department</th>

                                                <th>Action</th>
                                            </tr>


                                            </thead>

                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>PFN</th>
                                                <th style="width: 150px" >Employee Name</th>
                                                <th>ID</th>
                                                <th>Kra Pin</th>
                                                <th>Nssf NO.</th>
                                                <th>Nhif NO.</th>
                                                <th>Gender</th>
                                                <th>Branch</th>
                                                <th>Department</th>
                                            </tr>


                                            </tfoot>
                                            <tbody>

                                            <?php $i = 1; ?>
                                            @foreach($employees as $employee)

                                                <tr>

                                                    <td> {{ $i }}</td>
                                                    <td>{{ $employee->personal_file_number }}</td>
                                                    <td style="width: 150px" >{{ $employee->first_name.' '.$employee->last_name}}</td>
                                                    <td>{{ $employee->identity_number }}</td>
                                                    <td>{{ $employee->pin }}</td>
                                                    <td>{{ $employee->social_security_number }}</td>
                                                    <td>{{ $employee->hospital_insurance_number }}</td>
                                                    <td>{{ $employee->gender }}</td>
                                                    <?php if( $employee->branch_id!=0){ ?>
                                                    <td>{{ App\models\Branch::getName($employee->branch_id) }}</td>
                                                    <?php }else{?>
                                                    <td></td>
                                                    <?php } ?>
                                                    <?php if( $employee->department_id!= 0){ ?>
                                                    <td>{{ App\models\Department::getName($employee->department_id) }}</td>
                                                    <?php }else{?>
                                                    <td></td>
                                                    <?php } ?>
                                                    <td>

                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                Action <span class="caret"></span>
                                                            </button>

                                                            <ul class="dropdown-menu" style="margin-left:0" role="menu">

                                                                <li><a href="{{url('employees/viewdeactive/'.$employee->id)}}">View</a></li>

                                                                <li><a href="{{url('employees/activate/'.$employee->id)}}" onclick="return (confirm('Are you sure you want to activate this employee?'))">Activate</a></li>

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
    </div>
@endsection
