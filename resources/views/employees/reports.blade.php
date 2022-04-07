@extends('layouts.ports')
@section('xara_cbs')


<div class="row">
    <div class="col-lg-12">
  <h3>HR Reports</h3>

<hr>
</div>
</div>


<div class="row">
    <div class="col-lg-12">

    <ul>

        <li>

        <a href="{{ url('employee/select') }}"> Individual Employee report</a>

      </li>

      <li>

        <a href="{{ url('reports/selectEmployeeStatus') }}"> Employee List report</a>

      </li>

      <li>
            <a href="{{ url('reports/nextofkin/selectEmployee') }}" >Next of Kin Report</a>
        </li>

       <li>
            <a href="{{ url('reports/selectEmployeeOccurence') }}" >Employee Occurence report </a>
        </li>

        <li>
            <a href="{{ url('reports/CompanyProperty/selectPeriod') }}" >Company Property report </a>
        </li>

         <li>
            <a href="{{ url('reports/Appraisals/selectPeriod') }}" >Appraisal report </a>
        </li>


      <li>

        <a href="{{url('reports/blank')}}" target="_blank">Blank report template</a>

      </li>



    </ul>

  </div>

</div>

@stop
