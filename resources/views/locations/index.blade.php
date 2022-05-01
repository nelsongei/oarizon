@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Stores</h3>


                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ url('locations/create')}}">New Store</a>
                            </div>
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

                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Name</th>
                                      <th>Description</th>
                                      <th></th>
                                    </tr>
                                    </thead>


                                    <tbody>

                                      <?php $i = 1; ?>
                                      @foreach($locations as $location)
                              
                                      <tr>
                              
                                        <td> {{ $i }}</td>
                                        <td>{{ $location->name }}</td>
                                        <td>{{$location->description }}</td>
                                         
                                      
                                        <td>
                              
                                                <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                  Action <span class="caret"></span>
                                                </button>
                                        
                                                <ul class="dropdown-menu" role="menu">
                                                  <li><a href="{{URL::to('locations/edit/'.$location->id)}}">Update</a></li>
                                                 
                                                  <li><a href="{{URL::to('locations/delete/'.$location->id)}}"  onclick="return (confirm('Are you sure you want to delete this location?'))">Delete</a></li>
                                                  
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
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>
@stop