<?php
function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.main_hr')
@section('xara_cbs')


    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-border-inverse">
                                <div class="card-header">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#items"
                                                                data-toggle="tab">Items</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#items_category" data-toggle="tab">Categories</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div id="items" class="active tab-pane">
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
                                            <div class="card-header">
                                                <h4>Items</h4>
                                                <div class="card-header-right">
                                                    <a class="dt-button btn-sm" href="{{ url('items/create')}}">New Item</a>
                                                </div>
                                            </div>
                                  
                                  
                                            <div class="card-block">
                                                <div class="dt-responsive table-responsive">
                                                    <table id="order-table" class="table table-striped table-bordered nowrap">
                                  
                                                        <thead>
                                  
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th style="width:150px;" >Description</th>
                                                            <th>Type</th>
                                                            <th>Category</th>
                                                            <th>Purchase Price</th>
                                                            <th>Selling Price</th>
                                                            <th></th>
                                                        </tr>
                                  
                                                        </thead>
                                  
                                                        <tbody>
                                  
                                                          <?php $i = 1; ?>
                                                          @foreach($items as $item)
                                  
                                                          <tr>
                                  
                                                            <td> {{ $i }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->description }}</td>
                                                            <td>{{ $item->type }}</td>
                                                            <td>@if($item->category != null){{ $item->categoryname->name}}@endif</td>
                                                            <td align="right">{{ asMoney($item->purchase_price) }}</td>
                                                            <td align="right">{{ asMoney($item->selling_price) }}</td>
                                                            <td>
                                  
                                                                    <div class="btn-group">
                                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                      Action <span class="caret"></span>
                                                                    </button>
                                  
                                                                    <ul class="dropdown-menu" role="menu">
                                                                      <li><a href="{{URL::to('items/edit/'.$item->id)}}">Update</a></li>
                                  
                                                                      <li><a href="{{URL::to('items/delete/'.$item->id)}}" onclick="return (confirm('Are you sure you want to delete this item?'))">Delete</a></li>
                                  
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
										<div id="items_category" class="tab-pane">
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
                                                        <div class="card-header">
                                                            <h4>Categories</h4>
                                                            <div class="card-header-right">
                                                                <a class="dt-button btn-sm" href="{{ url('itemscategory/create')}}">New Category</a>
                                                            </div>
                                                        </div>
                                              
                                              
                                                        <div class="card-block">
                                                            <div class="dt-responsive table-responsive">
                                                                <table id="order-table" class="table table-striped table-bordered nowrap">
                                              
                                                                    <thead>
                                              
                                                                    <tr>
                                                                      <th>#</th>
                                                                      <th>Name</th>
                                                                      <th>created_at</th>
                                                                      <th>updated_at</th>
                                                                      <th></th>
                                                                    </tr>
                                              
                                                                    </thead>
                                              
                                                                    <tbody>
                                              
                                                                      <?php $i = 1; ?>
                                                                     @foreach($items as $item)
                                    
                                                                      <tr>
                                    
                                                                      <td> {{ $i }}</td>
                                                                      <td>{{ $item->name }}</td>
                                                                      <td>{{ $item->description }}</td>
                                                                      <td>{{ $item->type }}</td>
                                                                      <td>@if($item->category != null){{ $item->categoryname->name}}@endif</td>
                                                                      <td align="right">{{ asMoney($item->purchase_price) }}</td>
                                                                      <td align="right">{{ asMoney($item->selling_price) }}</td>
                                                                      <td>
                                    
                                                                      <div class="btn-group">
                                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                          Action <span class="caret"></span>
                                                                        </button>
                                    
                                                                        <ul class="dropdown-menu" role="menu">
                                                                          <li><a href="{{URL::to('items/edit/'.$item->id)}}">Update</a></li>
                                    
                                                                          <li><a href="{{URL::to('items/delete/'.$item->id)}}" onclick="return (confirm('Are you sure you want to delete this item?'))">Delete</a></li>
                                    
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

                                <div class="modal fade" id="newcategory" tabindex="-1" role="dialog" aria-labelledby="newcategory" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create New Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form method="POST" action="{{ URL::to('itemscategory') }}">
                                          <fieldset>
                                            <div class="form-group">
                                              <label for="name">Category name</label>
                                              <input class="form-control" placeholder="" type="text" name="name" id="name" value=""></input>
                                            </div>
                                            <div class="form-group">
                                              <button type="submit" type="btn btn-primary">Save</button>
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
            </div>
        </div>
  @endsection