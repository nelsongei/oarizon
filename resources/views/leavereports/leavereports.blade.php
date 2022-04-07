@extends('layouts.leave_ports')
@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Vacation Reports</h3>

<hr>
</div>  
</div>


<div class="row">
    <div class="col-lg-12">

    <ul>

       <li>
            <a href="{{ URL::to('leaveReports/selectApplicationPeriod') }}"> Vacation Application</a>
       </li>

       <li>
            <a href="{{ URL::to('leaveReports/selectRosterPeriod') }}"> Vacation Roster</a>
       </li>

       <li>
          <a href="{{ URL::to('leaveReports/selectApprovedPeriod') }}">Vacation Approved</a>
       </li>

       <li>
          <a href="{{ URL::to('leaveReports/selectRejectedPeriod') }}">Vacation Rejected</a>
       </li>

       <li>
          <a href="{{ URL::to('leaveReports/selectLeave') }}">Vacation Balances</a>
       </li>
    
       <li>
          <a href="{{ URL::to('leaveReports/selectLeaveType') }}"> Employees on vacation </a>
       </li>  

       <li>
         <a href="{{ URL::to('leaveReports/selectEmployee') }}"> Individual Employee </a>     
       </li>  

       <li>
        <a href="reports/blank" target="_blank">Blank report template</a>
      </li>
    </ul>

  </div>

</div>

@stop