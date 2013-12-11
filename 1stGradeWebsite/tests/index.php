<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>

<?php
require "../header.php";
?>

</head>

<body onLoad="searchTests()">

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

function searchTests() 
{ 
var name = document.getElementById("name").value; 
var quarter = document.getElementById("quarter").value; 
var category = document.getElementById("category").value; 

name = encodeURIComponent(name);
quarter = encodeURIComponent(quarter);
category = encodeURIComponent(category);

document.getElementById("TestResults").innerHTML = "<h1>Loading Tests...</h1>"; 
  
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
    document.getElementById("TestResults").innerHTML=xmlhttp.responseText; 
    } 
  } 
xmlhttp.open("GET","testsearch.php?name="+name+"&quarter="+quarter+"&category="+category,true); 
xmlhttp.send(); 
} 

<!-- ADD Test -->

function toggleAddTest()
{

    if(document.getElementById("newTest").style.display == "none")
    {
        document.getElementById("newTest").style.display = "";
        document.getElementById("addTestButton").style.visibility = "hidden";
    }
    else
    {
        document.getElementById("newTest").style.display = "none";
        document.getElementById("addTestButton").style.visibility = "visible";

        document.getElementById("newQuarter").value = "";
        document.getElementById("newName").value = "";
        document.getElementById("newCategory").value = "";
        document.getElementById("newTotal_Points").value = "";
    }
}

function addTest() 
{ 
var quarter = document.getElementById("newQuarter").value; 
var name = document.getElementById("newName").value;
var category = document.getElementById("newCategory").value; 
var total_points = document.getElementById("newTotal_Points").value; 

name = encodeURIComponent(name);
quarter = encodeURIComponent(quarter);
category = encodeURIComponent(category);
total_points = encodeURIComponent(total_points);
  
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
xmlhttp.open("GET","addTest.php?quarter="+quarter+"&name="+name+"&category="+category+"&total_points="+total_points,true); 
//addTest.php?quarter="+quarter+"&name="+name+"&category="+category+"&total_points="+total_points
xmlhttp.send(); 

toggleAddTest();
blankAddTest();
searchTests();
} 

function blankAddTest()
{
document.getElementById("newQuarter").value = "";
document.getElementById("newName").value = ""; 
document.getElementById("newCategory").value = ""; 
document.getElementById("newTotal_Points").value = ""; 
}

<!-- DELETE Test -->

function deleteTest(Testid)
{  
	var confirmDelete = confirm("All Test Scores for this Test will also be deleted.\nDo You Really Want To Delete This Test?");

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
		xmlhttp.open("GET","deleteTest.php?TestID="+Testid,true); 
		xmlhttp.send(); 

                document.getElementById("Test" + Testid).style.display = "none";
		//searchTests();
	}
}


<!-- EDIT Test -->

function goToEditView(editTestID)
{
        document.getElementById("noEditTestEditButton" + editTestID).style.display = "none";
        document.getElementById("noEditTestDeleteButton" + editTestID).style.display = "none";
        document.getElementById("noEditTestQuarter" + editTestID).style.display = "none";
        document.getElementById("noEditTestName" + editTestID).style.display = "none";
        document.getElementById("noEditTestCategory" + editTestID).style.display = "none";
        document.getElementById("noEditTestTotal_Points" + editTestID).style.display = "none";

        document.getElementById("editTestSaveButton" + editTestID).style.display = "inline-block";
        document.getElementById("editTestCancelButton" + editTestID).style.display = "inline-block";
        document.getElementById("editTestQuarter" + editTestID).style.display = "inline-block";
        document.getElementById("editTestName" + editTestID).style.display = "inline-block";
        document.getElementById("editTestCategory" + editTestID).style.display = "inline-block";
        document.getElementById("editTestTotal_Points" + editTestID).style.display = "inline-block";
}

function goToNoEditView(editTestID)
{
        document.getElementById("noEditTestEditButton" + editTestID).style.display = "inline-block";
        document.getElementById("noEditTestDeleteButton" + editTestID).style.display = "inline-block";
        document.getElementById("noEditTestQuarter" + editTestID).style.display = "inline-block";
        document.getElementById("noEditTestName" + editTestID).style.display = "inline-block";
        document.getElementById("noEditTestCategory" + editTestID).style.display = "inline-block";
        document.getElementById("noEditTestTotal_Points" + editTestID).style.display = "inline-block";

        document.getElementById("editTestSaveButton" + editTestID).style.display = "none";
        document.getElementById("editTestCancelButton" + editTestID).style.display = "none";
        document.getElementById("editTestQuarter" + editTestID).style.display = "none";
        document.getElementById("editTestName" + editTestID).style.display = "none";
        document.getElementById("editTestCategory" + editTestID).style.display = "none";
        document.getElementById("editTestTotal_Points" + editTestID).style.display = "none";

        var originalQuarter = document.getElementById("noEditTestQuarter" + editTestID).innerHTML;
        var originalName = document.getElementById("noEditTestName" + editTestID).innerHTML;
        var originalCategory = document.getElementById("noEditTestCategory" + editTestID).innerHTML;
        var originalTotal_Points = document.getElementById("noEditTestTotal_Points" + editTestID).innerHTML;

        document.getElementById("editTestQuarter" + editTestID).value = originalQuarter;
        document.getElementById("editTestName" + editTestID).value = originalName;
        document.getElementById("editTestCategory" + editTestID).value = originalCategory;
        document.getElementById("editTestTotal_Points" + editTestID).value = originalTotal_Points;
}

function saveEditTest(editTestID)
{ 
var name = document.getElementById("editTestName" + editTestID).value;
var quarter = document.getElementById("editTestQuarter" + editTestID).value; 
var category = document.getElementById("editTestCategory" + editTestID).value; 
var total_points = document.getElementById("editTestTotal_Points" + editTestID).value; 

name = encodeURIComponent(name);
quarter = encodeURIComponent(quarter);
category = encodeURIComponent(category);
total_points = encodeURIComponent(total_points);

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
        document.getElementById("Test" + editTestID).innerHTML=xmlhttp.responseText;
    } 
  } 
xmlhttp.open("GET","saveEditTest.php?quarter="+quarter+"&name="+name+"&category="+category+"&total_points="+total_points+"&editTestID="+editTestID,true); 
//Test code: marlsven.byethost18.com/tests/saveEditTest.php?quarter=99&name=ThisTest2&category=testCat&total_points=100&editTestID=15
xmlhttp.send(); 

//searchTests();
} 

</script>


<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><h2>1st Grade Tests</h2></div>

  <!-- Search Table -->
  <table class="table">
    <tr>
        <form class="navbar-form navbar-left" method="GET">
            <td>            
                <button id="addTestButton" type="button" class="btn btn-primary btn-lg" onclick="toggleAddTest()">
                    Add New Test
                </button>
            </td>
            <td><input type="text" class="form-control" id="quarter" placeholder="Quarter" onkeyup="searchTests()"></td>
            <td><input type="text" class="form-control" id="name" placeholder="Search Names" onkeyup="searchTests()"></td>
            <td><input type="text" class="form-control" id="category" placeholder="Search Categories" onkeyup="searchTests()"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </form>
    </tr>
  </table>

  <!-- Add Test Table -->
  <!-- <table id="addTestTable" class="table" style="display:none">
    <tr id="newTest">
        <form class="navbar-form navbar-left" method="GET">
            <td>
                <button type="button" class="btn btn-warning btn-lg" onclick="addTest()">
                    <span class="glyphicon glyphicon-plus"></span> Save
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default btn-lg" onclick="toggleAddTest()">
                    <span class="glyphicon glyphicon-remove"></span> Cancel
                </button>
            </td>
            <td><input type="text" class="form-control" id="newname" placeholder="name" ></td>
            <td><input type="text" class="form-control" id="newAuthor" placeholder="Author" ></td>
            <td><input type="text" class="form-control" id="newCategory" placeholder="Category" ></td>
            <td><input type="text" class="form-control" id="newFiction_Non-Fiction" placeholder="Fiction/Non-Fiction" ></td>
            <td><input type="text" class="form-control" id="newPicture_Phonics" placeholder="Picture/Phonics" ></td>
            <td><input type="text" class="form-control" id="newCopies" placeholder="# Of Copies" ></td>
        </form>
    </tr>
  </table> -->

<span id="TestResults"></span>
</div>

</div> <!-- END OF CONTAINER DIV -->
</body>

<?php
mysqli_close($con);
?>
</html>					