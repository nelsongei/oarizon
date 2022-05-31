@extends('layouts.main_hr')
@section('xara_cbs')
    <?php
    $organization = App\models\Organization::find(Auth::user()->organization_id);
    $string = $organization->name;

    function initials($str, $pfn)
    {
        $ret = '';
        foreach (explode(' ', $str) as $word) {
            if ($word == null) {
                $ret .= strtoupper($str[0]);
            } else {
                $ret .= strtoupper($word[0]);
            }
        }
        return $ret . '.' . ($pfn + 1);
    }

    ?>
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Onboard New Employee</h3>
                            <hr/>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">
                                            {{ $error }}<br>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="card-body">
                                    <form method="POST" action="{{{ url('employees') }}}" enctype="multipart/form-data"
                                          data-parsley-validate>
                                        @csrf
                                        <div class="btn btn-default" id="progressBtn"
                                             style="position: absolute; width: 65px; height: 65px; left:47%; margin-top: -75px; border-radius: 50%; font-size: 15px; font-weight: bold; font-family:sans-serif; color: #fff; background: #1b01fa; border-color: transparent; padding-top:20px">
                                            <span id="cNo">
                                                0
                                            </span>
                                            %
                                        </div>
                                        <center class="mt-4 mb-2">
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    onclick="event.preventDefault(); tabControl(1)"> Personal Details
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="contactBtn" disabled=""
                                                    onclick="event.preventDefault(); tabControl(2)">
                                                Government Info
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="hrBtn"
                                                    onclick="event.preventDefault(); tabControl(3)"
                                                    disabled=""> Payment Info
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="company"
                                                    onclick="event.preventDefault(); tabControl(4)"
                                                    disabled=""> Company Info
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="contact"
                                                    onclick="event.preventDefault(); tabControl(5)"
                                                    disabled=""> Contact Info
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="next"
                                                    onclick="event.preventDefault(); tabControl(6)"
                                                    disabled=""> Next of Kin
                                            </button>&nbsp;
                                            <button class="btn btn-info btn-md rounded-pill"
                                                    id="docs"
                                                    onclick="event.preventDefault(); tabControl(7)"
                                                    disabled=""> Documents
                                            </button>&nbsp;
                                        </center>
                                        <div class="card">
                                            <div id="dialog-form" title="Create new citizenship name">
                                                <p class="validateTips1">Please insert citizenship name.</p>

                                                <form>
                                                    <fieldset>
                                                        <label for="name">Name <span style="color:red">*</span></label>
                                                        <input type="text" name="cname" id="cname" value=""
                                                               class="form-control">

                                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                        <input type="submit" tabindex="-1"
                                                               style="position:absolute; top:-1000px">
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div id="dialog-form" title="Create new education level">
                                                <p class="validateTips2">Please insert education level.</p>

                                                <form>
                                                    @csrf
                                                    <fieldset>
                                                        <label for="name">Name <span style="color:red">*</span></label>
                                                        <input type="text" name="ename" id="ename" value=""
                                                               class="form-control">

                                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                        <input type="submit" tabindex="-1"
                                                               style="position:absolute; top:-1000px">
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div id="dialog-form" title="Create new bank">
                                                <p class="validateTips3">Please insert bank name.</p>

                                                <form>
                                                    <fieldset>
                                                        <label for="name">Name <span style="color:red">*</span></label>
                                                        <input type="text" name="bname" id="bname" value=""
                                                               class="form-control">

                                                        <label for="name">Code<span style="color:red"></span></label>
                                                        <input type="text" name="bcode" id="bcode" value=""
                                                               class="form-control">

                                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                        <input type="submit" tabindex="-1"
                                                               style="position:absolute; top:-1000px">
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div id="dialog-form" title="Create new bank branch">
                                                <p class="validateTips4">Please Insert Bank Branch.</p>

                                                <form>
                                                    <fieldset>
                                                        <label for="name">Name <span style="color:red">*</span></label>
                                                        <input type="text" name="bname" id="brname" value=""
                                                               class="form-control">

                                                        <label for="name">Code<span style="color:red"></span></label>
                                                        <input type="text" name="bcode" id="brcode" value=""
                                                               class="form-control">

                                                        <input type="hidden" name="bid" id="bid" value=""
                                                               class="form-control">

                                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                        <input type="submit" tabindex="-1"
                                                               style="position:absolute; top:-1000px">
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div id="dialog-form" title="Create new branch">
                                                <p class="validateTips5">Please insert branch.</p>

                                                <form>
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <label for="name">Name <span
                                                                    style="color:red">*</span></label>
                                                            <input type="text" name="ebname" id="ebname" value=""
                                                                   class="form-control">

                                                            <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                            <input type="submit" tabindex="-1"
                                                                   style="position:absolute; top:-1000px">

                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div id="dialog-form" title="Create new department">
                                                <p class="validateTips6">Please insert Department fields in *.</p>

                                                <form>
                                                    <fieldset>
                                                        <label for="name">Code <span style="color:red">*</span></label>
                                                        <input type="text" name="dcode" id="dcode" value=""
                                                               class="form-control">

                                                        <label for="name">Name <span style="color:red">*</span></label>
                                                        <input type="text" name="dname" id="dname" value=""
                                                               class="form-control">

                                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                        <input type="submit" tabindex="-1"
                                                               style="position:absolute; top:-1000px">
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div id="dialog-form" title="Create new job group">
                                                <p class="validateTips7">Please insert job group.</p>

                                                <form>
                                                    <fieldset>
                                                        <label for="name">Name <span style="color:red">*</span></label>
                                                        <input type="text" name="jname" id="jname" value=""
                                                               class="form-control">

                                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                        <input type="submit" tabindex="-1"
                                                               style="position:absolute; top:-1000px">
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div id="dialog-form" title="Create new employee type">
                                                <p class="validateTips8">Please insert employee type.</p>

                                                <form>
                                                    <fieldset>
                                                        <label for="name">Name <span style="color:red">*</span></label>
                                                        <input type="text" name="tname" id="tname" value=""
                                                               class="form-control">

                                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                        <input type="submit" tabindex="-1"
                                                               style="position:absolute; top:-1000px">
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div id="dialog-form" title="Create new job title" class="mb-5 mb-lg-2">
                                                <p class="validateTips9">Please insert job title.</p>

                                                <form>
                                                    <fieldset>
                                                        <label for="name">Name <span style="color:red">*</span></label>
                                                        <input type="text" name="jtitle" id="jtitle" value=""
                                                               class="form-control">

                                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                                        <input type="submit" tabindex="-1"
                                                               style="position:absolute; top:-1000px">
                                                    </fieldset>
                                                </form>
                                            </div>
                                            <div class="card-body" style="border: 1px solid blue">
                                                <div id="page1" class="row">
                                                    <div class="col-sm-12">
                                                        <small class="text-danger" id="emptyErr"
                                                               style="font-size: 12px; font-weight: bold; display:none;">Fields
                                                            Marked * Are Required.</small>
                                                    </div>
                                                    <div class="form-group-lg col-sm-4">
                                                        <label for="personal_file_number">Personal File Number <span
                                                                style="color:red">*</span></label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="personal_file_number" id="personal_file_number"
                                                               value="{{initials($organization->name,$pfn)}}">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="lname">Surname <span
                                                                style="color:red">*</span></label>
                                                        <input class="form-control" placeholder=""
                                                               data-parsley-trigger="change focusout" minlength="2"
                                                               type="text" name="lname" id="lname"
                                                               value="{{{ old('lname') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="fname">First Name <span
                                                                style="color:red">*</span></label>
                                                        <input class="form-control" placeholder=""
                                                               data-parsley-trigger="change focusout" minlength="2"
                                                               type="text" name="fname" id="fname"
                                                               value="{{{ old('fname') }}}">
                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label for="mname">Other Names </label>
                                                        <input class="form-control" placeholder=""
                                                               data-parsley-trigger="change focusout" minlength="2"
                                                               type="text" name="mname" id="mname"
                                                               value="{{{ old('mname') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="TypeId">Select Type Of Id</label>
                                                        <select id="TypeId" class="form-control">
                                                            <option>National ID</option>
                                                            <option>Passport</option>
                                                            <option>Military ID</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-4" id="idNum">
                                                        <label for="identity_number">ID Number</label>
                                                        <input class="form-control" placeholder=""
                                                               data-parsley-trigger="change focusout"
                                                               data-parsley-type="number" data-parsley-minlength="8"
                                                               type="number" name="identity_number" id="identity_number"
                                                               value="{{{ old('identity_number') }}}">
                                                    </div>

                                                    <div class="form-group col-sm-4" id="passNum">
                                                        <label for="passport_number">Passport number</label>
                                                        <input class="form-control" placeholder="" type="number"
                                                               name="passport_number" id="passport_number"
                                                               value="{{{ old('passport_number') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-4" id="millitaryNum">
                                                        <label for="military_id">Military ID</label>
                                                        <input class="form-control" placeholder="" type="number"
                                                               name="military_id" id="military_id"
                                                               value="{{{ old('military_id') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="dob">Date of birth <span
                                                                style="color:red">*</span></label>
                                                        <div class="right-inner-addon ">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                            <input class="form-control date fill"
                                                                   placeholder="" type="date" name="dob"
                                                                   id="dob" data-mask="99/99/9999"
                                                                   value="{{{ old('dob') }}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="status">Marital Status</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option></option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Divorced">Divorced</option>
                                                            <option value="Separated">Separated</option>
                                                            <option value="Widowed">Widowed</option>
                                                            <option value="Others">Others</option>
                                                        </select>

                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label for="citizenship">Citizenship</label>
                                                        <select name="citizenship" id="citizenship"
                                                                class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($citizenships as $citizenship)
                                                                <option
                                                                    value="{{ $citizenship->id }}"> {{ $citizenship->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label for="education">Education Background</label>
                                                        <select name="education" id="education" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($educations as $education)
                                                                <option
                                                                    value="{{ $education->id }}"> {{ $education->education_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="gender">Gender <span
                                                                style="color:red">*</span></label>
                                                        <input class="gen" type="radio" name="gender" id="gender"
                                                               value="male"> Male
                                                        <input class="gen" type="radio" name="gender" id="gender"
                                                               value="female"> Female
                                                    </div>
                                                    <!--Browse files from here-->
                                                    <div class="form-group-lg col-sm-6">
                                                        <label for="username">Photo</label><br>
                                                        <div id="imagePreview"></div>
                                                        <input class="img" placeholder="" type="file" name="image"
                                                               id="uploadFile" value="{{{ old('image') }}}">
                                                    </div>
                                                    <div class="form-group-lg col-sm-6">
                                                        <label for="username">Signature</label><br>
                                                        <div id="signPreview"></div>
                                                        <input class="img" placeholder="" type="file" name="signature"
                                                               id="signFile" value="{{{ old('signature') }}}">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <button class="float-right btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(1)">&nbsp;Next&nbsp;
                                                        </button>
                                                    </div>
                                                </div>
                                                <div id="page2" class="row" style="display: none">
                                                    <div class="col-sm-12">
                                                        <small class="text-danger" id="emptyErr1"
                                                               style="font-size: 12px; font-weight: bold; display:none;">All
                                                            Fields Are Required.</small>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <h3 style='color:Green;'>Pin
                                                            Information</h3></div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="pin">KRA Pin</label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="pin" id="pin" value="{{{ old('pin') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="social_security_number">Nssf Number</label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="social_security_number" id="social_security_number"
                                                               value="{{{ old('social_security_number') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="hospital_insurance_number">Nhif Number</label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="hospital_insurance_number"
                                                               id="hospital_insurance_number"
                                                               value="{{{ old('hospital_insurance_number') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <h3 style='color:Green;'>Deductions
                                                            Applicable</h3></div>
                                                    <div class="checkbox col-sm-3">
                                                        <label>
                                                            <input type="checkbox" checked name="i_tax" id="itax">
                                                            Apply Income Tax
                                                        </label>
                                                    </div>
                                                    <div class="checkbox col-sm-3">
                                                        <label>
                                                            <input type="checkbox" checked name="i_tax_relief"
                                                                   id="irel">
                                                            Apply Income Tax Relief
                                                        </label>
                                                    </div>
                                                    <div class="checkbox col-sm-3">
                                                        <label>
                                                            <input type="checkbox" checked name="a_nssf" id="a_nssf">
                                                            Apply Nssf
                                                        </label>
                                                    </div>
                                                    <div class="checkbox col-sm-3">
                                                        <label>
                                                            <input type="checkbox" checked name="a_nhif" id="a_nhif">
                                                            Apply Nhif
                                                        </label>
                                                    </div>
                                                    <!--Next Button-->
                                                    <div class="form-group col-md-12">
                                                        <button class="btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(2)">&nbsp;Previous
                                                        </button>&nbsp;
                                                        <button class="float-right btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(3)">&nbsp;Next&nbsp;
                                                        </button>
                                                    </div>
                                                </div>
                                                <div id="page3" class="row" style="display: none">
                                                    <div class="col-sm-12">
                                                        <small class="text-danger" id="emptyErr21"
                                                               style="font-size: 12px; font-weight: bold; display:none;">All
                                                            Fields Are Required.</small>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="modep">Mode of Payment</label>
                                                        <select name="modep" id="modep" class="form-control">
                                                            <option></option>
                                                            <option value="Bank">Bank</option>
                                                            <option value="Mpesa">Mpesa</option>
                                                            <option value="Cash">Cash</option>
                                                            <option value="Cheque">Cheque</option>
                                                            <option value="Others">Others</option>
                                                        </select>

                                                    </div>
                                                    <div class="form-group" id="newmode">
                                                        <label for="omode">Insert Mode of Payment</label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="omode" id="omode" value="{{{ old('omode') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="bank_id">Banks</label>
                                                        <select name="bank_id" id="bank_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($banks as $bank)
                                                                <option
                                                                    value="{{ $bank->id }}"> {{ $bank->bank_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="bbranch_id">Bank Branch</label>
                                                        <select name="bbranch_id" id="bbranch_id" class="form-control">
                                                            <option></option>
                                                        </select>

                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="bank_account_number">Bank Account Number</label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="bank_account_number" id="bank_account_number"
                                                               value="{{{ old('bank_account_number') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="bank_eft_code">Sort Code</label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="bank_eft_code" id="bank_eft_code"
                                                               value="{{{ old('bank_eft_code') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="swift_code">Swift Code</label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="swift_code" id="swift_code"
                                                               value="{{{ old('swift_code') }}}">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <button class="btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(4)">&nbsp;Previous
                                                        </button>&nbsp;
                                                        <button class="float-right btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(5)">&nbsp;Next
                                                        </button>&nbsp;
                                                    </div>
                                                </div>
                                                <div id="page4" class="row" style="display: none">
                                                    <div class="form-group col-sm-3">
                                                        <label for="branch_id">Employee Branch </label>
                                                        <select name="branch_id" id="branch_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($branches as $branch)
                                                                <option
                                                                    value="{{ $branch->id }}"> {{ $branch->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="department_id">Employee Department </label>
                                                        <select name="department_id" id="department_id"
                                                                class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($departments as $department)
                                                                <option
                                                                    value="{{$department->id }}"> {{ $department->name.' ('.$department->codes.')' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="jgroup_id">Job Group <span
                                                                style="color:red">*</span></label>
                                                        <select name="jgroup_id" id="jgroup_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($jgroups as $jgroup)
                                                                <option
                                                                    value="{{ $jgroup->id }}"> {{ $jgroup->job_group_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="type_id">Employee Type <span
                                                                style="color:red">*</span></label>
                                                        <select name="type_id" id="type_id" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($etypes as $etype)
                                                                <option
                                                                    value="{{$etype->id }}"> {{ $etype->employee_type_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="startdate">Start Date <span
                                                                style="color:red">*</span></label>
                                                        <div class="right-inner-addon ">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                            <input class="form-control expiry" readonly="readonly"
                                                                   placeholder="" type="text" name="startdate"
                                                                   id="startdate" value="{{{ old('startdate') }}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="enddate">End Date <span
                                                                style="color:red">*</span></label>
                                                        <div class="right-inner-addon ">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                            <input class="form-control expiry" readonly="readonly"
                                                                   placeholder="" type="text" name="enddate"
                                                                   id="enddate" value="{{{ old('enddate') }}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="work_permit_number">Work Permit Number</label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="work_permit_number" id="work_permit_number"
                                                               value="{{{ old('work_permit_number') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="job_title">Job Title<span
                                                                style="color:red">*</span></label>
                                                        <select name="job_title" id="job_title" class="form-control">
                                                            <option></option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($jobtitles as $jobtitle)
                                                                <option
                                                                    value="{{ $jobtitle->id }}"> {{ $jobtitle->job_title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="pay">Basic Salary <span
                                                                style="color:red">*</span></label>
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-addon">{{$currency->shortname}}</span>
                                                            <input class="form-control" placeholder="" type="text"
                                                                   name="pay" id="pay" value="{{{ old('pay') }}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="djoined">Date joined <span
                                                                style="color:red">*</span></label>
                                                        <div class="right-inner-addon ">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                            <input class="form-control datepicker" readonly="readonly"
                                                                   placeholder="" type="text" name="djoined"
                                                                   id="djoined" value="{{{ old('djoined') }}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group-lg col-lg-4">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input id="ch" type="checkbox" checked name="active">
                                                                In Employment
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <button class="btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(6)">&nbsp;Previous
                                                        </button>&nbsp;
                                                        <button class="float-right btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(7)">&nbsp;Next
                                                        </button>&nbsp;
                                                    </div>
                                                </div>
                                                <div id="page5" class="row" style="display: none">
                                                    <div class="form-group col-sm-3">
                                                        <label for="telephone_mobile">Phone Number</label>
                                                        <input class="form-control" placeholder="" type="number"
                                                               name="telephone_mobile" id="telephone_mobile"
                                                               value="{{{ old('telephone_mobile') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="email_office">Office Email <span
                                                                style="color:red">*</span></label>
                                                        <input class="form-control" placeholder=""
                                                               data-parsley-trigger="focusout focusin" type="email"
                                                               name="email_office" id="email_office"
                                                               value="{{{ old('email_office') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="email_personal">Personal Email</label>
                                                        <input class="form-control" placeholder=""
                                                               data-parsley-trigger="focusout focusin" type="email"
                                                               name="email_personal" id="email_personal"
                                                               value="{{{ old('email_personal') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="zip">Postal Zip</label>
                                                        <input class="form-control" placeholder="" type="text"
                                                               name="zip" id="zip" value="{{{ old('zip') }}}">
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label for="address">Postal Address</label>
                                                        <textarea class="form-control" name="address"
                                                                  id="address">{{{ old('address') }}}</textarea>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <button class="btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(8)">&nbsp;Previous
                                                        </button>&nbsp;
                                                        <button class="float-right btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(9)">&nbsp;Next
                                                        </button>&nbsp;
                                                    </div>
                                                </div>
                                                <div id="page6" style="display: none">
                                                    <h4 style="align-content: center"><strong>Next of Kin</strong></h4>
                                                    <div class="table-responsive dt-responsive">
                                                        <table class="table table-striped table-bordered" id="nextkin">
                                                            <tr>
                                                                <th><input class='ncheck_all' type='checkbox'
                                                                           onclick="select_all()"/></th>
                                                                <th>#</th>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Other Names</th>
                                                                <th>ID Number</th>
                                                                <th>Relationship</th>
                                                                <th>Contact</th>
                                                            </tr>
                                                            <tr>
                                                                <td><input type='checkbox' class='ncase'/></td>
                                                                <td><span id='nsnum'>1.</span></td>
                                                                <td><input class="kindata" type='text' id='first_name'
                                                                           name='kin_first_name[0]'
                                                                           value="{{{ old('kin_first_name[0]') }}}"/>
                                                                </td>
                                                                <td><input class="kindata" type='text' id='last_name'
                                                                           name='kin_last_name[0]'
                                                                           value="{{{ old('kin_last_name[0]') }}}"/>
                                                                </td>
                                                                <td><input class="kindata" type='text' id='middle_name'
                                                                           name='kin_middle_name[0]'
                                                                           value="{{{ old('kin_middle_name[0]') }}}"/>
                                                                </td>
                                                                <td><input class="kindata" type='text' id='id_number'
                                                                           name='id_number[0]'
                                                                           value="{{{ old('id_number[0]') }}}"/></td>
                                                                <td><input class="kindata" type='text' id='relationship'
                                                                           name='relationship[0]'
                                                                           value="{{{ old('relationship[0]') }}}"/></td>
                                                                <td><textarea class="kindata" name="contact[0]"
                                                                              id="contact">{{{ old('contact[0]') }}}</textarea>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <button type="button"
                                                                class="btn btn-primary waves-effect waves-light add naddmore"
                                                        >Add Row
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-danger waves-effect waves-light ndelete">
                                                            Delete Row
                                                        </button>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <button class="btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(10)">&nbsp;Previous
                                                        </button>&nbsp;
                                                        <button class="float-right btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(11)">&nbsp;Next
                                                        </button>&nbsp;
                                                    </div>
                                                </div>
                                                <div id="page7" style="display: none">
                                                    <h4 style="align-content: center"><strong>Employee
                                                            Documents</strong>
                                                    </h4>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered" id="docEmp">
                                                            <tr>
                                                                <th><input class='dcheck_all' type='checkbox'
                                                                           onclick="dselect_all()"/></th>
                                                                <th>#</th>
                                                                <th style="width: 200px;">Document</th>
                                                                <th>Name</th>
                                                                <th>Type</th>
                                                            </tr>
                                                            <tr>
                                                                <td><input type='checkbox' class='dcase'/></td>
                                                                <td><span id='dsnum'>1.</span></td>
                                                                <td id="f"><input class="docdata" type="file"
                                                                                  name="path[0]"
                                                                                  id="path"
                                                                                  class="form-control"
                                                                                  value="{{{ old('path[0]') }}}">
                                                                </td>
                                                                <td><input class="docdata" type='text' id='doc_name'
                                                                           name='doc_name[0]'
                                                                           class="form-control"
                                                                           value="{{{ old('doc_name[0]') }}}"/></td>
                                                                <td>
                                                                    <select name="type" class="form-control">
                                                                        <option>CV</option>
                                                                        <option>Academic Certificate</option>
                                                                        <option>Good Conduct</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <button type="button"
                                                                class="btn btn-primary waves-effect waves-light add daddmore">
                                                            Add Row
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-danger waves-effect waves-light ddelete">
                                                            Delete Rows
                                                        </button>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <button class="btn btn-success rounded-pill"
                                                                onclick="event.preventDefault(); nexts(12)">&nbsp;Previous
                                                        </button>&nbsp;
                                                        <button class="float-right btn btn-success rounded-pill">&nbsp;Submit
                                                        </button>&nbsp;
                                                    </div>
                                                </div>
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
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#idNum').hide();
            $('#passNum').hide();
            $('#millitaryNum').hide();
            $('#TypeId').change(function () {
                if ($(this).val() === "Passport") {
                    $('#passNum').show();
                    $('#idNum').hide();
                    $('#millitaryNum').hide();
                } else if ($(this).val() === "National ID") {
                    $('#idNum').show();
                    $('#passNum').hide();
                    $('#millitaryNum').hide();
                } else if ($(this).val() === "Military ID") {
                    $('#millitaryNum').show();
                    $('#idNum').hide();
                    $('#passNum').hide();
                } else {
                    $('#idNum').hide();
                    $('#passNum').hide();
                    $('#millitaryNum').hide();
                }
            });
        })
    </script>
    <script>
        function nexts(id) {
            if (id === 1) {
                console.log(id);
                var personal_file_number = $("#personal_file_number").val();
                var firstName = $("#fname").val();
                var surname = $("#lname").val();
                var dob = $("#dob").val();
                var gender = $("#gender").val();
                if (firstName.length !== 0 && surname.length !== 0 && dob.length !== 0 && gender.length !== 0 && personal_file_number.length !== 0) {
                    // if (isNaN(idNumber)) {
                    $("#emptyErr2").fadeOut();
                    document.getElementById("contactBtn").disabled = true;
                    document.getElementById("hrBtn").disabled = true;
                    document.getElementById("company").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $("#page1").hide();
                    $("#page2").fadeIn();
                    $("#page3").hide();
                    $("#page4").hide();
                    $("#page5").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 14;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 2)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                        }
                    }
                } else {
                    $("#emptyErr").fadeIn();
                    document.getElementById("contactBtn").disabled = true;
                    document.getElementById("hrBtn").disabled = true;
                    document.getElementById("company").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                }
            }
            if (id === 2) {
                console.log(id);
                $("#page1").fadeIn();
                $("#page2").hide();
                $("#page3").hide();
                $("#page4").hide();
                $("#page5").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0;

                function Incrementer() {
                    x = x + 1;
                    if (x <= (100 / 7)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 3) {
                console.log(id)
                var pin = $("#pin").val();
                var social_security_number = $("#social_security_number").val();
                var hospital_insurance_number = $("#hospital_insurance_number").val();
                if (pin.length !== 0 && social_security_number.length !== 0 && hospital_insurance_number.length !== 0) {
                    $("#emptyErr1").fadeOut();
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $("#page2").hide();
                    $("#page1").hide();
                    $("#page3").fadeIn();
                    $("#page4").hide();
                    $("#page5").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 28;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 3)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                            document.getElementById('progressBtn').style.background = "#644ec5";
                            //document.getElementById("progressBtn").innerHTML = '<i class="text-white fa fa-check fa-2x"></i>';
                        }
                    }
                } else {
                    $("#emptyErr1").fadeIn();
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = false;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;

                }
            }
            if (id === 4) {
                console.log(id)
                $("#page1").hide();
                $("#page2").fadeIn();
                $("#page3").hide();
                $("#page4").hide();
                $("#page5").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 14;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 2)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 5) {
                console.log(id);
                var bankId = $("#bank_id").val();
                var bbranchId = $("#bbranch_id").val();
                var bank_account_number = $("#bank_account_number").val();
                var bank_eft_code = $("#bank_eft_code").val();
                var swift_code = $("#swift_code").val();
                var modep = $("#modep").val();
                if (bankId.length !== 0 && bbranchId.length !== 0 && bank_account_number.length !== 0 && bank_eft_code.length !== 0 && swift_code.length !== 0 && modep.length !== 0) {
                    $("#emptyErr21").fadeOut();
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = false;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $("#page4").fadeIn();
                    $("#page1").hide();
                    $("#page2").hide();
                    $("#page3").hide();
                    $("#page5").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 42;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 4)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                            document.getElementById('progressBtn').style.background = "#644ec5";
                        }
                    }

                    //document.getElementById("progressBtn").innerHTML = '<i class="text-white fa fa-check fa-2x"></i>';
                } else {
                    $("#emptyErr21").fadeIn();
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    // document.getElementById("finish").disabled = true;
                }
            }
            if (id === 6) {
                console.log(id)
                $("#page3").fadeIn();
                $("#page1").hide();
                $("#page2").hide();
                $("#page4").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 28;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 3)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 7) {
                console.log(id)
                var branch_id = $('#branch_id').val();
                var department_id = $('#department_id').val();
                var jgroup_id = $('#jgroup_id').val();
                var type_id = $('#type_id').val();
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();
                var work_permit_number = $('#work_permit_number').val();
                var job_title = $('#job_title').val();
                var pay = $('#pay').val();
                var djoined = $('#djoined').val();
                if (branch_id.length !== 0 && department_id !== 0 && jgroup_id !== 0 && type_id !== 0 && startdate !== 0 && enddate !== 0 && work_permit_number !== 0 && job_title !== 0 && job_title !== 0 && pay !== 0 && djoined !== 0) {
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = false;
                    document.getElementById("contact").disabled = false;
                    document.getElementById("contact").disabled = true;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $('#page5').fadeIn();
                    $("#page4").hide();
                    $("#page1").hide();
                    $("#page2").hide();
                    $("#page3").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 57;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 5)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                            document.getElementById("progressBtn").style.background = "#644ec5";
                        }
                    }
                }
            }
            if (id === 8) {
                console.log(id)
                $("#page4").fadeIn()
                $("#page1").hide()
                $("#page2").hide()
                $("#page3").hide()
                $("#page5").hide()
                $("#page6").hide()
                $("#page7").hide()
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 42;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 4)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 9) {
                console.log(id)
                var email_office = $("#email_office").val();
                if (email_office.length !== 0) {
                    document.getElementById("contactBtn").disabled = false;
                    document.getElementById("hrBtn").disabled = false;
                    document.getElementById("company").disabled = false;
                    document.getElementById("contact").disabled = false;
                    document.getElementById("contact").disabled = false;
                    document.getElementById("next").disabled = true;
                    document.getElementById("docs").disabled = true;
                    $('#page6').fadeIn();
                    $("#page4").hide();
                    $("#page1").hide();
                    $("#page2").hide();
                    $("#page3").hide();
                    $("#page5").hide();
                    document.getElementById('progressBtn').style.background = "#644ec5";
                    setInterval(Incrementer, 40);
                    var x = 0 + 71;

                    function Incrementer() {
                        x = x + 1;
                        if (x <= ((100 / 7) * 6)) {
                            document.getElementById('progressBtn').innerHTML = x + "%";
                            document.getElementById('progressBtn').style.background = "#644ec5"
                        }
                    }
                }
            }
            if (id === 10) {
                console.log(id)
                $("#page5").fadeIn();
                $('#page6').hide();
                $("#page4").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page3").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 57;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 5)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
            if (id === 11) {
                console.log(id)
                document.getElementById("contactBtn").disabled = false;
                document.getElementById("hrBtn").disabled = false;
                document.getElementById("company").disabled = false;
                document.getElementById("contact").disabled = false;
                document.getElementById("contact").disabled = false;
                document.getElementById("next").disabled = false;
                document.getElementById("docs").disabled = true;
                $("#page7").fadeIn();
                $('#page6').hide();
                $("#page4").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page3").hide();
                $("#page5").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 71;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 6)) {
                        //document.getElementById('progressBtn').innerHTML=x+"%";
                        document.getElementById('progressBtn').style.background = "#6dd144"
                        document.getElementById("progressBtn").innerHTML = '<i class="text-white fa fa-check fa-2x"></i>';
                    }
                }
            }
            if (id === 12) {
                console.log(id);
                $("#page6").fadeIn();
                $('#page7').hide();
                $("#page4").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page3").hide();
                $("#page5").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 71;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 6)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            }
        }

        //
        function tabControl(id) {
            if (id === 1) {
                $("#page1").fadeIn();
                $("#page2").hide();
                $("#page3").hide();
                $("#page4").hide();
                $("#page5").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0;

                function Incrementer() {
                    x = x + 1;
                    if (x <= (100 / 7)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            } else if (id === 2) {
                $("#page2").fadeIn();
                $("#page1").hide();
                $("#page3").hide();
                $("#page4").hide();
                $("#page5").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 14;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 2)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                    }
                }
            } else if (id === 3) {
                $("#page3").fadeIn();
                $("#page1").hide();
                $("#page2").hide();
                $("#page4").hide();
                $("#page5").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 28;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 3)) {

                        document.getElementById('progressBtn').innerHTML = x + "%";
                        document.getElementById('progressBtn').style.background = "#644ec5";
                    }
                }
            } else if (id === 4) {
                console.log(id);
                $("#page4").fadeIn();
                $("#page3").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page5").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 42;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 4)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                        document.getElementById('progressBtn').style.background = "#644ec5";
                    }
                }
            } else if (id === 5) {
                $("#page5").fadeIn();
                $("#page3").hide();
                $("#page1").hide();
                $("#page2").hide();
                $("#page4").hide();
                $("#page6").hide();
                $("#page7").hide();
                document.getElementById('progressBtn').style.background = "#644ec5";
                setInterval(Incrementer, 40);
                var x = 0 + 57;

                function Incrementer() {
                    x = x + 1;
                    if (x <= ((100 / 7) * 5)) {
                        document.getElementById('progressBtn').innerHTML = x + "%";
                        document.getElementById('progressBtn').style.background = "#644ec5";
                    }
                }
            }
        }

        //
        setInterval(Incrementer, 20);
        var x = 0;

        function Incrementer() {
            x = x + 1;
            if (x <= $("#ct").val()) {
                document.getElementById('ctNo').innerHTML = x;
            }
        }

        setInterval(Incrementer2, 20);
        var x = 0;

        function Incrementer2() {
            x = x + 1;
            if (x <= $("#ct2").val()) {
                document.getElementById('ctNo2').innerHTML = x;
            }
        }

        jQuery(document).ready(function () {
            jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#contract').hide()

            $('#newmode').hide()

            $("#modep").on("change", function () {
                if ($(this).val() == 'Others') {
                    $('#newmode').show();
                } else {
                    $('#newmode').hide();
                    $('#omode').val('');
                }
            });

            $("#type_id").on("change", function () {
                if ($(this).val() == 2) {
                    $('#contract').show();
                } else {
                    $('#contract').hide();
                    $('#startdate').val('');
                    $('#enddate').val('');
                }
            });

            $("#uploadFile").on("change", function () {
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div
                        $("#imagePreview").css("background-image", "url(" + this.result + ")");
                    }
                }
            });

            $('#bank_id').change(function () {
                $.get("{{ url('api/dropdown')}}",
                    {name: $(this).val()},
                    function (data) {
                        $('#bbranch_id').empty();
                        $('#bbranch_id').append("<option>----------------select Bank Branch--------------------</option>");
                        $('#bbranch_id').append("<option value='cnew'>Create New</option>");
                        for (var x = 0; x < data.branches.length; x++) {
                            $('#bbranch_id').append("<option value='" + data.branches[x]['id'] + "'>" + data.branches[x]['bank_branch_name'] + "</option>");
                        }
                    });
            });
        });
    </script>
    <script>
        $(".ddelete").on('click', function () {
            if ($('.dcase:checkbox:checked').length > 0) {
                if (window.confirm("Are you sure you want to delete this document detail(s)?")) {
                    $('.dcase:checkbox:checked').parents("#docEmp tr").remove();
                    $('.dcheck_all').prop("checked", false);
                    dcheck();
                } else {
                    $('.dcheck_all').prop("checked", false);
                    $('.dcase').prop("checked", false);
                }
            }
        });
        var j = 2;
        $(".daddmore").on('click', function () {
            count = $('#docEmp tr').length;
            var data = "<tr><td><input type='checkbox' class='dcase'/></td><td><span id='dsnum" + j + "'>" + count + ".</span></td>";
            data += "<td id='f'><input class='docdata' type='file' id='path" + j + "' name='path[" + (j - 1) + "]' value='{{{ old('path["+(j-1)+"]') }}}'/></td><td><input class='docdata' type='text' id='doc_name" + j + "' name='doc_name[" + (j - 1) + "]' value='{{{ old('doc_name["+(j-1)+"]') }}}'/></td><td><select name='type[" + (j - 1) + "]' id='type" + j + "' class='form-control'><option>CV</option><option>Academic Certificates</option><option>Good Conduct</option></select></td>";
            $('#docEmp').append(data);
            j++;
        });

        function dselect_all() {
            $('input[class=dcase]:checkbox').each(function () {
                if ($('input[class=dcheck_all]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        function dcheck() {
            obj = $('#docEmp tr').find('span');
            $.each(obj, function (key, value) {
                id = value.id;
                $('#' + id).html(key + 1);
            });
        }

    </script>
    <script>
        $(".ndelete").on('click', function () {
            if ($('.ncase:checkbox:checked').length > 0) {
                if (window.confirm("Are you sure you want to delete this employee kin detail(s)?")) {
                    $('.ncase:checkbox:checked').parents("#nextkin tr").remove();
                    $('.ncheck_all').prop("checked", false);
                    check();
                } else {
                    $('.ncheck_all').prop("checked", false);
                    $('.ncase').prop("checked", false);
                }
            }
        });
        var i = 2;
        $(".naddmore").on('click', function () {
            count = $('#nextkin tr').length;
            var data = "<tr><td><input type='checkbox' class='ncase'/></td><td><span id='nsnum" + i + "'>" + count + ".</span></td>";
            data += "<td><input class='kindata' type='text' id='first_name" + i + "' name='kin_first_name[" + (i - 1) + "]' value='{{{ old('kin_first_name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='last_name" + i + "' name='kin_last_name[" + (i - 1) + "]' value='{{{ old('kin_last_name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='middle_name" + i + "' name='kin_middle_name[" + (i - 1) + "]' value='{{{ old('kin_middle_name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='id_number" + i + "' name='id_number[" + (i - 1) + "]' value='{{{ old('id_number["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='relationship" + i + "' name='relationship[" + (i - 1) + "]' value='{{{ old('relationship["+(i-1)+"]') }}}'/></td><td><textarea class='kindata' name='contact[" + (i - 1) + "]' id='contact" + i + "'>{{{ old('contact["+(i-1)+"]') }}}</textarea></td>";
            $('#nextkin').append(data);
            i++;
        });

        function select_all() {
            $('input[class=ncase]:checkbox').each(function () {
                if ($('input[class=ncheck_all]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        function check() {
            obj = $('#nextkin tr').find('span');
            $.each(obj, function (key, value) {
                id = value.id;
                $('#' + id).html(key + 1);
            });
        }

    </script>
    <script type="text/javascript">
        $(function () {

            $('body').on('focus', "input.expiry", function () {
                $(this).datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '-60y',
                    autoclose: true
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#signFile").on("change", function () {
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div
                        $("#signPreview").css("background-image", "url(" + this.result + ")");
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#empdetails').click(function (e) {
                e.preventDefault();

                /*var kdata = $('.kindata').map(function(){
                  return this.value;
                }).get();*/

                var kind = $('.kindata').serialize();

                var docdata = new FormData($("#form3"));

                //var docdata= $('.docdata').serialize();

                /*var kfn = $('input[name^="kin_first_name"]').map(function(){
                  return this.value;
                }).get();

                var kln = $('input[name^="kin_last_name"]').map(function(){
                  return this.value;
                }).get();

                var kmn = $('input[name^="kin_middle_name"]').map(function(){
                  return this.value;
                }).get();

                var kid = $('input[name^="id_number"]').map(function(){
                  return this.value;
                }).get();

                var krel = $('input[name^="relationship"]').map(function(){
                  return this.value;
                }).get();

                var kcon = $('input[name^="contact"]').map(function(){
                  return this.value;
                }).get();*/

                /*var path = $('input[name^="path"]').map(function(){
                  return this.value;
                }).get();

                var name = $('input[name^="doc_name"]').map(function(){
                  return this.value;
                }).get();

                var desc = $('input[name^="description"]').map(function(){
                  return this.value;
                }).get();

                var fdate = $('input[name^="fdate"]').map(function(){
                  return this.value;
                }).get();

                var edate = $('input[name^="edate"]').map(function(){
                  return this.value;
                }).get();

                var __data = $('input[name^="kin_first_name"]').serialize();*/


                var fname = $("#fname"),
                    lname = $("#lname"),
                    identity_number = $("#identity_number"),
                    dob = $("#dob"),
                    gender = $(".gen"),
                    jgroup = $("#jgroup_id"),
                    type = $("#type_id"),
                    pay = $("#pay"),
                    djoined = $("#djoined"),
                    email_office = $("#email_office"),
                    email_personal = $("#email_personal"),
                    allFields = $([]).add(fname).add(lname).add(identity_number).add(dob).add(gender).add(jgroup).add(type).add(pay).add(djoined).add(email_office).add(email_personal),
                    tips = $(".validateTips");

                function updateTips(t) {
                    tips
                        .text(t)
                        .addClass("ui-state-highlight");
                    setTimeout(function () {
                        tips.removeClass("ui-state-highlight", 1500);
                    }, 500);
                }

                function checkLength(o, m) {
                    if (o.val().length == 0) {
                        o.addClass("ui-state-error");
                        updateTips(m);
                        return false;
                    } else {
                        return true;
                    }
                }

                function checkRegexp(o, regexp, n) {
                    if (!(regexp.test(o.val()))) {
                        o.addClass("ui-state-error");
                        updateTips(n);
                        return false;
                    } else {
                        return true;
                    }
                }

                var valid = true;
                allFields.removeClass("ui-state-error");

                /*valid = valid && checkLength( lname, "Please insert last name!" );

                valid = valid && checkLength( fname, "Please insert first name!" );

                valid = valid && checkLength( identity_number, "Please insert employee`s identity number!" );

                valid = valid && checkLength( dob, "Please insert employee`s date of birth!" );

                valid = valid && checkLength( gender, "Please select gender!" );

                valid = valid && checkLength( jgroup, "Please select employee`s job group!" );

                valid = valid && checkLength( type, "Please select employee`s type!" );

                valid = valid && checkLength( djoined, "Please insert date employee joined company!" );

                valid = valid && checkLength( email_office, "Please insert employee`s office email address!" );

                valid = valid && checkRegexp( lname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for last name!" );

                valid = valid && checkRegexp( fname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for first name!" );

                valid = valid && checkRegexp( email_office, /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/, "Please insert a valid office email address!" );

                valid = valid && checkRegexp( email_personal, /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/, "Please insert a valid personal email address!" );
          */


                //get form id
                $.ajax({
                    url: "{{url('createEmployee')}}",
                    type: "POST",
                    async: false,
                    data: {
                        'personal_file_number': $('#personal_file_number').val(),
                        'image': $('#uploadFile').val(),
                        'signature': $('#signFile').val(),
                        'fname': $('#fname').val(),
                        'lname': $('#lname').val(),
                        'mname': $('#mname').val(),
                        'identity_number': $('#identity_number').val(),
                        'passport_number': $('#passport_number').val(),
                        'dob': $('#dob').val(),
                        'status': $('#status').val(),
                        'citizenship': $('#citizenship').val(),
                        'education': $('#education').val(),
                        'gender': $('#gender').val(),
                        'pin': $('#pin').val(),
                        'social_security_number': $('#social_security_number').val(),
                        'hospital_insurance_number': $('#hospital_insurance_number').val(),
                        'i_tax': $('#itax').val(),
                        'i_tax_relief': $('#irel').val(),
                        'a_nssf': $('#a_nssf').val(),
                        'a_nhif': $('#a_nhif').val(),
                        'modep': $('#modep').val(),
                        'omode': $('#omode').val(),
                        'bank_id': $('#bank_id').val(),
                        'bbranch_id': $('#bbranch_id').val(),
                        'bank_account_number': $('#bank_account_number').val(),
                        'bank_eft_code': $('#bank_eft_code').val(),
                        'swift_code': $('#swift_code').val(),
                        'branch_id': $('#branch_id').val(),
                        'department_id': $('#department_id').val(),
                        'jgroup_id': $('#jgroup_id').val(),
                        'type_id': $('#type_id').val(),
                        'startdate': $('#startdate').val(),
                        'enddate': $('#enddate').val(),
                        'work_permit_number': $('#work_permit_number').val(),
                        'jtitle': $('#jtitle').val(),
                        'pay': $('#pay').val(),
                        'djoined': $('#djoined').val(),
                        'telephone_mobile': $('#telephone_mobile').val(),
                        'email_office': $('#email_office').val(),
                        'email_personal': $('#email_personal').val(),
                        'zip': $('#zip').val(),
                        'address': $('#address').val(),
                        'ch': $('#active').val(),
                        'kindata': kind,
                        'docinfo': docdata
                    },
                    success: function (s) {
                        alert(s);
                    }
                });

            });
            //this function will create loop for all forms in page

        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                cname = $("#cname"),

                allFields = $([]).add(cname),
                tips = $(".validateTips1");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o) {
                if (o.val().length == 0) {
                    o.addClass("ui-state-error");
                    updateTips("Please insert citizenship name!");
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(cname);

                valid = valid && checkRegexp(cname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for citizenship.");

                if (valid) {

                    /* displaydata();

                    function displaydata(){
                     $.ajax({
                                    url     : "{{url('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/
                    const citizenData = {
                        'name': document.getElementById('cname').value,
                        "_token": "{{csrf_token()}}",
                    }
                    $.ajax({
                        url: "{{url('createCitizenship')}}",
                        type: "POST",
                        async: false,
                        data: citizenData,
                        success: function (s) {
                            $('#citizenship').append($('<option>', {
                                value: s,
                                text: cname.val(),
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 250,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                // close: function () {
                //     form[0].reset();
                //     allFields.removeClass("ui-state-error");
                // }
            });
            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });
            $('#citizenship').change(function () {
                if ($(this).val() === "cnew") {
                    dialog.dialog("open");
                }
            });
        });
    </script>
    <script>
        $(function () {
            var dialog, form,
                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                ename = $("#ename"),
                allFields = $([]).add(ename),
                tips = $(".validateTips2");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o) {
                if (o.val().length == 0) {
                    o.addClass("ui-state-error");
                    updateTips("Please insert education level!");
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(ename);

                valid = valid && checkRegexp(ename, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for education level.");

                if (valid) {

                    //displaydata();

                    /*function displaydata() {
                        $.ajax({
                            url: "{{url('reloaddata')}}",
                            type: "POST",
                            async: false,
                            data: {},
                            success: function (s) {
                                var data = JSON.parse(s)
                                alert(data.id);
                            }
                        });
                    }*/

                    const Formdata = {
                        'name': document.getElementById('ename').value,
                        "_token": "{{csrf_token()}}",
                    }
                    $.ajax({
                        url: "{{url('createEducation')}}",
                        type: "POST",
                        async: false,
                        data: Formdata,
                        success: function (s) {
                            $('#education').append($('<option>', {
                                value: s,
                                text: ename.val(),
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 250,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#education').change(function () {
                if ($(this).val() === "cnew") {
                    dialog.dialog("open");
                }

            });
        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                bname = $("#bname"),
                bcode = $("#bcode"),
                allFields = $([]).add(bname).add(bcode),
                tips = $(".validateTips3");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o) {
                if (o.val().length === 0) {
                    o.addClass("ui-state-error");
                    updateTips("Please insert bank name!");
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(bname);

                valid = valid && checkRegexp(bname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for bank name.");

                if (valid) {

                    /* displaydata();

                    function displaydata(){
                     $.ajax({
                                    url     : "{{url('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/
                    const bankData = {
                        'name': document.getElementById('bname').value,
                        'code': document.getElementById('bcode').value,
                        "_token": "{{csrf_token()}}",
                    }
                    $.ajax({
                        url: "{{url('createBank')}}",
                        type: "POST",
                        async: false,
                        data: bankData,
                        success: function (s) {
                            $('#bank_id').append($('<option>', {
                                value: s,
                                text: bname.val(),
                                selected: true
                            }));

                            $("#bid").val($("#bank_id").val());

                            $('#bbranch_id').empty();
                            $('#bbranch_id').append("<option>----------------select Bank Branch--------------------</option>");
                            $('#bbranch_id').append("<option value='cnew'>Create New</option>");

                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 350,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#bank_id').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });
        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                bname = $("#brname"),
                bcode = $("#brcode"),
                bid = $("#bid"),
                allFields = $([]).add(bname).add(bcode).add(bid),
                tips = $(".validateTips4");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o, m) {
                if (o.val().length == 0) {
                    o.addClass("ui-state-error");
                    updateTips(m);
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(bname, "Please insert bank branch name!");

                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                valid = valid && checkRegexp(bname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for bank branch name.");

                if (valid) {

                    /* displaydata();

                    function displaydata(){
                     $.ajax({
                                    url     : "{{url('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/
                    const bankBranchName = {
                        'bid': document.getElementById('bid').value,
                        'name': document.getElementById('brname').value,
                        'code': document.getElementById('brcode').value,
                        "_token": "{{csrf_token()}}"

                    }
                    $.ajax({
                        url: "{{url('createBankBranch')}}",
                        type: "POST",
                        async: false,
                        data: bankBranchName,
                        success: function (s) {
                            $('#bbranch_id').append($('<option>', {
                                value: s,
                                text: bname.val(),
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 350,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#bbranch_id').change(function () {
                if ($(this).val() == "cnew") {
                    $("#bid").val($("#bank_id").val());
                    dialog.dialog("open");
                }

            });

        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                bname = $("#ebname"),
                allFields = $([]).add(bname),
                tips = $(".validateTips5");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o, m) {
                if (o.val().length == 0) {
                    o.addClass("ui-state-error");
                    updateTips(m);
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(bname, "Please insert branch name!");

                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                valid = valid && checkRegexp(bname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for branch name.");

                if (valid) {

                    /* displaydata();

                    function displaydata(){
                     $.ajax({
                                    url     : "{{url('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/
                    const EmployeeBranch = {
                        'name': document.getElementById('ebname').value,
                        "_token": "{{csrf_token()}}"

                    }
                    $.ajax({
                        url: "{{url('createBranch')}}",
                        type: "POST",
                        async: false,
                        data: EmployeeBranch,
                        success: function (s) {
                            $('#branch_id').append($('<option>', {
                                value: s,
                                text: bname.val(),
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 280,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#branch_id').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });

        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                dname = $("#dname"),
                dcode = $("#dcode"),
                allFields = $([]).add(dname).add(dcode),
                tips = $(".validateTips6");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o, m) {
                if (o.val().length == 0) {
                    o.addClass("ui-state-error");
                    updateTips(m);
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(dname, "Please insert department name!");

                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                valid = valid && checkRegexp(dname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for department name.");

                if (valid) {

                    {{--displaydata();--}}

                    {{--function displaydata(){--}}
                    {{--    $.ajax({--}}
                    {{--        url     : "{{url('reloaddata')}}",--}}
                    {{--        type    : "POST",--}}
                    {{--        async   : false,--}}
                    {{--        data    : { },--}}
                    {{--        success : function(s){--}}
                    {{--            var data = JSON.parse(s)--}}
                    {{--            //alert(data.id);--}}
                    {{--        }--}}
                    {{--    });--}}
                    {{--}--}}
                    const departmentData = {
                        'name': document.getElementById('dname').value,
                        'code': document.getElementById('dcode').value,
                        "_token": "{{csrf_token()}}"
                    }
                    $.ajax({
                        url: "{{url('createDepartment')}}",
                        type: "POST",
                        async: false,
                        data: departmentData,
                        success: function (s) {
                            $('#department_id').append($('<option>', {
                                value: s,
                                text: dname.val() + "(" + dcode.val() + ")",
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 320,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#department_id').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });

        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                jname = $("#jname"),
                allFields = $([]).add(jname),
                tips = $(".validateTips7");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o, m) {
                if (o.val().length == 0) {
                    o.addClass("ui-state-error");
                    updateTips(m);
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(jname, "Please insert job group!");

                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                valid = valid && checkRegexp(jname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for job group.");

                if (valid) {

                    /* displaydata();

                    function displaydata(){
                     $.ajax({
                                    url     : "{{url('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/
                    const jobGroup = {
                        "name": document.getElementById('jname').value,
                        "_token": "{{csrf_token()}}"
                    }
                    $.ajax({
                        url: "{{url('createGroup')}}",
                        type: "POST",
                        async: false,
                        data: jobGroup,
                        success: function (s) {
                            $('#jgroup_id').append($('<option>', {
                                value: s,
                                text: jname.val(),
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 280,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#jgroup_id').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });

        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                tname = $("#tname"),
                allFields = $([]).add(tname),
                tips = $(".validateTips8");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o, m) {
                if (o.val().length == 0) {
                    o.addClass("ui-state-error");
                    updateTips(m);
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(tname, "Please insert employee type name!");

                //valid = valid && checkLength( bid, "Please select bank for this branch!" );

                valid = valid && checkRegexp(tname, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for employee type name.");

                if (valid) {

                    /* displaydata();

                    function displaydata(){
                     $.ajax({
                                    url     : "{{url('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/
                    const empType = {
                        "name": document.getElementById('tname').value,
                        "_token": "{{csrf_token()}}"
                    }
                    $.ajax({
                        url: "{{url('createType')}}",
                        type: "POST",
                        async: false,
                        data: empType,
                        success: function (s) {
                            $('#type_id').append($('<option>', {
                                value: s,
                                text: tname.val(),
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 280,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#type_id').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });

        });
    </script>
    <script>
        $(function () {
            var dialog, form,

                // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
                jtitle = $("#jtitle"),

                allFields = $([]).add(jtitle),
                tips = $(".validateTips9");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o) {
                if (o.val().length == 0) {
                    o.addClass("ui-state-error");
                    updateTips("Please insert education level!");
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(jtitle);

                valid = valid && checkRegexp(jtitle, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for job title.");

                if (valid) {

                    /* displaydata();

                    function displaydata(){
                     $.ajax({
                                    url     : "{{url('createJobtitle')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }
       });
       }*/
                    const jobTitle = {
                        'name': document.getElementById('jtitle').value,
                        "_token": "{{csrf_token()}}"
                    }
                    $.ajax({
                        url: "{{url('createJobtitle')}}",
                        type: "POST",
                        async: false,
                        data: jobTitle,
                        success: function (s) {
                            $('#job_title').append($('<option>', {
                                value: s,
                                text: jtitle.val(),
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 250,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#job_title').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#itax").click(function () {
                if ($(this).is(':checked')) {
                    $("#irel").prop('checked', true);
                } else {
                    $("#irel").prop('checked', false);
                }
            });
        });
    </script>
    <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplete: '<div class="alert alert-danger parsley" role="alert"></div>',
            erroClass: 'has-error',
            successClass: 'has-success'
        };
    </script>
@endsection
