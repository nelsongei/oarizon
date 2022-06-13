@extends('layouts.login')
@section('title','Register')
@section('content')
    <section class="login-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <form class="md-float-material form-material" method="post" id="create_organization">
                        @csrf
                        <div class="text-center">
                            <img src="{{asset('media/logo/logo.png')}}" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Register Your Organization</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" id="firstname" name="firstname" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Firstname</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="surname" id="surname" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Surname</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="company_name" id="company_name" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Company Name</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="email" name="email" id="email" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Company Email</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="phone" id="phone" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Company Phone Number</label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-primary">
                                            <input type="password" name="password" id="password" class="form-control" required="">
                                            <span class="form-bar"></span>
                                            <label class="float-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-primary">
                                            <input type="password" name="confirm-password" class="form-control" required="">
                                            <span class="form-bar"></span>
                                            <label class="float-label">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="website" id="website" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Company Website</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="address" id="address" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Company Address</label>
                                </div>
                                <div class="form-group form-primary">
                                    <h4 class="sub-title">Select Package</h4>
                                    <select name="module_id" id="module_id" class="form-control form-control-default fill">
                                        <option selected disabled >Select Package</option>
                                        @foreach($modules as $module)
                                            <option value="{{$module['id']}}">{{$module['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" id="paid_via" name="paid_via" value="mpesa">
                                <input type="hidden" id="trxn_id" name="trxn_id" value="">
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                            Sign up now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('create_organization').addEventListener('submit',(event)=>{
            event.preventDefault();
            const requestOrganization={
                firstname: document.getElementById('firstname').value,
                surname: document.getElementById('surname').value,
                company_name: document.getElementById('company_name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                password: document.getElementById('password').value,
                website: document.getElementById('website').value,
                address: document.getElementById('address').value,
                module_id: document.getElementById('module_id').value,
                paid_via: document.getElementById('paid_via').value,
                trxn_id: document.getElementById('trxn_id').value,
            };
            axios.post("http://example.com/oarizon/public/createOrganizations",requestOrganization)
                .then((response)=>{
                    console.log(response);
                    toastr.success('Success, Proceed to login');
                    window.location = '/oarizon/public/login';
                })
                .catch((error)=>{
                    console.log(error);
                })
        })
    </script>
@endsection
