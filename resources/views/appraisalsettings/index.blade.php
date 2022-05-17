@extends('layouts.main_hr')
@section('xara_cbs')
    <?php
        use App\Models\Appraisalcategory;
    ?>
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Appraisal Settings</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
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
                                        <a class="btn btn-info btn-sm" href="{{ URL::to('AppraisalSettings/create')}}">
                                            new appraisal setting
                                        </a>
                                    </div>
                                    <table id="users" class="table table-condensed table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Category</th>
                                            <th>Rate</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $i = 1; ?>
                                        @foreach($appraisals as $appraisal)

                                            <tr>

                                                <td>{{ $i }}</td>
                                                <td>{{ $appraisal->question }}</td>
                                                <td>{{ Appraisalcategory::getCategory($appraisal->appraisalcategory_id) }}</td>
                                                <td>{{ $appraisal->rate }}</td>
                                                <td>

                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="{{URL::to('AppraisalSettings/edit/'.$appraisal->id)}}">Update</a>
                                                            </li>

                                                            <li>
                                                                <a href="{{URL::to('AppraisalSettings/delete/'.$appraisal->id)}}"
                                                                   onclick="return (confirm('Are you sure you want to delete this appraisal question?'))">Delete</a>
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
@endsection
