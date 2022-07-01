@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <button type="button" class="mb-3 btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#addSettings">
                                        Add Settings
                                    </button>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Type</td>
                                            <td>Rate</td>
                                            <td>Salary From</td>
                                            <td>Salary To</td>
                                            <td>Action</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = 1?>
                                        @forelse($settings as $setting)
                                            <tr>
                                                <td>{{$count++}}</td>
                                                <td>{{$setting->type}}</td>
                                                <td>{{$setting->rate}}</td>
                                                <td>{{$setting->min}}</td>
                                                <td>{{$setting->max}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a data-toggle="modal"
                                                                   data-target="#updateSettings{{$setting->id}}">Update</a>
                                                            </li>
                                                            <li><a data-toggle="modal"
                                                                   data-target="#deleteSettings{{$setting->id}}">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="updateSettings{{$setting->id}}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{url('overtime_setting/update')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$setting->id}}">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="type">Type</label>
                                                                    <select id="type" name="type" class="form-control">
                                                                        <option>Daily</option>
                                                                        <option>Hourly</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="min">Salary Range</label>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <input id="min" type="text" name="min" class="form-control" placeholder="Min" value="{{$setting->min}}">
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <input id="min" type="text" name="max" class="form-control" placeholder="Max" value="{{$setting->max}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="cname">Rate</label>
                                                                    <input id="cname" type="text" name="rate" class="form-control" value="{{$setting->rate}}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">
                                                                    Not Now
                                                                </button>
                                                                <button type="submit" class="btn btn-sm btn-info">
                                                                    Add Settings
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="6">
                                                    <center>
                                                        <i class="fa fa-cog fa-5x" style="color: #7DA0B1"></i>
                                                        <p>Add Overtime Settings</p>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addSettings">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{url('overtime_setting/store')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select id="type" name="type" class="form-control">
                                    <option>Daily</option>
                                    <option>Hourly</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="min">Salary Range</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input id="min" type="text" name="min" class="form-control" placeholder="Min">
                                    </div>
                                    <div class="col-sm-6">
                                        <input id="min" type="text" name="max" class="form-control" placeholder="Max">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cname">Rate</label>
                                <input id="cname" type="text" name="rate" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">
                                Not Now
                            </button>
                            <button type="submit" class="btn btn-sm btn-info">
                                Add Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--    //@include('sweetalert::alert')--}}
@endsection
