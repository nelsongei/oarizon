@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    @if(sizeof($organization) === 0)
                                        <button type="button" class="mb-2 btn btn-primary btn-outline-primary"
                                                data-toggle="modal" data-target="#create-account">
                                            Create Account
                                        </button>
                                    @else
                                        <button type="button" class="mb-2 btn btn-primary btn-outline-primary"
                                                data-toggle="modal" data-target="#pay-now">
                                            Paynow
                                        </button>
                                    @endif
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Module</th>
                                            <th>No Of Users</th>
                                            <th>Start Date</th>
                                            <th>Expiry Date</th>
                                            <th>Paid Via</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = 1?>
                                        <?php $ids = \App\Models\Organization::pluck('id')->first()?>
                                        @forelse($modules as $module)
                                            @if(sizeof($module['transactions'])===0)
                                                <tr>
                                                    <td colspan="7">
                                                        <center>
                                                            <svg width="118" height="110" viewBox="0 0 118 110"
                                                                 fill="#4e37b2"
                                                                 xmlns="http://www.w3.org/2000/svg" class="mt-5 mb-4">
                                                                <g clip-path="url(#clip0)">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M58.6672 32.9999C42.1415 32.9999 32.973 28.5119 32.5898 28.3194L33.4093 26.6804C33.4992 26.7244 42.6127 31.1666 58.6672 31.1666C74.542 31.1666 83.8388 26.7208 83.9323 26.6768L84.7354 28.3231C84.3449 28.5156 74.9618 32.9999 58.6672 32.9999Z"
                                                                          class="fill-primary-500"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M25.2438 39.0117L28.4191 40.8451C28.839 41.0871 29.1415 41.4831 29.2698 41.9597C29.3963 42.4346 29.3321 42.9296 29.0901 43.3494L14.4235 68.7521C14.099 69.3167 13.4866 69.6669 12.8248 69.6669C12.504 69.6669 12.1978 69.5844 11.9191 69.4231L8.74382 67.5897L7.82715 69.1774L11.0025 71.0107C11.5763 71.3426 12.2051 71.5002 12.8248 71.5002C14.0953 71.5002 15.3346 70.8421 16.0111 69.6687L30.6778 44.2661C31.6861 42.5189 31.083 40.2657 29.3358 39.2574L26.1605 37.4241L25.2438 39.0117Z"
                                                                          class="fill-primary-500"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M91.1729 37.4241L87.9976 39.2574C86.2504 40.2657 85.6472 42.5189 86.6556 44.2661L101.322 69.6687C101.999 70.8421 103.238 71.5002 104.509 71.5002C105.128 71.5002 105.757 71.3426 106.331 71.0107L109.506 69.1774L108.59 67.5897L105.414 69.4231C105.139 69.5826 104.826 69.6669 104.509 69.6669C103.847 69.6669 103.234 69.3167 102.91 68.7521L88.2432 43.3494C88.0012 42.9296 87.9371 42.4346 88.0636 41.9597C88.1919 41.4831 88.4944 41.0871 88.9142 40.8451L92.0896 39.0117L91.1729 37.4241Z"
                                                                          class="fill-primary-500"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M115.5 84.3333V87.6993C115.5 89.2797 114.424 90.6308 112.88 90.9883C112.013 91.19 111.049 91.4393 109.96 91.7198C102.573 93.6228 88.8268 97.1667 58.6667 97.1667C28.292 97.1667 14.6942 93.6338 7.38833 91.7345C6.29383 91.4503 5.324 91.1992 4.44767 90.9938C2.90767 90.6363 1.83333 89.2833 1.83333 87.7067V84.3333L0 82.5V87.7067C0 90.134 1.66833 92.2295 4.0315 92.7795C10.9322 94.3873 23.6812 99 58.6667 99C93.3478 99 106.372 94.3818 113.296 92.7758C115.661 92.2258 117.333 90.1285 117.333 87.6993V82.5"
                                                                          class="fill-primary-500"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M79.6139 20.1666L115.245 81.7354C115.841 82.7566 115.344 84.0656 114.214 84.4102C107.345 86.4966 89.3159 89.8333 58.6662 89.8333C27.9744 89.8333 9.97652 86.3371 3.12535 84.2526C1.99602 83.9079 1.49919 82.5989 2.09502 81.5778L37.7204 20.1666L36.6662 18.3333L0.503686 80.6666C-0.686148 82.7071 0.322186 85.3251 2.58085 86.0163C9.60985 88.1704 27.7104 91.6666 58.6662 91.6666C89.4625 91.6666 107.664 88.3189 114.742 86.1666C117.008 85.4772 118.022 82.8574 116.829 80.8133L80.6662 18.3333"
                                                                          class="fill-gray-600"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M110.814 92.4116L115.245 100.069C115.841 101.089 115.344 102.4 114.214 102.742C107.345 104.831 89.3159 108.167 58.6662 108.167C27.9744 108.167 9.97469 104.671 3.12535 102.585C1.99602 102.242 1.49919 100.931 2.09502 99.9117L6.41985 92.4556L4.75885 91.6672L0.503686 99.0006C-0.686148 101.041 0.322185 103.657 2.58085 104.35C9.60985 106.504 27.7104 110.001 58.6662 110.001C89.4625 110.001 107.664 106.653 114.742 104.501C117.007 103.811 118.022 101.191 116.829 99.1472L112.682 91.9789L110.814 92.4116Z"
                                                                          class="fill-gray-600"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M58.667 0C47.238 0 36.667 7.1335 36.667 18.3407V20.1667C36.667 20.1667 42.6052 23.8333 58.667 23.8333C74.6665 23.8333 80.667 20.1667 80.667 20.1667V18.3333C80.667 7.24167 70.767 0 58.667 0ZM58.667 1.83333C70.3527 1.83333 78.8337 8.7725 78.8337 18.3333V19.0172C76.6887 19.9302 70.5103 22 58.667 22C46.7705 22 40.6197 19.9283 38.5003 19.0227V18.3407C38.5003 12.3658 41.7692 8.55617 44.51 6.41117C48.2317 3.50167 53.3907 1.83333 58.667 1.83333Z"
                                                                          class="fill-gray-600"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M69.6667 53.1666C70.6768 53.1666 71.5 53.9898 71.5 54.9999V89.8333H73.3333V54.9999C73.3333 52.9741 71.6925 51.3333 69.6667 51.3333H47.6667C45.6408 51.3333 44 52.9741 44 54.9999V89.8333H45.8333V54.9999C45.8333 53.9898 46.6565 53.1666 47.6667 53.1666H69.6667Z"
                                                                          class="fill-gray-600"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M58.6667 56.8333C53.6048 56.8333 49.5 60.9381 49.5 65.9999C49.5 71.0618 53.6048 75.1666 58.6667 75.1666C63.7285 75.1666 67.8333 71.0618 67.8333 65.9999C67.8333 60.9381 63.7285 56.8333 58.6667 56.8333ZM58.6667 58.6666C62.711 58.6666 66 61.9556 66 65.9999C66 70.0443 62.711 73.3333 58.6667 73.3333C54.6223 73.3333 51.3333 70.0443 51.3333 65.9999C51.3333 61.9556 54.6223 58.6666 58.6667 58.6666Z"
                                                                          class="fill-gray-600"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                          d="M63.2503 66C62.7443 66 62.3337 65.5893 62.3337 65.0833C62.3337 63.5672 61.0998 62.3333 59.5837 62.3333C59.0777 62.3333 58.667 61.9227 58.667 61.4167C58.667 60.9107 59.0777 60.5 59.5837 60.5C62.11 60.5 64.167 62.5552 64.167 65.0833C64.167 65.5893 63.7563 66 63.2503 66Z"
                                                                          class="fill-primary-500"></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0">
                                                                        <rect width="117.333" height="110"
                                                                              fill="white"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                            <div class="mt-2"><label class="font-medium">No Payments
                                                                    yet!</label></div>
                                                            <div class="mt-2"><label class="text-gray-500">This
                                                                    section will contain the list of all
                                                                    payments.</label></div>
                                                        </center>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{$count++}}</td>
                                                    <td>
                                                        @if(App\Models\License::where('module_id',$module['id'])->pluck('module_id')->first())
                                                            <a href="{{url("mpesaTransactions/$ids".'/'.$module['id'])}}">
                                                                {{$module['name']}}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>{{$module['user_count']}}</td>
                                                    <td>{{App\Models\License::where('module_id',$module['id'])->pluck('start_date')->first()}}</td>
                                                    <td>{{App\Models\License::where('module_id',$module['id'])->pluck('end_date')->first()}}</td>
                                                    <td>Mpesa</td>
                                                    <td>
                                                        <button type="button"
                                                                class="btn btn-sm btn-primary dropdown-toggle"
                                                                data-toggle="dropdown">
                                                            <i class="fa fa-cogs"></i>Action
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li class="dropdown-item text-info">
                                                                <a href="{{url("mpesaTransactions/$ids".'/'.$module['id'])}}">
                                                                    <i class="fa fa-eye"></i>
                                                                    View Transactions
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="7">
                                                    <center>
                                                        <svg width="110" height="110" viewBox="0 0 110 110"
                                                             fill="#4e37b2"
                                                             xmlns="http://www.w3.org/2000/svg" class="mt-5 mb-4">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M55 13.75C24.6245 13.75 0 22.9848 0 34.375C0 45.7652 24.6245 55 55 55C85.3755 55 110 45.7652 110 34.375C110 22.9848 85.3755 13.75 55 13.75ZM55 15.4688C86.8708 15.4688 108.281 25.245 108.281 34.375C108.281 43.505 86.8708 53.2812 55 53.2812C23.1292 53.2812 1.71875 43.505 1.71875 34.375C1.71875 25.245 23.1292 15.4688 55 15.4688Z"
                                                                  class="fill-gray-600"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M54.9999 1.71875C66.0842 1.71875 75.7452 7.92172 80.697 17.038L82.732 17.2081C77.6737 7.01078 67.1549 0 54.9999 0C42.7985 0 32.2454 7.06406 27.2095 17.3267L29.2479 17.1411C34.1824 7.96812 43.8745 1.71875 54.9999 1.71875Z"
                                                                  class="fill-primary-500"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M55 96.25C40.7619 96.25 25.7812 99.3283 25.7812 103.125C25.7812 106.922 40.7619 110 55 110C69.2381 110 84.2188 106.922 84.2188 103.125C84.2188 99.3283 69.2381 96.25 55 96.25ZM55 97.9688C70.4602 97.9688 81.5959 101.317 82.4811 103.125C81.5959 104.933 70.4602 108.281 55 108.281C39.5398 108.281 28.4041 104.933 27.5189 103.125C28.4041 101.317 39.5398 97.9688 55 97.9688Z"
                                                                  class="fill-primary-500"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M27.4756 103.328L25.8049 102.922L41.2737 39.3286L42.9443 39.7342L27.4756 103.328Z"
                                                                  class="fill-primary-500"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M82.5247 103.328L67.0559 39.7342L68.7265 39.3286L84.1953 102.922L82.5247 103.328Z"
                                                                  class="fill-primary-500"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M68.75 39.5312C68.75 42.3792 62.5934 44.6875 55 44.6875C47.4066 44.6875 41.25 42.3792 41.25 39.5312C41.25 36.6833 47.4066 34.375 55 34.375C62.5934 34.375 68.75 36.6833 68.75 39.5312Z"
                                                                  class="fill-gray-600"></path>
                                                        </svg>
                                                        <div class="mt-2"><label class="font-medium">
                                                                Create account and Contact Lixnet To add Modules
                                                            </label></div>
                                                        <div class="mt-2"><label class="text-gray-500">This
                                                                section will contain the list of all payments.</label>
                                                        </div>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="create-account">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST"
                                          id="create-organization">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="cname">Surname:</label>
                                                    <input type="text" class="form-control" id="surname" name="surname"
                                                           placeholder="Surname">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="cname">First Name:</label>
                                                    <input type="text" class="form-control" id="fname" name="fname"
                                                           placeholder="First Name">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="cname">Last Name:</label>
                                                    <input type="text" class="form-control" id="lname" name="lname"
                                                           placeholder="Last Name">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="mobno">Mobile Number:</label>
                                                    <input type="text" class="form-control" id="mobno" name="mobno"
                                                           placeholder="Mobile Number">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="email">Email:</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                           placeholder="Email">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="cname">Company Name:</label>
                                                    <input type="text" class="form-control" id="cname" name="cname"
                                                           placeholder="Company Name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="pin">KRA Pin:</label>
                                                    <input type="text" class="form-control" id="pin" name="pin"
                                                           placeholder="KRA PIN">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="website">Website</label>
                                                    <input type="text" class="form-control" id="website" name="website"
                                                           placeholder="http://example.com">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="website">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address"
                                                           placeholder="ex rd p.o box">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="module">Module: </label>
                                                    <select type="text" class="form-control" id="module" name="module">
                                                        <option value="">Select Package</option>
                                                        @foreach ($modules  as $module )
                                                            <option
                                                                value="{{$module['id']}}">{{$module['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" id="paid_via" name="paid_via" value="mpesa">
                                                <input type="hidden" id="trxn_id" name="trxn_id" value="">
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-sm btn-warning"
                                                    data-dismiss="modal">
                                                Not Now
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                    id="create-organization">
                                                Create Organization
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="pay-now">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" id="mpesa">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="alert alert-info icons-alert" role="alert">
                                                <div class="iq-alert-text"><strong>Payment Alert! </strong>Follow the
                                                    instructions below
                                                </div>
                                            </div>
                                            <strong>Instructions to pay</strong>
                                            <ol>
                                                <li>Check on a payment popup on your phone</li>
                                                <li>Input your MPESA PIN and click OK.</li>
                                                <li>An MPESA confirmation SMS will be sent to you.</li>
                                                <li>Wait for upto 2-minutes as we try to validate your transaction.</li>
                                                <li>Do NOT close this window.</li>
                                                <li id="callBack" style="display: none"><strong>Transaction Failed.
                                                        Click The
                                                        Pay Now Button Again.</strong></li>
                                                <li id="success" style="display: none;color: #14a800"><strong>Transaction
                                                        SuccessFull.
                                                        You May
                                                        Close This form.</strong></li>
                                            </ol>
                                            <input type="hidden" id="organizationId" name="organizationId"
                                                   value="{{Auth::user()->organization_id}}">
                                            <div class="form-group">
                                                <label for="phone" class="col-form-label">Phone Number:</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                       placeholder="254712345678">
                                            </div>
                                            <div class="form-group ">
                                                <label for="module_id" class="block">Module Name</label>
                                                <select name="module_id"
                                                        id="module_id" class="form-control"
                                                        onclick="selectModule()">
                                                    @foreach($modules as $module)
                                                        <option
                                                            value="{{$module['id']}}">{{$module['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="dDate" style="display: none"></div>
                                            <div class="form-group">
                                                <label for="amount" class="block">License Amount *</label>
                                                <span id="dHolder" class="col-sm-12">
                                                    <input id="amount" name="amount" type="text" class="form-control"
                                                           placeholder="Product Price" readonly required>
                                                </span>
                                                <div class="mb-3 input-group input-group-md"
                                                     id="loaderField" style="display: none;">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <img src="{{asset('assets/assets/images/loader.gif')}}"
                                                             width="15px"
                                                             height="15px"
                                                             style="margin-top: -5px !important;" alt="">
                                                    </span>
                                                    </div>
                                                    <input type="text" id="amount" readonly="" class="form-control"
                                                           placeholder="Loading Module Price..">
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="paid">Amount To Be Paid: *</label>
                                                    <p></p>
                                                    <input type="text" class="form-control" id="paid" name="paid"
                                                           placeholder="Account To Be Paid.">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="balance">Balance *</label>
                                                <input type="text" class="form-control" id="balance" name="balance"
                                                       placeholder="Balance." readonly>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-sm btn-warning not-now"
                                                    id="closeModal">
                                                Not Now
                                            </button>
                                            <button style="display: none" type="button"
                                                    class="btn btn-sm btn-warning click-me"
                                                    id="closeModals">
                                                Close Me
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-primary pay-now"
                                                    id="pay-now">
                                                Pay Now
                                            </button>
                                            <button style="display: none;" id="processingPaymentButton" type="button"
                                                    class="btn btn-outline-info">
                                                <div style="max-height: 20px; max-width: 20px"
                                                     class="spinner-border  text-info"
                                                     id="">
                                                </div>
                                            </button>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#paid,#amount").on("Keydown keyup", function (event) {
                var tr = $(this).closest(".row");
                tr.find("#balance").val(Number(tr.find("#amount").val()) - Number(tr.find("#paid").val()));
            })
        })
    </script>
    <script>
        document.getElementById('closeModal').addEventListener('click', (event) => {
            event.preventDefault();
            $('#pay-now').modal('hide');
        })
        document.getElementById('closeModals').addEventListener('click', (event) => {
            event.preventDefault();
            $('#pay-now').modal('hide');
        })
    </script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('create-organization').addEventListener('submit', (event) => {
            event.preventDefault();
            const requestOrganization = {
                cname: document.getElementById('cname').value,
                fname: document.getElementById('fname').value,
                lname: document.getElementById('lname').value,
                surname: document.getElementById('surname').value,
                mobno: document.getElementById('mobno').value,
                email: document.getElementById('email').value,
                pin: document.getElementById('pin').value,
                address: document.getElementById('address').value,
                website: document.getElementById('website').value,
                module: document.getElementById('module').value,
                paid_via: document.getElementById('paid_via').value,
                trxn_id: document.getElementById('trxn_id').value,
            }
            axios.post("http://127.0.0.1/oarizon/public/create/organization", requestOrganization)
                .then((response) => {
                    console.log(response)
                    toastr.success('Organization Data Saved');
                    window.location.reload()
                })
                .catch((error) => {
                    console.log(error)
                })
            // if (requestOrganization['cname'] === '' || requestOrganization['fname'] === '' || requestOrganization['lname'] === '' | requestOrganization['surname'] === '' || requestOrganization['mobno'] === '' || requestOrganization['email'] === '' || requestOrganization['pin'] === '' || requestOrganization['address'] === '' ||requestOrganization['website']===''||requestOrganization['module']==='') {
            //     toastr.warning('All Fields ARe required');
            // } else {
            // }
        });
    </script>
    <script>
        var intervalId = null;
        document.getElementById('pay-now').addEventListener('submit', (event) => {
            event.preventDefault();
            const requestBody = {
                phone: document.getElementById('phone').value,
                amount: document.getElementById('amount').value,
            }
            axios.post("http://127.0.0.1/oarizon/public/stkPush", requestBody)
                .then((response) => {
                    if (response.data.ResponseDescription) {
                        let CheckoutRequestID = response.data.CheckoutRequestID;
                        toastr.success(response.data.ResponseDescription, {timeout: 5000})
                        $('.pay-now').hide();
                        $('#processingPaymentButton').show();
                        intervalId = setInterval(function () {
                            callBackStatus(CheckoutRequestID);
                        }, 5000);
                    } else {
                        console.log(response.data.errorMessage)
                        toastr.error(response.data.errorMessage, {timeout: 5000});
                    }
                })
        })

        function callBackStatus(CheckoutRequestID) {
            console.log(CheckoutRequestID)
            $.ajax({
                url: "http://127.0.0.1/licensemanager/public/api/v1/data/" + CheckoutRequestID,
                type: "GET",
                success: function (data) {
                    console.log(data.transaction.length);
                    if (data.transaction.length > 0) {
                        console.log(data.transaction[0].CheckoutRequestID)
                        if (data.transaction[0].CheckoutRequestID === CheckoutRequestID) {
                            toastr.success(data.transaction[0].ResultDesc);
                            clearInterval(intervalId);
                            $('#success').show();
                            $('#processingPaymentButton').hide();
                            $('.not-now').hide();
                            $('.click-me').show();
                            updateOrganization(CheckoutRequestID);
                        }
                    } else {
                        $('#callBack').show()
                    }
                }
            })
        }

        function updateOrganization(CheckoutRequestID) {
            console.log(CheckoutRequestID)
            var organizationId = document.getElementById('organizationId').value;
            var moduleId = document.getElementById('module_id').value;
            var endDate = document.getElementById('end_dates').value;
            axios.post("http://127.0.0.1/licensemanager/public/api/v1/update/organization/" + CheckoutRequestID + "/" + organizationId + "/" + moduleId + "/" + endDate, {})
                .then((response) => {
                    if (response) {
                        axios.get("http://127.0.0.1/oarizon/public/license/date/" + organizationId + "/" + moduleId + "/" + endDate, {})
                            .then((response) => {
                                if (response) {
                                    window.location.reload()
                                }
                            })
                            .catch((err) => {
                                console.log(err);
                            })
                    }
                })
                .catch((err) => {
                    console.log(err);
                })
        }
    </script>
    <script>
        function selectModule() {
            var path = document.getElementById('module_id').value;
            if (path !== 0) {
                $('#dHolder').hide();
                $('#loaderField').show();
            }
            $.ajax({
                url: "http://127.0.0.1/oarizon/public/license/data/" + path,
                type: 'GET',
                data: '_token=<?php echo csrf_token()?>',
                success: function (data) {
                    if (data) {
                        document.getElementById('dHolder').innerHTML = '<input type="text" id="amount" name="amount" class="form-control" readonly value="' + data[0].price + '">';
                        document.getElementById('dDate').innerHTML = '<input type="hidden" id="end_dates" name="end_date" value="' + (parseInt(data[0].interval_count) + parseInt(data[0].trial_days)) + '">'
                        $('#dHolder').show();
                        $('#loaderField').hide();
                    }
                }
            })
        }
    </script>
@endsection
