  'use strict';
 $(document).ready(function() {
$('#nextkin').Tabledit({

    editButton: false,
    deleteButton: false,
    hideIdentifier: true,
    columns: {
        identifier: [1, 'nsnum'],
        editable: [[2, 'name'], [3, 'goodwill'],[4,'id_number'],[5,'relationship'],[6,'contact']]
    }
});
    $('#vehicle').Tabledit({
        editButton: false,
        deleteButton: false,
        hideIdentifier: true,
        columns: {

          identifier: [1, 'vsnum'],

          editable: [[2, 'regno'], [3, 'make'],[4,'fee']]

      }

  });
});
function add_nk_row()
{
    var table = document.getElementById("nextkin");

    var t1=(table.rows.length);
    var row = table.insertRow(t1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);

    cell1.className='tabledit-view-mode';

    cell3.className='tabledit-view-mode';
    cell4.className='tabledit-view-mode';
    cell5.className='tabledit-view-mode';
    cell6.className='tabledit-view-mode';
    cell7.className = 'tabledit-view-mode';
    // <input type='checkbox' class='ncase'/>
     $('<input type="checkbox" class="tabledit-input form-control input-sm ncase"/>').appendTo(cell1);
     $('<span id="nsnum">1.</span>').appendTo(cell2);
     $('<input class="tabledit-input form-control input-sm" type="text" name="name[0]" value="undefined">').appendTo(cell3);
     $('<input class="tabledit-input form-control input-sm" type="text" name="goodwill[0]" value="undefined">').appendTo(cell4);
     $('<input class="tabledit-input form-control input-sm" type="text" name="id_number[0]" value="undefined">').appendTo(cell5);
     $('<input class="tabledit-input form-control input-sm" type="text" name="relationship[0]" value="undefined">').appendTo(cell6);
     $('<input class="tabledit-input form-control input-sm" type="text" name="contact[0]" value="undefined">').appendTo(cell7);


};

function delete_row() {

}

  function add_ve_row()
  {
      var table = document.getElementById("vehicle");

      var t1=(table.rows.length);
      var row = table.insertRow(t1);
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
      var cell4 = row.insertCell(3);
      var cell5 = row.insertCell(4);
      var i = 2;



      cell1.className='vcase';
      cell2.className='tabledit-view-mode';
      cell3.className='tabledit-view-mode';
      cell4.className='tabledit-view-mode';
      cell5.className='tabledit-view-mode';

      $('<td><input type="checkbox"/></td>').appendTo(cell1);
      $('<td><span id="vsnum">2.</span></td>').appendTo(cell2);
      $('<td class="tabledit-view-mode"><input class="tabledit-input form-control input-sm vehdata"  type="text" id="regno" name="regno[0]" value=""/></td>').appendTo(cell3);
      $('<td class="tabledit-view-mode"><input class="tabledit-input form-control input-sm vehdata"  type="text" id="make" name="make[0]" value=""/></td>').appendTo(cell4);
      $('<select class="tabledit-input form-control input-sm vehdata"  id="fee" name="fee[0]"><option value="{{$charge->id}}">{{$charge->name. '-'.$charge->amount}}</option></select>').appendTo(cell5);

  }
