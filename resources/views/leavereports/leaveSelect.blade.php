@extends('layouts.leave_ports')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Select Period</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-5">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

		 <form target="_blank" method="POST" action="{{URL::to('leaveReports/Employeesonleave')}}" accept-charset="UTF-8">
   
    <fieldset>

       
        <div class="form-group">
                        <label for="username">Vacation Type:</label>
                        <select name="balance" class="form-control">
                            <option></option>
                            @foreach($leaves as $leave)
                            <option value="{{$leave->id}}"> {{ $leave->name }}</option>
                            @endforeach

                        </select>
                
            </div>

            <div class="form-group">
                        <label for="username">Select Branch: <span style="color:red">*</span></label>
                        <select required name="branch" id="branchid" class="form-control">
                            <option></option>
                            <option value="All">All</option>
                            @foreach($branches as $branch)
                            <option value="{{$branch->id }}"> {{ $branch->name }}</option>
                            @endforeach

                        </select>
                
        </div>

        <div class="form-group">
                        <label for="username">Select Department: <span style="color:red">*</span></label>
                        <select required name="department" id="departmentid" class="form-control">
                            <option></option>
                            <option value="All">All</option>
                            @foreach($departments as $department)
                            <option value="{{$department->id }}"> {{ $department->department_name }}</option>
                            @endforeach

                        </select>
                
        </div>

                 <div class="form-group">
                        <label for="username">Download as: <span style="color:red">*</span></label>
                        <select required name="format" class="form-control">
                            <option></option>
                            <option value="excel"> Excel</option>
                            <option value="pdf"> PDF</option>
                        </select>
                
            </div>       
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Select</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>


@stop