<table class="table table-bordered table-stripped mt-3">
    <thead>
    <tr>
        <th>EMPLOYER CODE</th>
        <td colspan="5">
            @if($organization->nhif_no === null)
                <p style="color: darkgreen">Update Your Organization NHIF NO</p>
            @else
                {{$organization->nhif_no}}
            @endif
        </td>
    </tr>
    <tr>
        <th>EMPLOYER NAME</th>
        <td colspan="5">
            @if($organization->name === null)
                <p style="color: darkgreen">Update Your Organization Name</p>
            @else
                {{$organization->name}}
            @endif
        </td>
    </tr>
    <tr>
        <th>MONTH OF CONTRIBUTION</th>
        <td colspan="5">
            {{$month}}
        </td>
    </tr>
    <tr>
        <th>PAYROLL NO</th>
        <th>LAST NAME</th>
        <th>FIRST NAME</th>
        <th>ID NO</th>
        <th>NHIF NO</th>
        <th>AMOUNT</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $da)
        <tr>
            <td>{{$da->employee_id}}</td>
            <td>{{$da->last_name}}</td>
            <td>{{$da->first_name}}</td>
            <td>{{$da->identity_number}}</td>
            <td>{{$da->hospital_insurance_number}}</td>
            <td>{{$total}}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="5" align="right">Total</td>
        <td>{{$total}}</td>
    </tr>
    </tbody>
</table>
