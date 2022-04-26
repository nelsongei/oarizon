@extends('layouts.membercss')
@section('content')





<br><br>

@if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif
    
                    <div class="row">
                      
                        <div>
                          <h2>Vacation Roster</h2>
                        </div>
                      
                    </div>
                  



<div class="row">
  
  <div class="col-lg-12">
    <hr>

  </div>
</div>


<div class="row">
  
<a href="{{URL::to('css/leaveroster/application')}}" class="btn btn-info">New Roster</a>
<br><br>

  <div class="col-lg-12">



      <table class="table table-condensed table-bordered" id="mobile">

         
          <thead>
            <th>#</th>
            <th>Vacation Type</th>
            <th>Application Date</th>
            <th>Applied Start Date</th>
            <th>Applied End Date</th>
            <th>Vacation Days</th>
            <th>Status</th>
            <th></th>


          </thead>
          <tbody>
          <?php $i=1; ?>
          @foreach($leaveapplications as $application)
            <tr>
                <td>{{$i}}</td>
                <td>{{Leavetype::getName($application->leavetype_id)}}</td>
                <td>{{date('d-M-Y', strtotime($application->application_date))}}</td>
                <td>{{date('d-M-Y', strtotime($application->applied_start_date))}}</td>
                <td>{{date('d-M-Y', strtotime($application->applied_end_date))}}</td>
                <td>{{Leaveapplication::getDays($application->applied_end_date,$application->applied_start_date,$application->is_weekend,$application->is_holiday)+1}}</td>
                <td>{{$application->status}}</td>
                <td>
           <a href="{{URL::to('leaveapplications/edit/'.$application->id)}}">Amend</a> &nbsp; |
           <a href="{{URL::to('leaveapplications/cancel/'.$application->id)}}">Cancel</a>
          </td>
              
            </tr>
            <?php $i++; ?>
            @endforeach
          </tbody>
        
      </table>
  

  </div>  


<div class="row">

  <div class="col-lg-12">
    <hr>
  </div>  

  

  
</div>


@stop