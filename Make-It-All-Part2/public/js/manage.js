const changeTable = (url) =>{
  window.location.href = url;
}
function returnTableBG(){
  var table = document.getElementById('managerTable');
  for (var i = 2; i < table.rows.length ; i++){
    for (var j = 0; j < table.rows[i].cells.length; j++ ){
      table.rows[i].cells[j].style.backgroundColor = "#605E5E";
    }
  }
}

var identifierVar = ""
var isEmployee = false;
function getIdentifier(tableRow) {
  returnTableBG();
  identifierVar = tableRow.cells[0].innerHTML;
  if (tableRow.classList.contains('user_row')) { //'User' Mange Page exlusive if statement
    //If manage users table page
    if (tableRow.cells[3].innerHTML != "Employee"){
      isEmployee = true;
    }
  }
  
  for (var i = 0; i < tableRow.cells.length ; i++){
    tableRow.cells[i].style.backgroundColor = "#3937b8";
  }
  document.getElementById('deleteInput').value = identifierVar;
  document.getElementById('updateIdentifierInput').value = identifierVar;
}

function deleteRow(){
  if(confirm('Are you sure you want to delete this information?')){
    document.getElementById('deleteForm').submit();
  }
}

function showUpdatePopup() {
    document.getElementById("managerPage").style.pointerEvents = "none";
    document.getElementById("managerHeader").style.pointerEvents = "none";
    document.getElementById("searchGroup").style.pointerEvents = "none";
    document.getElementById("editOptions").style.pointerEvents = "none";
    document.getElementById("managerTable").style.pointerEvents = "none";
    document.getElementById('managerPage').setAttribute("style", "opacity:0.5; -moz-opacity:0.5; filter:alpha(opacity=50)");
    document.getElementById("footer").style.pointerEvents = "none";
    document.getElementById('footer').setAttribute("style", "opacity:0.5; -moz-opacity:0.5; filter:alpha(opacity=50)");

    if (isEmployee == true){ hideEmpStuff() };
    document.getElementById('updateInfo').style.display = 'block';
} function hideUpdatePopup() {
    document.getElementById("managerPage").style.pointerEvents = "auto";
    document.getElementById("managerHeader").style.pointerEvents = "auto";
    document.getElementById("searchGroup").style.pointerEvents = "auto";
    document.getElementById("editOptions").style.pointerEvents = "auto";
    document.getElementById("managerTable").style.pointerEvents = "auto";
    document.getElementById('managerPage').setAttribute("style", "opacity:1; -moz-opacity:1; filter:alpha(opacity=100)");
    document.getElementById("footer").style.pointerEvents = "auto";
    document.getElementById('footer').setAttribute("style", "opacity:1; -moz-opacity:1; filter:alpha(opacity=100)");

    if (isEmployee == true){ showEmpStuff() };
    document.getElementById('updateInfo').style.display = 'none';
}

function hideEmpStuff(){
  document.getElementById('empEdit').style.display = 'none';
} 
function showEmpStuff(){
  document.getElementById('empEdit').style.display = 'block';
  isEmployee = false;
}