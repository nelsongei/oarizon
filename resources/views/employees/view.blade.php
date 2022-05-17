@extends('layouts.main_hr')
@section('xara_cbs')

    <?php


    function asMoney($value)
    {
        return number_format($value, 2);
    }
    ?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
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
                            <a class="btn btn-info btn-sm " href="{{ url('employees/edit/'.$employee->id)}}">update
                                details</a>
                            <a class="btn btn-danger btn-sm " href="{{url('employees/deactivate/'.$employee->id)}}"
                               onclick="return (confirm('Are you sure you want to deactivate this employee?'))">Deactivate</a>
                            <hr>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-border-primary">
                                <div class="card-body box-info">
                                    <div class="text-center">
                                        @if($employee->photo =='https://via.placeholder.com/150C/O')
                                            <img class="img-radius" src="https://via.placeholder.com/150C/O"
                                                 width="150px" height="130px"
                                                 alt="">
                                        @else

                                            <img src="{{asset('/public/uploads/employees/photo/'.$employee->photo) }}"
                                                 width="150px" height="130px"
                                                 alt="">
                                        @endif
                                        <h3 class="text-info">{{$employee->first_name.' '.$employee->last_name}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-border-success">
                                <div class="card-body">
                                    <strong class="text-c-blue"><i class="fas fa-envelope mr-1"></i> Email</strong>
                                    <p class="text-muted ">
                                        {{$employee->email_office.' /'.$employee->email_personal}}
                                    </p>
                                    <hr/>
                                    <strong class="text-c-lite-green"><i class="fas fa-phone mr-1"></i> Phone
                                        Number</strong>
                                    <p class="text-muted ">
                                        @if($employee->telephone_office == NULL||$employee->telephone_personal== NULL||$employee->extension_office== NULL)
                                            N/A
                                        @else
                                            {{$employee->telephone_office.' /'.$employee->telephone_personal.' /'.$employee->extension_office}}
                                        @endif
                                    </p>
                                    <hr/>
                                    <strong class="text-c-red"><i class="fas fa-male mr-1"></i> Gender</strong>
                                    <p class="text-muted ">
                                        {{$employee->gender}}
                                    </p>
                                    <hr/>
                                    <strong class="text-c-orenge"><i class="fas fa-sort-numeric-down mr-1"></i> Payroll Number</strong>
                                    <p class="text-muted ">
                                        {{$employee->personal_file_number}}
                                    </p>
                                    <hr/>
                                    <strong class="text-c-purple"><i class="fas fa-algolia mr-1"></i> Identity Number</strong>
                                    <p class="text-muted ">
                                        {{$employee->identity_number}}
                                    </p>
                                    <hr/>
                                    <strong class="text-c-yellow"><i class="fas fa-print mr-1"></i> Marital Status</strong>
                                    <p class="text-muted ">
                                        @if($employee->marital_status != NULL)
                                        {{$employee->marital_status}}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <hr/>
                                    <strong class="text-c-green"><i class="fas fa-child mr-1"></i> Date Of Birth</strong>
                                    <p class="text-muted ">
                                        @if($employee->yob !=NULL)
                                            {{$employee->yob}}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <hr/>
                                    <strong class="text-googleplus"><i class="fas fa-certificate mr-1"></i> Citizenship</strong>
                                    <p class="text-muted ">
                                        @if($employee->citizenship !=NULL)
                                            {{$employee->citizenship}}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <hr/>
                                    <strong class="text-dropbox"><i class="fas fa-book mr-1"></i> Education</strong>
                                    <p class="text-muted ">
                                        @if($employee->citizenship !=NULL)
                                            {{$employee->citizenship}}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-border-inverse">
                                <div class="card-header">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity"
                                                                data-toggle="tab">Employee Information</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Next
                                                Of Kin</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Documents</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" href="#appraisals" data-toggle="tab">Appraisals</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" href="#property" data-toggle="tab">Company
                                                Property</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#occurrence" data-toggle="tab">Occurrence</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" href="#benefit" data-toggle="tab">Benefits</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div id="activity" class="active tab-pane">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">

                                                        <div class="col-lg-4">

                                                            <table class="table table-bordered table-hover">
                                                                <tr>
                                                                    <td colspan="2"><strong><span
                                                                                style="color:green">Company Information</span></strong>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td><strong>Branch: </strong></td>
                                                                    @if($employee->branch_id != 0)
                                                                        <td> {{ $employee->branch->name}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Department: </strong></td>
                                                                    @if($employee->department_id != 0)
                                                                        <td> {{ $employee->department->name.' ('.$employee->department->codes.')'}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <td><strong>Job Group: </strong></td>
                                                                    @if($employee->job_group_id != 0)
                                                                        <td>
                                                                            <?php
                                                                            $jgroup = DB::table('x_job_group')->where('id', '=', $employee->job_group_id)->pluck('job_group_name');
                                                                            ?>

                                                                            {{ $jgroup}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Employee Type: </strong></td>

                                                                    @if($employee->type_id != 0)
                                                                        <td>
                                                                            <?php
                                                                            $etype = DB::table('x_employee_type')->where('id', '=', $employee->type_id)->pluck('employee_type_name');
                                                                            ?>

                                                                            {{ $etype}}</td>
                                                                    @else
                                                                        <td></td>
                                                                @endif

                                                                @if($employee->type_id == 2)
                                                                    <tr>
                                                                        <td><strong> Start Date </strong></td>
                                                                        <td> {{ $employee->start_date}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong> End Date </strong></td>
                                                                        <td> {{ $employee->end_date}}</td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td><strong> Start Date </strong></td>
                                                                        <td> {{ $employee->start_date}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong> End Date </strong></td>
                                                                        <td> {{ $employee->end_date}}</td>
                                                                    </tr>

                                                                @endif
                                                                <tr>
                                                                    <td><strong>Work Permit: </strong></td>
                                                                    @if($employee->work_permit_number != null)
                                                                        <td>{{$employee->work_permit_number}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Job Title: </strong></td>
                                                                    @if($employee->job_title != null)
                                                                        <td>{{$employee->job_title}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                {{--                                        @can('manager_payroll')--}}

                                                                <tr>
                                                                    <td><strong>Basic Salary: </strong></td>
                                                                    <td align="right">{{asMoney((double)$employee->basic_pay)}}</td>
                                                                </tr>
                                                                {{--                                        @elsecan--}}
                                                                @if($employee->job_group_id !=4)
                                                                    <tr>
                                                                        <td><strong>Basic Salary: </strong></td>
                                                                        <td align="right">{{asMoney((double)$employee->basic_pay)}}</td>
                                                                    </tr>
                                                                @endif
                                                                {{--                                        @endcan--}}

                                                                <tr>
                                                                    <td><strong>Date Joined:</strong></td>
                                                                    @if($employee->date_joined != null)
                                                                        <td>{{date('d-M-Y',strtotime($employee->date_joined))}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>

                                                            </table>


                                                        </div>

                                                        <div class="col-lg-4">
                                                            <table class="table table-bordered table-hover">
                                                                <tr>
                                                                    <td colspan="2"><strong><span
                                                                                style="color:green">Goverment Requirements</span></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Kra Pin: </strong></td>
                                                                    @if($employee->pin != null)
                                                                        <td>{{$employee->pin}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Nssf Number: </strong></td>
                                                                    @if($employee->social_security_number != null)
                                                                        <td>{{$employee->social_security_number}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Nhif Number: </strong></td>
                                                                    @if($employee->hospital_insurance_number != null)
                                                                        <td>{{$employee->hospital_insurance_number}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <table class="table table-bordered table-hover">
                                                                <tr>
                                                                    <td colspan="2"><strong><span
                                                                                style="color:green">Bank Information</span></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Mode of Payment:</strong></td>
                                                                    @if($employee->mode_of_payment == 'Others')
                                                                        <td>{{$employee->custom_field1}}</td>
                                                                    @else
                                                                        <td>{{$employee->mode_of_payment}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Employee Bank: </strong></td>
                                                                    @if($employee->bank_id != 0)
                                                                        <td>
                                                                            <?php
                                                                            $bank = DB::table('banks')->where('id', '=', $employee->bank_id)->pluck('bank_name');
                                                                            ?>

                                                                            {{ $bank}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <td><strong>Bank Branch: </strong></td>
                                                                    @if($employee->bank_id != 0)
                                                                        <td>
                                                                            <?php
                                                                            $bbranch = DB::table('bank_branches')->where('id', '=', $employee->bank_branch_id)->pluck('bank_branch_name');
                                                                            ?>

                                                                            {{ $bbranch}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Bank Account Number:</strong></td>
                                                                    @if($employee->bank_account_number != null)
                                                                        <td>{{$employee->bank_account_number}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Sort Code:</strong></td>
                                                                    @if($employee->bank_eft_code != null)
                                                                        <td>{{$employee->bank_eft_code}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Swift Code:</strong></td>
                                                                    @if($employee->swift_code != null)
                                                                        <td>{{$employee->swift_code}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>

                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <table class="table table-bordered table-hover">
                                                                <tr>
                                                                    <td colspan="2"><strong><span
                                                                                style="color:green">Contact Information</span></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Office Email:</strong></td>
                                                                    @if($employee->email_office != null)
                                                                        <td>{{$employee->email_office}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Personal Email:</strong></td>
                                                                    @if($employee->email_personal != null)
                                                                        <td>{{$employee->email_personal}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Mobile Phone:</strong></td>
                                                                    @if($employee->telephone_mobile != null)
                                                                        <td>{{$employee->telephone_mobile}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Postal Address:</strong></td>
                                                                    @if($employee->postal_address != null)
                                                                        <td>{{$employee->postal_address}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Postal Zip:</strong></td>
                                                                    @if($employee->postal_zip != null)
                                                                        <td>{{$employee->postal_zip}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <table class="table table-bordered table-hover">
                                                                <tr>
                                                                    <td colspan="2"><strong><span
                                                                                style="color:green">Other Information</span></strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Apply Tax:</strong></td>
                                                                    @if($employee->income_tax_applicable != null)
                                                                        <td>Yes</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Apply Tax Relief:</strong></td>
                                                                    @if($employee->income_tax_relief_applicable != null)
                                                                        <td>Yes</td>
                                                                    @else
                                                                        <td>No</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Apply Nssf:</strong></td>
                                                                    @if($employee->hospital_insurance_applicable != null)
                                                                        <td>Yes</td>
                                                                    @else
                                                                        <td>No</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Apply Nhif:</strong></td>
                                                                    @if($employee->social_security_applicable != null)
                                                                        <td>Yes</td>
                                                                    @else
                                                                        <td>No</td>
                                                                    @endif
                                                                </tr>

                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="timeline" class="tab-pane">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <div class="panel panel-default">

                                                        <div class="panel-body">


                                                            <table id="users"
                                                                   class="table table-condensed table-bordered table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Kin Name</th>
                                                                    <th>ID Number</th>
                                                                    <th>Relationship</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>

                                                                <tfoot>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Kin Name</th>
                                                                    <th>ID Number</th>
                                                                    <th>Relationship</th>
                                                                </tr>
                                                                </tfoot>

                                                                <tbody>

                                                                <?php $i = 1; ?>
                                                                @foreach($kins as $kin)

                                                                    <tr>

                                                                        <td> {{ $i }}</td>
                                                                        @if($kin->kin_name == '')
                                                                            <td>{{ $kin->kin_name}}</td>
                                                                        @else
                                                                            <td>N/A</td>
                                                                        @endif
                                                                        @if($kin->id_number!=' ' || $kin->id_number!=null)
                                                                            <td>{{ $kin->id_number }}</td>
                                                                        @else
                                                                            <td></td>
                                                                        @endif
                                                                        @if($kin->id_number!=' ' || $kin->id_number!=null)
                                                                            <td>{{ $kin->relation }}</td>
                                                                        @else
                                                                            <td></td>
                                                                        @endif
                                                                        <td>

                                                                            <div class="btn-group">
                                                                                <button type="button"
                                                                                        class="btn btn-info btn-sm dropdown-toggle"
                                                                                        data-toggle="dropdown"
                                                                                        aria-expanded="false">
                                                                                    Action <span
                                                                                        class="caret"></span>
                                                                                </button>

                                                                                <ul class="dropdown-menu"
                                                                                    role="menu">
                                                                                    <li>
                                                                                        <a href="{{URL::to('NextOfKins/view/'.$kin->id)}}">View</a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a href="{{URL::to('NextOfKins/delete/'.$kin->id)}}"
                                                                                           onclick="return (confirm('Are you sure you want to delete this employee`s kin?'))">Delete</a>
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
                                        <div id="settings" class="tab-pane">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <div class="panel panel-default">

                                                        <div class="panel-body">


                                                            <table id="doc"
                                                                   class="table table-condensed table-bordered table-hover">


                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Document Type</th>
                                                                    <th>From Date</th>
                                                                    <th>End Date</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>

                                                                <tfoot>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Document Type</th>
                                                                    <th>From Date</th>
                                                                    <th>End Date</th>
                                                                </tr>
                                                                </tfoot>
                                                                <tbody>

                                                                <?php $i = 1; ?>
                                                                @foreach($documents as $document)
                                                                    <?php
                                                                    $name = $document->document_name;
                                                                    $file_name = pathinfo($name, PATHINFO_FILENAME);
                                                                    ?>
                                                                    <tr>

                                                                        <td> {{ $i }}</td>
                                                                        <td>{{ $file_name }}</td>
                                                                        <td>{{ $document->from_date }}</td>
                                                                        <td>{{ $document->expiry_date }}</td>
                                                                        <td>

                                                                            <div class="btn-group">
                                                                                <button type="button"
                                                                                        class="btn btn-info btn-sm dropdown-toggle"
                                                                                        data-toggle="dropdown"
                                                                                        aria-expanded="false">
                                                                                    Action <span
                                                                                        class="caret"></span>
                                                                                </button>

                                                                                <ul class="dropdown-menu"
                                                                                    role="menu">
                                                                                <!-- <li><a target="blank" href="{{asset('/public/uploads/employees/documents/'.$document->document_path) }}">Download</a></li> -->
                                                                                    <li>
                                                                                        <a href='{{asset("public/uploads/employees/documents/".$document->document_path)}}'>Download</a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a href="{{URL::to('documents/delete/'.$document->id)}}"
                                                                                           onclick="return (confirm('Are you sure you want to delete this employee`s document?'))">Delete</a>
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
                                        <div id="appraisals" class="tab-pane">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <div class="panel panel-default">

                                                        <div class="panel-body">


                                                            <table id="appr"
                                                                   class="table table-condensed table-bordered  table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Appraisal Question</th>
                                                                    <th>Performance</th>
                                                                    <th>Score</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>

                                                                <tfoot>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Appraisal Question</th>
                                                                    <th>Performance</th>
                                                                    <th>Score</th>
                                                                </tr>
                                                                </tfoot>

                                                                <tbody>

                                                                <?php
                                                                $i = 1;
                                                                use App\Models\Appraisalquestion;
                                                                ?>
                                                                @foreach($appraisals as $appraisal)

                                                                    <tr>


                                                                        <td> {{ $i }}</td>
                                                                        <td>{{ Appraisalquestion::getQuestion($appraisal->appraisalquestion_id) }}</td>
                                                                        <td>{{ $appraisal->performance }}</td>
                                                                        <td>{{ $appraisal->rate.' / '. Appraisalquestion::getScore($appraisal->appraisalquestion_id) }}</td>
                                                                        <td>

                                                                            <div class="btn-group">
                                                                                <button type="button"
                                                                                        class="btn btn-info btn-sm dropdown-toggle"
                                                                                        data-toggle="dropdown"
                                                                                        aria-expanded="false">
                                                                                    Action <span
                                                                                        class="caret"></span>
                                                                                </button>

                                                                                <ul class="dropdown-menu"
                                                                                    role="menu">
                                                                                    <li>
                                                                                        <a href="{{URL::to('Appraisals/view/'.$appraisal->id)}}">View</a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a href="{{URL::to('Appraisals/delete/'.$appraisal->id)}}"
                                                                                           onclick="return (confirm('Are you sure you want to delete this employee`s appraisal?'))">Delete</a>
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
                                        <div id="property" class="tab-pane">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <div class="panel panel-default">

                                                        <div class="panel-body">


                                                            <table id="prop"
                                                                   class="table table-condensed table-bordered table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Name</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                                </thead>

                                                                <tfoot>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Name</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                                </tfoot>

                                                                <tbody>

                                                                <?php $i = 1; ?>
                                                                @foreach($properties as $property)

                                                                    <tr>

                                                                        <td> {{ $i }}</td>
                                                                        <td>{{ $property->name }}</td>
                                                                        <td align="right">{{ asMoney((double)$property->monetary) }}</td>
                                                                        <td>

                                                                            <div class="btn-group">
                                                                                <button type="button"
                                                                                        class="btn btn-info btn-sm dropdown-toggle"
                                                                                        data-toggle="dropdown"
                                                                                        aria-expanded="false">
                                                                                    Action <span
                                                                                        class="caret"></span>
                                                                                </button>

                                                                                <ul class="dropdown-menu"
                                                                                    role="menu">
                                                                                    <li>
                                                                                        <a href="{{URL::to('Properties/view/'.$property->id)}}">View</a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a href="{{URL::to('Properties/delete/'.$property->id)}}"
                                                                                           onclick="return (confirm('Are you sure you want to delete this property?'))">Delete</a>
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
                                        <div id="occurrence" class="tab-pane">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <div class="panel panel-default">

                                                        <div class="panel-body">


                                                            <table id="occ" width="1000"
                                                                   class="table table-condensed table-bordered table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Occurence</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>

                                                                <tfoot>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Occurence</th>
                                                                </tr>
                                                                </tfoot>

                                                                <tbody>

                                                                <?php $i = 1; ?>
                                                                @foreach($occurences as $occurence)

                                                                    <tr>

                                                                        <td> {{ $i }}</td>
                                                                        <td>{{ $occurence->occurence_brief }}</td>
                                                                        <td>

                                                                            <div class="btn-group">
                                                                                <button type="button"
                                                                                        class="btn btn-info btn-sm dropdown-toggle"
                                                                                        data-toggle="dropdown"
                                                                                        aria-expanded="false">
                                                                                    Action <span
                                                                                        class="caret"></span>
                                                                                </button>

                                                                                <ul class="dropdown-menu"
                                                                                    role="menu">
                                                                                    <li>
                                                                                        <a href="{{URL::to('occurences/view/'.$occurence->id)}}">View</a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a href="{{URL::to('occurences/download/'.$occurence->id)}}">Download</a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a href="{{URL::to('occurences/delete/'.$occurence->id)}}"
                                                                                           onclick="return (confirm('Are you sure you want to delete this employee`s occurence?'))">Delete</a>
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
                                        <div id="benefit" class="tab-pane">
                                            <div class="row">
                                                <div class="col-lg-12">


                                                    <div class="row">


                                                        <div class="col-lg-6">

                                                            <table class="table table-bordered table-hover">

                                                                <tr>
                                                                    <td><strong>Name: </strong></td>
                                                                    <td><strong>Amount</strong></td>
                                                                </tr>
                                                                @if($count>0)
                                                                    @foreach($benefits as $benefit)
                                                                        <tr>
                                                                            <td>{{Benefitsetting::getBenefit($benefit->benefit_id)}}</td>
                                                                            <td>{{asMoney($benefit->amount)}}</td>
                                                                        </tr>
                                                                    @endforeach

                                                                @else
                                                                    <tr>
                                                                        <td colspan="2" align="center">Not
                                                                            found
                                                                        </td>
                                                                    </tr>
                                                                @endif
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
                    </div>
                </div>
            </div>
        </div>
@endsection
