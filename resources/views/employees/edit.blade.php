@extends('layouts.main_hr')
@section('xara_cbs')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="card-header">
                                    <h3>Update Employee</h3>

                                </div>


                                <div class="card-block">


                                    <div id="dialog-form" title="Create new citizenship name">
                                        <p class="validateTips1">Please insert citizenship name.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="cname" id="cname" value="" class="form-control">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new education level">
                                        <p class="validateTips2">Please insert education level.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="ename" id="ename" value="" class="form-control">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new bank">
                                        <p class="validateTips3">Please insert bank name.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="bname" id="bname" value="" class="form-control">

                                                <label for="name">Code<span style="color:red"></span></label>
                                                <input type="text" name="bcode" id="bcode" value="" class="form-control">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new bank branch">
                                        <p class="validateTips4">Please Insert Bank Branch.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="bname" id="bname" value="" class="form-control">

                                                <label for="name">Code<span style="color:red"></span></label>
                                                <input type="text" name="bcode" id="bcode" value="" class="form-control">

                                                <input type="hidden" name="bid" id="bid" value="" class="form-control">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new branch">
                                        <p class="validateTips5">Please insert branch.</p>

                                        <form>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label for="name">Name <span style="color:red">*</span></label>
                                                    <input type="text" name="bname" id="bname" value="" class="form-control">

                                                    <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                    <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">

                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new department">
                                        <p class="validateTips6">Please insert Department fields in *.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Code <span style="color:red">*</span></label>
                                                <input type="text" name="dcode" id="dcode" value="" class="form-control">

                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="dname" id="dname" value="" class="form-control">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new job group">
                                        <p class="validateTips7">Please insert job group.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="jname" id="jname" value="" class="form-control">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new employee type">
                                        <p class="validateTips8">Please insert employee type.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="tname" id="tname" value="" class="form-control">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div id="dialog-form" title="Create new job title" class="mb-5 mb-lg-2">
                                        <p class="validateTips9">Please insert job title.</p>

                                        <form>
                                            <fieldset>
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="jtitle" id="jtitle" value="" class="form-control">

                                                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{{ url('employees/update/'.$employee->id) }}}"  enctype="multipart/form-data" data-parsley-validate>@csrf

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Update Employee <button style="margin-left:620px" type="submit" class="btn btn-primary btn-sm">Update Employee</button></h3>

                                                <hr>
                                            </div>
                                        </div>

                                        @if(count($errors)>0)
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}<br>
                                                @endforeach
                                            </div>
                                    @endif

                                    <!-- Nav tabs -->
                                        <ul class="nav nav-tabs md-tabs" role="tablist">
                                            <li role="presentation" class="nav-item"><a class="nav-link active" href="#personalinfo" aria-controls="personalinfo" role="tab" data-toggle="tab">Personal Info</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#pininfo" aria-controls="pininfo" role="tab" data-toggle="tab">Government Info</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#payment" aria-controls="payment" role="tab" data-toggle="tab">Payment Info</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#companyinfo" aria-controls="companyinfo" role="tab" data-toggle="tab">Company Info</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#contactinfo" aria-controls="contactinfo" role="tab" data-toggle="tab">Contact Info</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#kins" aria-controls="kins" role="tab" data-toggle="tab">Next of Kin</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documents</a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content tabs card-block">

                                            <div role="tabpanel" class="tab-pane active" id="personalinfo">
                                                <input class="form-control" placeholder="" type="hidden" name="photo" id="photo" value="{{{ $employee->photo}}}" >
                                                <input class="form-control" placeholder="" type="hidden" name="sign" id="sign" value="{{{ $employee->signature}}}" >
                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">Personal File Number <span style="color:red">*</span></label>
                                                        <input class="form-control" placeholder=""  type="text" name="personal_file_number" id="personal_file_number" value="{{{ $employee->personal_file_number}}}" >
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Photo</label><br>
                                                        <div id="imagePreview"></div>
                                                        <input class="img" placeholder="" type="file" name="image" id="uploadFile" value="{{{ $employee->signature }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Signature</label><br>
                                                        <div id="signPreview"><img src="{{{ $employee->signature }}}" alt=""></div>
                                                        <input class="img" placeholder="" type="file" name="signature" id="signFile" value="{{{ $employee->signature }}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">Surname <span style="color:red">*</span></label>
                                                        <input class="form-control" placeholder="" data-parsley-trigger="change focusout" minlenght="2" type="text" name="lname" id="lname" value="{{{ $employee->last_name }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">First Name <span style="color:red">*</span></label>
                                                        <input class="form-control" placeholder="" data-parsley-trigger="change focusout" minlenght="2" type="text" name="fname" id="fname" value="{{{ $employee->first_name }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Other Names </label>
                                                        <input class="form-control" placeholder="" data-parsley-trigger="change focusout" minlenght="2" type="text" name="mname" id="mname" value="{{{ $employee->middle_name }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">ID Number <span style="color:red">*</span></label>
                                                        <input class="form-control" placeholder="" data-parsley-trigger="change focusout" data-parsley-type="number" minlenght="8"type="text" name="identity_number" id="identity_number" value="{{{ $employee->identity_number }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Passport number</label>
                                                        <input class="form-control" placeholder="" type="text" name="passport_number" id="passport_number" value="{{{ $employee->passport_number }}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">Date of birth <span style="color:red">*</span></label>
                                                        <div class="right-inner-addon ">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                            <input class="form-control datepicker1" readonly="readonly" placeholder="" type="text" name="dob" id="dob" value="{{{ $employee->yob }}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Marital Status</label>
                                                        <select name="status" class="form-control">
                                                            <option></option>
                                                            <option value="Single"<?= ($employee->marital_status=='Single')?'selected="selected"':''; ?>>Single</option>
                                                            <option value="Married"<?= ($employee->marital_status=='Married')?'selected="selected"':''; ?>>Married</option>
                                                            <option value="Divorced"<?= ($employee->marital_status=='Divorced')?'selected="selected"':''; ?>>Divorced</option>
                                                            <option value="Separated"<?= ($employee->marital_status=='Separated')?'selected="selected"':''; ?>>Separated</option>
                                                            <option value="Widowed"<?= ($employee->marital_status=='Widowed')?'selected="selected"':''; ?>>Widowed</option>
                                                            <option value="Others"<?= ($employee->marital_status=='Others')?'selected="selected"':''; ?>>Others</option>
                                                        </select>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Citizenship</label>
                                                        <select name="citizenship" id="citizenship" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($citizenships as $citizenship)
                                                                <option value="{{$citizenship->id }}"<?= ($employee->citizenship_id==$citizenship->id)?'selected="selected"':''; ?>> {{ $citizenship->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Education Background</label>
                                                        <select name="education" id="education" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($educations as $education)
                                                                <option value="{{ $education->id }}"<?= ($employee->education_type_id==$education->id)?'selected="selected"':''; ?>> {{ $education->education_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>



                                                    <div class="form-group">
                                                        <label for="username">Gender <span style="color:red">*</span></label><br>
                                                        <input class=""  type="radio" name="gender" id="gender" value="male"<?= ($employee->gender=='male')?'checked="checked"':''; ?>> Male
                                                        <input class=""  type="radio" name="gender" id="gender" value="female"<?= ($employee->gender=='female')?'checked="checked"':''; ?>> Female
                                                    </div>


                                                </div>

                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="pininfo">
                                                <br><br>
                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">KRA Pin</label>
                                                        <input class="form-control" placeholder="" type="text" name="pin" id="pin" value="{{{ $employee->pin }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Nssf Number</label>
                                                        <input class="form-control" placeholder="" type="text" name="social_security_number" id="social_security_number" value="{{{ $employee->social_security_number }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Nhif Number</label>
                                                        <input class="form-control" placeholder="" type="text" name="hospital_insurance_number" id="hospital_insurance_number" value="{{{ $employee->hospital_insurance_number }}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">

                                                    <div class="form-group"><h3 style='color:Green;margin-top:15px'>Deductions Applicable</h3></div>

                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->income_tax_applicable }}}" id="itax" name="i_tax"<?= ($employee->income_tax_applicable=='1')?'checked="checked"':''; ?>>
                                                            Apply Income Tax
                                                        </label>
                                                    </div>

                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->income_tax_relief_applicable }}}" id="irel" name="i_tax_relief"<?= ($employee->income_tax_relief_applicable=='1')?'checked="checked"':''; ?>>
                                                            Apply Income Tax Relief
                                                        </label>
                                                    </div>

                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->social_security_applicable }}}" name="a_nssf"<?= ($employee->social_security_applicable=='1')?'checked="checked"':''; ?>>
                                                            Apply Nssf
                                                        </label>
                                                    </div>

                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->hospital_insurance_applicable }}}" name="a_nhif"<?= ($employee->hospital_insurance_applicable=='1')?'checked="checked"':''; ?>>
                                                            Apply Nhif
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="payment">
                                                <br><br>
                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">Mode of Payment</label>
                                                        <select name="modep" id="modep" class="form-control">
                                                            <option></option>
                                                            <option value="Bank"<?= ($employee->mode_of_payment=='Bank')?'selected="selected"':''; ?>>Bank</option>
                                                            <option value="Mpesa"<?= ($employee->mode_of_payment=='Mpesa')?'selected="selected"':''; ?>>Mpesa</option>
                                                            <option value="Cash"<?= ($employee->mode_of_payment=='Cash')?'selected="selected"':''; ?>>Cash</option>
                                                            <option value="Cheque"<?= ($employee->mode_of_payment=='Cheque')?'selected="selected"':''; ?>>Cheque</option>
                                                            <option id="om" value="Others"<?= ($employee->mode_of_payment=='Others')?'selected="selected"':''; ?>>Others</option>
                                                        </select>

                                                        <div class="form-group" id="newmode">
                                                            <label for="username">Insert Mode of Payment</label>
                                                            <input class="form-control" placeholder="" type="text" name="omode" id="omode" value="{{$employee->custom_field1}}">
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Bank</label>
                                                        <select id="bank_id" name="bank_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($banks as $bank)
                                                                <option value="{{ $bank->id }}"<?= ($employee->bank_id==$bank->id)?'selected="selected"':''; ?>> {{ $bank->bank_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>


                                                    <div class="form-group">
                                                        <label for="username">Bank Branch</label>
                                                        <select id="bbranch_id" name="bbranch_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($bbranches as $bbranch)
                                                                <option value="{{$bbranch->id }}"<?= ($employee->bank_branch_id==$bbranch->id)?'selected="selected"':''; ?>> {{ $bbranch->bank_branch_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">Bank Account Number</label>
                                                        <input class="form-control" placeholder="" type="text" name="bank_account_number" id="bank_account_number" value="{{{ $employee->bank_account_number }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Sort Code</label>
                                                        <input class="form-control" placeholder="" type="text" name="bank_eft_code" id="bank_eft_code" value="{{{ $employee->bank_eft_code }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Swift Code</label>
                                                        <input class="form-control" placeholder="" type="text" name="swift_code" id="swift_code" value="{{{ $employee->swift_code }}}">
                                                    </div>


                                                </div>

                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="companyinfo">
                                                <br><br>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="username">Employee Branch</label>
                                                        <select name="branch_id" id="branch_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($branches as $branch)
                                                                <option value="{{ $branch->id }}"<?= ($employee->branch_id==$branch->id)?'selected="selected"':''; ?>> {{ $branch->name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>


                                                    <div class="form-group">
                                                        <label for="username">Employee Department</label>
                                                        <select name="department_id" id="department_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($departments as $department)
                                                                <option value="{{$department->id }}"<?= ($employee->department_id==$department->id)?'selected="selected"':''; ?>> {{ $department->department_name.' ('.$department->codes.')' }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Job Group <span style="color:red">*</span></label>
                                                        <select name="jgroup_id" id="jgroup_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($jgroups as $jgroup)
                                                                <option value="{{ $jgroup->id }}"<?= ($employee->job_group_id==$jgroup->id)?'selected="selected"':''; ?>> {{ $jgroup->job_group_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>


                                                    <div class="form-group">
                                                        <label for="username">Employee Type <span style="color:red">*</span></label>
                                                        <select name="type_id" id="type_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($etypes as $etype)
                                                                <option id="types" value="{{$etype->id }}"<?= ($employee->type_id==$etype->id)?'selected="selected"':''; ?>> {{ $etype->employee_type_name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>


                                                    <div id="contract">

                                                        <div class="form-group">
                                                            <label for="username">Start Date <span style="color:red">*</span></label>
                                                            <div class="right-inner-addon ">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                <input class="form-control datepicker21" readonly="readonly" placeholder="" type="text" name="startdate" id="startdate" value="{{ $employee->start_date }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">End Date <span style="color:red">*</span></label>
                                                            <div class="right-inner-addon ">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                <input class="form-control datepicker21" readonly="readonly" placeholder="" type="text" name="enddate" id="enddate" value="{{ $employee->end_date }}">
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="col-lg-4">

                                                    <div class="form-group">
                                                        <label for="username">Work Permit Number</label>
                                                        <input class="form-control" placeholder="" type="text" name="work_permit_number" id="work_permit_number" value="{{{ $employee->work_permit_number }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Job Title</label>
                                                        <input class="form-control" placeholder="" type="text" name="jtitle" id="jtitle" value="{{{ $employee->job_title }}}">
                                                    </div>

                                                    {{-- TODO: Check proper way of using policies--}}
{{--                                                    @can('manager_payroll')--}}
                                                        <div class="form-group">

                                                            <label for="username">Basic Salary <span style="color:red">*</span></label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">{{$currency->shortname}}</span>

                                                                <input class="form-control" placeholder="" type="number" name="pay" id="pay" @if($employee->basic_pay==='') value="{{$employee->basic_pay*100}}" @else value="{{$employee->basic_type*100}}" @endif>
                                                            </div>
{{--                                                            <script type="text/javascript">--}}
{{--                                                                $(document).ready(function() {--}}
{{--                                                                    $('#pay').priceFormat();--}}
{{--                                                                });--}}
{{--                                                            </script>--}}
                                                        </div>
{{--                                                    @elsecan--}}
                                                        @if($employee->job_group_id != 4)
{{--                                                            <div class="form-group">--}}

{{--                                                                <label for="username">Basic Salary <span style="color:red">*</span></label>--}}
{{--                                                                <div class="input-group">--}}
{{--                                                                    <span class="input-group-addon">{{$currency->shortname}}</span>--}}
{{--                                                                    <input class="form-control" placeholder="" type="text" name="pay" id="pay" value="{{ $employee->basic_pay * 100 }}">--}}
{{--                                                                </div>--}}
{{--                                                                <script type="text/javascript">--}}
{{--                                                                    $(document).ready(function() {--}}
{{--                                                                        $('#pay').priceFormat();--}}
{{--                                                                    });--}}
{{--                                                                </script>--}}
{{--                                                            </div>--}}
                                                        @endif
{{--                                                    @endcan--}}
                                                    <div class="form-group">
                                                        <label for="username">Date joined <span style="color:red">*</span></label>
                                                        <div class="right-inner-addon ">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                            <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="djoined" id="djoined" value="{{{ date('d-M-Y',strtotime($employee->date_joined)) }}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{{ $employee->in_employment }}}"<?= ($employee->in_employment=='Y')?'checked="checked"':''; ?> name="active">
                                                            In Employment
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="contactinfo">
                                                <br>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="username">Phone Number</label>
                                                        <input class="form-control" placeholder=""data-parsley-trigger="change focusout"data-parsley-type="number" minlenght="10" type="text" name="telephone_mobile" id="telephone_mobile" value="{{{ $employee->telephone_mobile }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Office Email<span style="color:red">*</span></label>
                                                        <input class="form-control" placeholder=""data-parsley-trigger="focusoutfocusin" type="email" name="email_office" id="email_office" value="{{{ $employee->email_office }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Personal Email</label>
                                                        <input class="form-control" placeholder=""data-parsley-trigger="focusout focusin" type="email" name="email_personal" id="email_personal" value="{{{ $employee->email_personal }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Postal Zip</label>
                                                        <input class="form-control" placeholder="" type="text" name="zip" id="zip" value="{{{ $employee->postal_zip }}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username">Postal Address</label>
                                                        <textarea class="form-control"  name="address" id="address">{{{ $employee->postal_address }}}</textarea>
                                                    </div>

                                                </div>

                                            </div>


                                            <div role="tabpanel" class="tab-pane" id="kins">

                                                <h4 style="align-content: center"><strong>Next of Kin</strong></h4>
                                                <div class="table-responsive dt-responsive" >
                                                    <table class="table table-striped table-bordered" id="nextkin">

                                                        <tr>
                                                            <th><input class='ncheck_all' type='checkbox' onclick="select_all()"/></th>
                                                            <th>#</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Other Names</th>
                                                            <th>ID Number</th>
                                                            <th>Relationship</th>
                                                            <th>Contact</th>
                                                        </tr>

                                                        @if($countk == 0)

                                                            <tr>
                                                                <td><input type='checkbox' class='ncase'/></td>
                                                                <td><span id='nsnum'>1.</span></td>
                                                                <td><input class="kindata" type='text' id='first_name' name='kin_first_name[0]' value="{{{ old('kin_first_name[0]') }}}"/></td>
                                                                <td><input class="kindata" type='text' id='last_name' name='kin_last_name[0]' value="{{{ old('kin_last_name[0]') }}}"/></td>
                                                                <td><input class="kindata" type='text' id='middle_name' name='kin_middle_name[0]' value="{{{ old('kin_middle_name[0]') }}}"/></td>
                                                                <td><input class="kindata" type='text' id='id_number' name='id_number[0]' value="{{{ old('id_number[0]') }}}"/> </td>
                                                                <td><input class="kindata" type='text' id='relationship' name='relationship[0]' value="{{{ old('relationship[0]') }}}"/></td>
                                                                <td><textarea class="kindata" name="contact[0]" id="contact">{{{ old('contact[0]') }}}</textarea></td>
                                                            </tr>

                                                        @else
                                                            <?php $i = 1; ?>
                                                            @foreach($kins as $kin)
                                                                <tr>
                                                                    <td><input type='checkbox' class='ncase'/></td>
                                                                    <td><span id='nsnum'>{{$i}}.</span></td>
                                                                    <td><input class="kindata" type='text' id='first_name' name='kin_first_name[{{$i-1}}]' value="{{$kin->first_name}}"/></td>
                                                                    <td><input class="kindata" type='text' id='last_name' name='kin_last_name[{{$i-1}}]' value="{{$kin->last_name}}"/></td>
                                                                    <td><input class="kindata" type='text' id='middle_name' name='kin_middle_name[{{$i-1}}]' value="{{$kin->middle_name}}"/></td>
                                                                    <td><input class="kindata" type='text' id='id_number' name='id_number[{{$i-1}}]' value="{{$kin->id_number}}"/> </td>
                                                                    <td><input class="kindata" type='text' id='relationship' name='relationship[{{$i-1}}]' value="{{$kin->relationship}}"/></td>
                                                                    <td><textarea class="kindata" name="contact[{{$i-1}}]" id="contact">{{$kin->contact}}</textarea></td>
                                                                </tr>
                                                                <?php $i++; ?>
                                                            @endforeach
                                                        @endif
                                                    </table>

                                                    <button type="button" class="btn btn-primary waves-effect waves-light add" onclick="add_nk_row();" >Add Row</button>
                                                    <button type="button" class="btn btn-danger waves-effect waves-light ndelete" >Delete Row</button>
                                                </div>
                                                <script>
                                                    $(".ndelete").on('click', function() {
                                                        if($('.ncase:checkbox:checked').length > 0){
                                                            if (window.confirm("Are you sure you want to delete this employee kin detail(s)?"))
                                                            {
                                                                $('.ncase:checkbox:checked').parents("#nextkin tr").remove();
                                                                $('.ncheck_all').prop("checked", false);
                                                                check();
                                                            }else{
                                                                $('.ncheck_all').prop("checked", false);
                                                                $('.ncase').prop("checked", false);
                                                            }
                                                        }
                                                    });
                                                    var i=2;
                                                    $(".naddmore").on('click',function(){
                                                        count=$('#nextkin tr').length;
                                                        var data="<tr><td><input type='checkbox' class='ncase'/></td><td><span id='nsnum"+i+"'>"+count+".</span></td>";
                                                        data +="<td><input class='kindata' type='text' id='first_name"+i+"' name='kin_first_name["+(i-1)+"]' value='{{{ old('kin_first_name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='last_name"+i+"' name='kin_last_name["+(i-1)+"]' value='{{{ old('kin_last_name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='middle_name"+i+"' name='kin_middle_name["+(i-1)+"]' value='{{{ old('kin_middle_name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='id_number"+i+"' name='id_number["+(i-1)+"]' value='{{{ old('id_number["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='relationship"+i+"' name='relationship["+(i-1)+"]' value='{{{ old('relationship["+(i-1)+"]') }}}'/></td><td><textarea class='kindata' name='contact["+(i-1)+"]' id='contact"+i+"'>{{{ old('contact["+(i-1)+"]') }}}</textarea></td>";
                                                        $('#nextkin').append(data);
                                                        i++;
                                                    });

                                                    function select_all() {
                                                        $('input[class=ncase]:checkbox').each(function(){
                                                            if($('input[class=ncheck_all]:checkbox:checked').length == 0){
                                                                $(this).prop("checked", false);
                                                            } else {
                                                                $(this).prop("checked", true);
                                                            }
                                                        });
                                                    }

                                                    function check(){
                                                        obj=$('#nextkin tr').find('span');
                                                        $.each( obj, function( key, value ) {
                                                            id=value.id;
                                                            $('#'+id).html(key+1);
                                                        });
                                                    }

                                                </script>

                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="documents">

                                                <h4 style="align-content: center"><strong>Employee Documents</strong></h4>
                                                <div class="table-responsive" >
                                                    <table class="table table-striped table-bordered" id="docEmp" >
                                                        <tr>
                                                            <th><input class='dcheck_all' type='checkbox' onclick="dselect_all()"/></th>
                                                            <th>#</th>
                                                            <th width="200">Document</th>
                                                            <th>Name</th>
                                                            <th>Description</th>
                                                            <th>Date From</th>
                                                            <th>End Date</th>
                                                        </tr>

                                                        @if($countd == 0)

                                                            <tr>
                                                                <td><input type='checkbox' class='dcase'/></td>
                                                                <td><span id='dsnum'>1.</span></td>
                                                                <td id="f"><input class="docdata" type="file" name="path[0]" id="path" value="{{{ old('path[0]') }}}"></td>
                                                                <td><input class="docdata" type='text' id='doc_name' name='doc_name[0]' value="{{{ old('doc_name[0]') }}}"/></td>
                                                                <td><textarea class="docdata" style="width:150px" name="description[0]" id="description">{{{ old('description[0]') }}}</textarea></td>
                                                                <td><div class="right-inner-addon">
                                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                                        <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="fdate[0]" id="fdate" value="{{{ old('fdate[0]') }}}">
                                                                    </div> </td>
                                                                <td><div class="right-inner-addon">
                                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                                        <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="edate[0]" id="edate" value="{{{ old('edate[0]') }}}">
                                                                    </div></td>
                                                            </tr>

                                                        @else

                                                            <?php $j = 1;?>
                                                            @foreach($docs as $doc)
                                                                <?php
                                                                $name = $doc->document_name;
                                                                $file_name = pathinfo($name, PATHINFO_FILENAME);
                                                                ?>
                                                                <input class="docdata" type="hidden" name="curpath[{{$j-1}}]" id="curpath" value="{{$doc->document_path}}">
                                                                <tr>
                                                                    <td><input type='checkbox' class='dcase'/></td>
                                                                    <td><span id='dsnum'>{{$j}}.</span></td>
                                                                    <td id="f"><input class="docdata" type="file" name="path[{{$j-1}}]" id="path" value="{{$doc->document_path}}"></td>
                                                                    <td><input class="docdata" type='text' id='doc_name' name='doc_name[{{$j-1}}]' value="{{$file_name}}"/></td>
                                                                    <td><textarea class="docdata" style="width:150px" name="description[{{$j-1}}]" id="description">{{$doc->description}}</textarea></td>
                                                                    <td><div class="right-inner-addon">
                                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                                            <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="fdate[{{$j-1}}]" id="fdate" value="{{$doc->from_date}}">
                                                                        </div> </td>
                                                                    <td><div class="right-inner-addon">
                                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                                            <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="edate[{{$j-1}}]" id="edate" value="{{$doc->expiry_date}}">
                                                                        </div></td>
                                                                </tr>
                                                                <?php $j++; ?>
                                                            @endforeach

                                                        @endif
                                                    </table>

                                                    <button type="button" class="btn btn-primary waves-effect waves-light add vaddmore" onclick="add_ve_row();" >Add Row</button>
                                                    <button type="button" class="btn btn-danger waves-effect waves-light vdelete" >Delete Row</button>


                                                </div>

                                                <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>


                                                <script type="text/javascript">
                                                    $(function(){

                                                        $('body').on('focus',"input.expiry",function(){
                                                            $(this).datepicker({
                                                                format: 'yyyy-mm-dd',
                                                                startDate: '-60y',
                                                                autoclose: true
                                                            });
                                                        });
                                                    });
                                                </script>

                                                <script>
                                                    $(".ddelete").on('click', function() {
                                                        if($('.dcase:checkbox:checked').length > 0){
                                                            if (window.confirm("Are you sure you want to delete this document detail(s)?"))
                                                            {
                                                                $('.dcase:checkbox:checked').parents("#docEmp tr").remove();
                                                                $('.dcheck_all').prop("checked", false);
                                                                dcheck();
                                                            }else{
                                                                $('.dcheck_all').prop("checked", false);
                                                                $('.dcase').prop("checked", false);
                                                            }
                                                        }
                                                    });
                                                    var j=2;
                                                    $(".daddmore").on('click',function(){
                                                        count=$('#docEmp tr').length;
                                                        var data="<tr><td><input type='checkbox' class='dcase'/></td><td><span id='dsnum"+j+"'>"+count+".</span></td>";
                                                        data +="<td id='f'><input class='docdata' type='file' id='path"+j+"' name='path["+(j-1)+"]' value='{{{ old('path["+(j-1)+"]') }}}'/></td><td><input class='docdata' type='text' id='doc_name"+j+"' name='doc_name["+(j-1)+"]' value='{{{ old('doc_name["+(j-1)+"]') }}}'/></td><td><textarea class='docdata' name='description["+(j-1)+"]' id='description"+j+"'>{{{ old('description["+(j-1)+"]') }}}</textarea></td><td><div class='right-inner-addon'><i class='glyphicon glyphicon-calendar'></i><input class='form-control expiry' readonly='readonly' placeholder='' type='text' name='fdate["+(j-1)+"]' id='fdate"+j+"' value='{{{ old('fdate["+(j-1)+"]') }}}'></div></td><td><div class='right-inner-addon'><i class='glyphicon glyphicon-calendar'></i><input class='form-control expiry' readonly='readonly' placeholder='' type='text' name='edate["+(j-1)+"]' id='edate"+j+"' value='{{{ old('edate["+(j-1)+"]') }}}'></div></td>";
                                                        $('#docEmp').append(data);
                                                        j++;
                                                    });

                                                    function dselect_all() {
                                                        $('input[class=dcase]:checkbox').each(function(){
                                                            if($('input[class=dcheck_all]:checkbox:checked').length == 0){
                                                                $(this).prop("checked", false);
                                                            } else {
                                                                $(this).prop("checked", true);
                                                            }
                                                        });
                                                    }

                                                    function dcheck(){
                                                        obj=$('#docEmp tr').find('span');
                                                        $.each( obj, function( key, value ) {
                                                            id=value.id;
                                                            $('#'+id).html(key+1);
                                                        });
                                                    }

                                                </script>

                                            </div>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

@stop
