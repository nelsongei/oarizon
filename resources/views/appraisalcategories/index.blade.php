@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Appraisal Category</h3>
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
                                        <a class="btn btn-info btn-sm"
                                           href="{{ URL::to('appraisalcategories/create')}}">new appraisal category
                                        </a>
                                    </div>
                                    <table id="users" class="table table-condensed table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        @forelse($categories as $category)
                                            <tr>
                                                <td> {{ $i }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>

                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="{{URL::to('appraisalcategories/edit/'.$category->id)}}">Update</a>
                                                            </li>

                                                            <li>
                                                                <a href="{{URL::to('appraisalcategories/delete/'.$category->id)}}"
                                                                   onclick="return (confirm('Are you sure you want to delete this category?'))">Delete</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            @empty
                                            <tr>
                                                <td colspan="3">
                                                    <center>
                                                        <h1>
                                                            <i class="fa fa-file fa-5x" style="color: indianred"></i>
                                                        </h1>
                                                        <p>Create New Appraisal Categories</p>
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
    </div>

@endsection
