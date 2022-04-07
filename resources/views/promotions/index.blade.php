@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Employee Promotions & Transfers</h3>
                            <hr>
                        </div>
                        <div class="col-sm-12">
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
                                <div class="card-body">
                                    <div class="mb-2 col-12">
                                        <a class="btn btn-info btn-sm" href="{{ URL::to('promotions/create')}}">new
                                            promotion/Transfer</a>
                                    </div>
                                    <table
                                        class="table table-condensed table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Reason</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>

                                        </thead>

                                        <tfoot>
                                        <tr>

                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Reason</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>

                                        <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($promotions as $promotion)

                                            <tr>
                                                <td> {{ $i }}</td>
                                                <td>{{ App\models\Promotion::getEmployee($promotion->employee_id) }}</td>
                                                <td>{{ $promotion->reason }}</td>
                                                <td>{{ $promotion->type }}</td>
                                                <td>{{ $promotion->date }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="{{URL::to('promotions/show/'.$promotion->id)}}">View</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{URL::to('promotions/edit/'.$promotion->id)}}">Update</a>
                                                            </li>
                                                            @if($promotion->type=='promote')
                                                                <li>
                                                                    <a href="{{URL::to('promotions/letters/'.$promotion->id)}}">Generate
                                                                        Letter</a></li>
                                                            @else
                                                                <li>
                                                                    <a href="{{URL::to('transfer/letters/'.$promotion->id)}}">Generate
                                                                        Letter</a></li>
                                                            @endif
                                                            <li>
                                                                <a href="{{URL::to('promotions/delete/'.$promotion->id)}}"
                                                                   onclick="return (confirm('Are you sure you want to delete this employee {{$promotion->type}}?'))">Delete</a>
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
