<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>

<?php
require "../header.php";
?>

</head>

<body onLoad="searchStudents()">

<div class="container">

<?php
include "../menu.php";
?>

<script> 

function OpenInNewTab(url)
{
  var win=window.open(url, '_blank');
  win.focus();
}

function searchStudents() 
{ 
var display_id = document.getElementById("display_id").value; 
var first_name = document.getElementById("first_name").value;
var last_name = document.getElementById("last_name").value; 

//Allow ampersands and slashes in the URL to use the GET function
display_id = encodeURIComponent(display_id);
first_name = encodeURIComponent(first_name);
last_name = encodeURIComponent(last_name);

document.getElementById("studentResults").innerHTML = "<h1>Loading Students...</h1>"; 
  
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    { 
    document.getElementById("studentResults").innerHTML=xmlhttp.responseText; 
    } 
  } 
xmlhttp.open("GET","studentsearch.php?display_id="+display_id+"&first_name="+first_name+"&last_name="+last_name,true); 
xmlhttp.send(); 
} 

<!-- ADD BOOK -->

function toggleAddStudent()
{

    if(document.getElementById("newStudent").style.display == "none")
    {
        document.getElementById("newStudent").style.display = "";
        document.getElementById("addStudentButton").style.visibility = "hidden";
    }
    else
    {
        document.getElementById("newStudent").style.display = "none";
        document.getElementById("addStudentButton").style.visibility = "visible";

        document.getElementById("newDisplay_id").value = "";
        document.getElementById("newFirst_name").value = "";
        document.getElementById("newLast_name").value = "";
    }
}

function addStudent() 
{ 
var display_id = document.getElementById("newDisplay_id").value; 
var first_name = document.getElementById("newFirst_name").value;
var last_name = document.getElementById("newLast_name").value;  

//Allow ampersands and slashes in the URL to use the GET function
display_id = encodeURIComponent(display_id);
first_name = encodeURIComponent(first_name);
last_name = encodeURIComponent(last_name);
  
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    { 
        //Put whatever div of the html you want to update with the response text here.
    } 
  } 
xmlhttp.open("GET","addStudent.php?display_id="+display_id+"&first_name="+first_name+"&last_name="+last_name,true); 
xmlhttp.send(); 

toggleAddStudent();
blankAddStudent();
searchStudents();
} 

function blankAddStudent()
{
document.getElementById("newDisplay_id").value = ""; 
document.getElementById("newFirst_name").value = "";
document.getElementById("newLast_name").value = ""; 
}

<!-- DELETE Student -->

function deleteStudent(studentid)
{  
	var confirmDelete = confirm("All test scores for this student will also be deleted.\nDo You Really Want To Delete This Student?");

	if(confirmDelete == true)
	{
		if (window.XMLHttpRequest) 
		  {// code for IE7+, Firefox, Chrome, Opera, Safari 
		  xmlhttp=new XMLHttpRequest(); 
		  } 
		else
		  {// code for IE6, IE5 
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		  } 
		xmlhttp.onreadystatechange=function() 
		  { 
		  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				//Put whatever div of the html you want to update with the response text here.
			} 
		  } 
		xmlhttp.open("GET","deleteStudent.php?studentID="+studentid,true); 
		xmlhttp.send(); 

                document.getElementById("student" + studentid).style.display = "none";
		//searchStudents();
	}
}


<!-- EDIT BOOK -->

function goToEditView(editStudentID)
{
        document.getElementById("noEditStudentEditButton" + editStudentID).style.display = "none";
        document.getElementById("noEditStudentDeleteButton" + editStudentID).style.display = "none";
        document.getElementById("noEditStudentDisplay_id" + editStudentID).style.display = "none";
        document.getElementById("noEditStudentFirst_name" + editStudentID).style.display = "none";
        document.getElementById("noEditStudentLast_name" + editStudentID).style.display = "none";

        document.getElementById("editStudentSaveButton" + editStudentID).style.display = "inline-block";
        document.getElementById("editStudentCancelButton" + editStudentID).style.display = "inline-block";
        document.getElementById("editStudentDisplay_id" + editStudentID).style.display = "inline-block";
        document.getElementById("editStudentFirst_name" + editStudentID).style.display = "inline-block";
        document.getElementById("editStudentLast_name" + editStudentID).style.display = "inline-block";
}

function goToNoEditView(editStudentID)
{
        document.getElementById("noEditStudentEditButton" + editStudentID).style.display = "inline-block";
        document.getElementById("noEditStudentDeleteButton" + editStudentID).style.display = "inline-block";
        document.getElementById("noEditStudentDisplay_id" + editStudentID).style.display = "inline-block";
        document.getElementById("noEditStudentFirst_name" + editStudentID).style.display = "inline-block";
        document.getElementById("noEditStudentLast_name" + editStudentID).style.display = "inline-block";

        document.getElementById("editStudentSaveButton" + editStudentID).style.display = "none";
        document.getElementById("editStudentCancelButton" + editStudentID).style.display = "none";
        document.getElementById("editStudentDisplay_id" + editStudentID).style.display = "none";
        document.getElementById("editStudentFirst_name" + editStudentID).style.display = "none";
        document.getElementById("editStudentLast_name" + editStudentID).style.display = "none";

        var originalDisplay_id = document.getElementById("noEditStudentDisplay_id" + editStudentID).innerHTML;
        var originalFirst_name = document.getElementById("noEditStudentFirst_name" + editStudentID).innerHTML;
        var originalLast_name = document.getElementById("noEditStudentLast_name" + editStudentID).innerHTML;

        document.getElementById("editStudentDisplay_id" + editStudentID).value = originalDisplay_id;
        document.getElementById("editStudentFirst_name" + editStudentID).value = originalFirst_name;
        document.getElementById("editStudentLast_name" + editStudentID).value = originalLast_name;
}

function saveEditStudent(editStudentID)
{ 
var display_id = document.getElementById("editStudentDisplay_id" + editStudentID).value; 
var first_name = document.getElementById("editStudentFirst_name" + editStudentID).value;
var last_name = document.getElementById("editStudentLast_name" + editStudentID).value; 

//Allow ampersands and slashes in the URL to use the GET function
display_id = encodeURIComponent(display_id);
first_name = encodeURIComponent(first_name);
last_name = encodeURIComponent(last_name);

if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    {  
        document.getElementById("student" + editStudentID).innerHTML=xmlhttp.responseText;
    } 
  } 
xmlhttp.open("GET","saveEditStudent.php?display_id="+display_id+"&first_name="+first_name+"&last_name="+last_name+"&editStudentID="+editStudentID,true); 
//Test code: marlsven.byethost18.com/students/saveEditStudent.php?display_id=00asdf&first_name=first_nameasdf&last_name=last_nameASDF&fnf=fnfASDF&picPhon=picPhonASDF&copies=10&editStudentID=630
xmlhttp.send(); 

//searchStudents();
} 

</script>


<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><h2>Mrs Karlsven's Students</h2></div>

  <!-- Search Table -->
  <table class="table">
    <tr>
        <form class="navbar-form navbar-left" method="GET">
            <td>            
                <button id="addStudentButton" type="button" class="btn btn-primary btn-lg" onclick="toggleAddStudent()">
                    Add New Student
                </button>
            </td>
            <td></td>
            <td><input type="text" class="form-control" id="display_id" placeholder="Search by ID" onkeyup="searchStudents()"></td>
            <td><input type="text" class="form-control" id="first_name" placeholder="Search by First Name" onkeyup="searchStudents()"></td>
            <td><input type="text" class="form-control" id="last_name" placeholder="Search by Last Name" onkeyup="searchStudents()"></td>
            <td></td>
            <td></td>
            <td></td>
        </form>
    </tr>
  </table>

  <!-- Add Student Table -->
  <!-- <table id="addStudentTable" class="table" style="display:none">
    <tr id="newStudent">
        <form class="navbar-form navbar-left" method="GET">
            <td>
                <button type="button" class="btn btn-warning btn-lg" onclick="addStudent()">
                    <span class="glyphicon glyphicon-plus"></span> Save
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default btn-lg" onclick="toggleAddStudent()">
                    <span class="glyphicon glyphicon-remove"></span> Cancel
                </button>
            </td>
            <td><input type="text" class="form-control" id="newDisplay_id" placeholder="Display_id" ></td>
            <td><input type="text" class="form-control" id="newFirst_name" placeholder="First_name" ></td>
            <td><input type="text" class="form-control" id="newLast_name" placeholder="Last_name" ></td>
            <td><input type="text" class="form-control" id="newFiction_Non-Fiction" placeholder="Fiction/Non-Fiction" ></td>
            <td><input type="text" class="form-control" id="newPicture_Phonics" placeholder="Picture/Phonics" ></td>
            <td><input type="text" class="form-control" id="newCopies" placeholder="# Of Copies" ></td>
        </form>
    </tr>
  </table> -->

<span id="studentResults"></span>
</div>

</div> <!-- END OF CONTAINER DIV -->
</body>

<?php
mysqli_close($con);
?>
</html>					