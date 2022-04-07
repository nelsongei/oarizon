@extends('layouts.leave')
<script src="{{asset('media/jquery-1.12.0.min.js')}}"></script>

<script type="text/javascript">
    $(function () {

        $(".wmd-view-topscroll").scroll(function () {
            $(".wmd-view")
                .scrollLeft($(".wmd-view-topscroll").scrollLeft());
        });
        $(".wmd-view").scroll(function () {
            $(".wmd-view-topscroll")
                .scrollLeft($(".wmd-view").scrollLeft());
        });
    });
    $(window).load(function () {
        $('.scroll-div').css('width', $('.dynamic-div').outerWidth() );
    });
</script>
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            <h2>Vacation Roster</h2>


                            @if (count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                            @if (Session::get('notice'))
                                <div class="alert alert-info">{{ Session::get('notice') }}</div>
                            @endif

                            <h3>{{$employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name.' Leave Roster'}}</h3>


                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
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
                                            <td>{{App\models\Leavetype::getName($application->leavetype_id)}}</td>
                                            <td>{{date('d-M-Y', strtotime($application->application_date))}}</td>
                                            <td>{{date('d-M-Y', strtotime($application->applied_start_date))}}</td>
                                            <td>{{date('d-M-Y', strtotime($application->applied_end_date))}}</td>
                                            <td>{{App\models\Leaveapplication::getDays($application->applied_end_date,$application->applied_start_date,$application->is_weekend,$application->is_holiday)+1}}</td>
                                            <td>{{$application->status}}</td>
                                            <td>
                                                <a href="{{url('leaveapplications/edit/'.$application->id)}}">Amend</a> &nbsp; |
                                                @if($application->is_supervisor_approved == 1)
                                                    @if(App\models\Leaveapplication::getBalanceDays($application->employee, $application->leavetype,$application) >= Leaveapplication::getLeaveDays($application->applied_end_date,$application->applied_start_date))
                                                        <a href="{{url('leaveapplications/approve/'.$application->id)}}">Approve</a> &nbsp;
                                                    @endif
                                                @endif
                                                |&nbsp;<a href="{{url('leaveapplications/reject/'.$application->id)}}">Reject</a> &nbsp;|
                                                <a href="{{url('leaveapplications/cancel/'.$application->id)}}">Cancel</a>
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
