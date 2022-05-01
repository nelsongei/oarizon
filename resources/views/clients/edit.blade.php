@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4><font color='green'>Update Station</font></h4>
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
                                    <form method="POST" action="{{{ URL::to('clients/update/'.$client->id) }}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="username">Client Name <span style="color:red">*</span>
                                                    :</label>
                                                <input class="form-control" placeholder="" type="text" name="name"
                                                       id="name"
                                                       value="{{$client->name}}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Email:</label>
                                                <input class="form-control" placeholder=""
                                                       data-parsley-trigger="focusout focusin" type="email"
                                                       name="email_office" id="email_office" value="{{$client->email}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Phone:</label>
                                                <input class="form-control" placeholder=""
                                                       data-parsley-trigger="change focusout"
                                                       data-parsley-type="number" mimlenght="10" type="number"
                                                       name="office_phone"
                                                       id="office_phone" value="{{$client->phone}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Address:</label>
                                                <input class="form-control" placeholder="" type="text" name="address"
                                                       id="address"
                                                       value="{{$client->address}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Contact Name :</label>
                                                <input class="form-control" placeholder="" type="text" name="cname"
                                                       id="cname"
                                                       value="{{$client->contact_person}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Contact Personal Email:</label>
                                                <input class="form-control" placeholder=""
                                                       data-parsley-trigger="focusout focusin" type="email"
                                                       name="email_personal" id="email_personal"
                                                       value="{{$client->contact_person_email}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Contact Personal Contact:</label>
                                                <input class="form-control" placeholder="" type="text"
                                                       name="mobile_phone" id="mobile_phone"
                                                       value="{{$client->contact_person_phone}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Type</label><span style="color:red">*</span> :
                                                <select name="type" class="form-control" required>
                                                    <option></option>
                                                    <option
                                                        value="Customer"<?= ($client->type == 'Customer') ? 'selected="selected"' : ''; ?>>
                                                        Customer
                                                    </option>
                                                    <option
                                                        value="Supplier"<?= ($client->type == 'Supplier') ? 'selected="selected"' : ''; ?>>
                                                        Supplier
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Update Client
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

@stop
