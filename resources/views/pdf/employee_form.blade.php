<html ><head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style type="text/css">

table {
  max-width: 100%;
  background-color: transparent;
}
th {
  text-align: left;
}
.table {
  width: 100%;
  margin-bottom: 2px;
}
hr {
  margin-top: 1px;
  margin-bottom: 2px;
  border: 0;
  border-top: 2px dotted #eee;
}

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.428571429;
  color: #333;
  background-color: #fff;
}



 @page { margin-top: 160px; margin-left:30px; margin-right:30px; margin-bottom: 100px; }
 .header { position: top; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
 .content {margin-top: -100px; margin-bottom: -150px; margin-left:auto; margin-right: auto;}
 .footer { position: fixed; left: 0px; bottom: -120px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }



</style>

</head><body>


  <div class="header"  style="margin-top:-150px">
     <table >

      <tr>



        <td style="width:150px">

            <img src="{{public_path().'/assets/logo/'.$organization->logo}}" alt="logo" width="80%">


        </td>

        <td>
        <strong>
          {{ strtoupper($organization->name)}}
          </strong><br>
          {{ $organization->phone}}<br>
          {{ $organization->email}}<br>
          {{ $organization->website}}<br>
          {{ $organization->address}}


        </td>


      </tr>


      <tr>

        <hr>
      </tr>



    </table>
   </div>

   <div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>


	<div class="emp" style="margin-top:-70px">

  <div style="margin-top:20px" align="center"> <h3>EMPLOYEE DETAILS FORM</h3></div>
    <table style="margin-top:0px" style="margin-left:40px" border='0' width='500' height='300' cellspacing='0' cellpadding='0'>
      <tr><td colspan='2'><strong><span style="font-size:14px">Personal Details</span></strong></td></tr>
      <tr><td width="150" height="20">Surname Name: </td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">First Name:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Other Names:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Identity Number:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Passport Number:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="10">Gender:</td>
      <td>Male<input type="checkbox" /> Female<input type="checkbox" /></td></tr>
      <tr><td width="150" height="20">Marital Status:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Date of Birth:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Highest Education Level:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Citizenship:</td><td>.........................................................................................................................</td></tr>
      <tr><td colspan='2'><strong><span style="font-size:14px">Next of Kin Details</span></strong></td></tr>
      <tr><td width="150" height="20">Kin`s Name:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Kin`s Identity Number:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Kin`s Telephone Number:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Relationship:</td><td>..........................................................................................................................</td></tr>
      <tr><td colspan='2'><strong><span style="font-size:14px">Goverment Details</span></strong></td></tr>
      <tr><td width="150" height="20">Kra Pin:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Nssf Number:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Nhif Number:</td><td>.........................................................................................................................</td></tr>
      <tr><td colspan='2'><strong><span style="font-size:14px">Bank Details</span></strong></td></tr>
      <tr><td width="150" height="20">Bank Name:</td><td>........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Bank Branch:</td><td>........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Bank Account Number:</td><td>........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Sort Code:</td><td>........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Swift Code:</td><td>........................................................................................................................</td></tr>
      <tr><td colspan='2'><strong><span style="font-size:14px">Contact Details</span></strong></td></tr>
      <tr><td width="150" height="20">Personal Email:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Mobile Phone:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Postal Address:</td><td>.........................................................................................................................</td></tr>
      <tr><td width="150" height="20">Postal Zip:</td><td>..........................................................................................................................</td></tr>

    </table>
   </div>

</body></html>



