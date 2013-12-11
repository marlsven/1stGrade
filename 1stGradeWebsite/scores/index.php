<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>

<?php
require "../header.php";
?>

<?php
// gets value sent over search form 
$test_id = $_GET['test_id']; 

// changes characters used in html to their equivalents, for example: < to &gt;
$test_id = htmlspecialchars($test_id);

// changes characters used in html to their equivalents, for example: < to &gt;
$test_id = addslashes($test_id);
 
//Get the test name
$testQuery = "SELECT * FROM Test WHERE test_id ='".$test_id."'";
$testQueryResult = $con->query($testQuery);

$testName = "No Test Name found for this test";
$testCategory = "No Test Category found for this test";
$testTotalPoints = "No Total Points found for this test";

$text_score_test = "false";

if($testQueryResult->num_rows == 1)
{       
    while($row = $testQueryResult->fetch_array())
    {
        $testName = $row['name'];
        $testCategory = $row['category'];

        if($row['total_points'] == 0)
        {
            $text_score_test = "true";
            $testTotalPoints = "None";
        }
        else
        {
            $testTotalPoints = $row['total_points'];
        }
    }
}
if($testQueryResult->num_rows == 0)
{
    $testName = "Error: Test Not Found";
}
if($testQueryResult->num_rows > 1)
{
    $testName = "Error: Multiple Tests found for this Test ID";
}
?>

<script> 

<!-- EDIT SCORE -->

function goToEditView(editScoreStudentID)
{
        document.getElementById("noEditScoreEditButton" + editScoreStudentID).style.display = "none";
        document.getElementById("noEditScoreDeleteButton" + editScoreStudentID).style.display = "none";
        //document.getElementById("noEditScoreDisplay_ID" + editScoreStudentID).style.display = "none";
        document.getElementById("noEditScoreScore" + editScoreStudentID).style.display = "none";
        //document.getElementById("noEditScorePercent" + editScoreStudentID).style.display = "none";

        document.getElementById("editScoreSaveButton" + editScoreStudentID).style.display = "inline-block";
        document.getElementById("editScoreCancelButton" + editScoreStudentID).style.display = "inline-block";
        //document.getElementById("editScoreDisplay_ID" + editScoreStudentID).style.display = "inline-block";
        document.getElementById("editScoreScore" + editScoreStudentID).style.display = "inline-block";
        //document.getElementById("editScorePercent" + editScoreStudentID).style.display = "inline-block";
}

function goToNoEditView(editScoreStudentID)
{
        document.getElementById("noEditScoreEditButton" + editScoreStudentID).style.display = "inline-block";
        document.getElementById("noEditScoreDeleteButton" + editScoreStudentID).style.display = "inline-block";
        //document.getElementById("noEditScoreDisplay_ID" + editScoreStudentID).style.display = "inline-block";
        document.getElementById("noEditScoreScore" + editScoreStudentID).style.display = "inline-block";
        //document.getElementById("noEditScorePercent" + editScoreStudentID).style.display = "inline-block";

        document.getElementById("editScoreSaveButton" + editScoreStudentID).style.display = "none";
        document.getElementById("editScoreCancelButton" + editScoreStudentID).style.display = "none";
        //document.getElementById("editScoreDisplay_ID" + editScoreStudentID).style.display = "none";
        document.getElementById("editScoreScore" + editScoreStudentID).style.display = "none";
        //document.getElementById("editScorePercent" + editScoreStudentID).style.display = "none";

        //var originalDisplayID = document.getElementById("noEditScoreDisplay_ID" + editScoreStudentID).innerHTML;
        var originalScore = document.getElementById("noEditScoreScore" + editScoreStudentID).innerHTML;
        //var originalPercent = document.getElementById("noEditScorePercent" + editScoreStudentID).innerHTML;

        //document.getElementById("editScoreDisplay_ID" + editScoreStudentID).value = originalDisplayID;
        document.getElementById("editScoreScore" + editScoreStudentID).value = originalScore;
        //document.getElementById("editScorePercent" + editScoreStudentID).value = originalPercent;
}

function saveEditScore(editStudent_ID)
{ 
var text_score_test = <?php echo $text_score_test; ?>;
var test_id = <?php echo $test_id; ?>; 
var student_id = document.getElementById("editStudent_ID" + editStudent_ID).value;
var score = document.getElementById("editScoreScore" + editStudent_ID).value;

score = encodeURIComponent(score);

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
        document.getElementById("student" + editStudent_ID).innerHTML=xmlhttp.responseText;
    } 
  } 
xmlhttp.open("GET","saveEditScore.php?test_id="+test_id+"&student_id="+student_id+"&score="+score+"&text_score_test="+text_score_test,true); 
//Test code: http://www.marlsven.byethost18.com/scores/saveEditScore.php?test_id=4&student_id=9&score=5 
xmlhttp.send(); 
} 


<!-- DELETE SCORE -->

function deleteScore(student_id)
{  
	var confirmDelete = confirm("Do You Really Want To Delete This Score?");

        var text_score_test = <?php echo $text_score_test; ?>;

        var test_id = <?php echo $test_id; ?>;

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
                                document.getElementById("student" + student_id).innerHTML=xmlhttp.responseText;
			} 
		  } 
		xmlhttp.open("GET","deleteScore.php?test_id="+test_id+"&student_id="+student_id+"&text_score_test="+text_score_test,true); 
		xmlhttp.send();                 
	}
}

</script>

</head>

<body>

<div class="container">

<?php
// gets value sent over search form 
$test_id = $_GET['test_id']; 
       
// changes characters used in html to their equivalents, for example: < to &gt;
$test_id = htmlspecialchars($test_id);

// changes characters used in html to their equivalents, for example: < to &gt;
$test_id = addslashes($test_id);

// makes sure nobody uses SQL injection            
//$test_id = mysqli_real_escape_string($test_id); 

$allStudentsTestsQuery = "SELECT Student.student_id, Student.display_id, Student.first_name, Student.last_name, Student.teacher_name,
                     Students_Tests.student_test_id, Students_Tests.test_id, Students_Tests.score, Students_Tests.text_score
                     FROM Student 
                     LEFT JOIN Students_Tests 
                     ON  (Students_Tests.student_id = Student.student_id AND Students_Tests.test_id = ".$test_id.")
                     ORDER BY display_id";

//echo $allStudentsTestsQuery;

$allStudentsTests = $con->query($allStudentsTestsQuery);

echo "

    <div class=\"panel panel-default\">
      <!-- Default panel contents -->
      <div class=\"panel-heading\"><h2>".$testName."</h2>
                                   <h4>Category: ".$testCategory."</h4>";

                                   if($text_score_test == "false")
                                   {
                                       echo "
                                            <h4>Total Points Possible: ".$testTotalPoints."</h4>
                                            ";
                                   } 

echo "
      </div>

    <table class=\"table table-hover\">

    <tr style = \"font-weight: bold\">
        <td></td>
        <td>ID</td>
        <td>First Name</td>
        <td>Last Name</td>
     ";

if($text_score_test == "false")
{
    echo "<td>Score / ".$testTotalPoints."</td>";
}
else
{
    echo "<td>Score</td>";
}

if($text_score_test == "false")
{
echo "
        <td>Percent</td>
    </tr>";
}

if($allStudentsTests->num_rows > 0)
{       
    while($row = $allStudentsTests->fetch_array())
    {

         echo  
             "<tr id=\"student".$row['student_id']."\">
                <input style=\"display:none\" id=\"editStudent_ID".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"ID\" value=\"".$row['student_id']."\">
                <td>
                    <button type=\"button\" id=\"noEditScoreEditButton".$row['student_id']."\" class=\"btn btn-info btn-lg\" onclick=\"goToEditView(".$row['student_id'].")\">
                        <span class=\"glyphicon glyphicon-pencil\"></span> Edit
                    </button> 

                    <button type=\"button\" id=\"noEditScoreDeleteButton".$row['student_id']."\" class=\"btn btn-default btn-lg\" onclick=\"deleteScore(".$row['student_id'].")\">
                        <span class=\"glyphicon glyphicon-trash\"></span> Delete
                    </button>                  

                    <button style=\"display:none\" type=\"button\" id=\"editScoreSaveButton".$row['student_id']."\" class=\"btn btn-warning btn-lg\" onclick=\"saveEditScore(".$row['student_id'].")\">
                        <span class=\"glyphicon glyphicon-plus\"></span> Save
                    </button>
 
                    <button style=\"display:none\" type=\"button\" id=\"editScoreCancelButton".$row['student_id']."\" class=\"btn btn-default btn-lg\" onclick=\"goToNoEditView(".$row['student_id'].")\">
                        <span class=\"glyphicon glyphicon-remove\"></span> Cancel
                    </button>
                </td>
                <td>
                    <div id=\"noEditScoreDisplay_ID".$row['student_id']."\" >".$row['display_id']."</div> 
                    <input style=\"display:none\" id=\"editScoreDisplay_ID".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"ID\" value=\"".$row['display_id']."\">
                </td>
                <td>
                    <div id=\"noEditScoreFirst_Name".$row['student_id']."\" >".$row['first_name']."</div> 
                    <input style=\"display:none\" id=\"editScoreFirst_Name".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"First Name\" value=\"".$row['first_name']."\">
                </td>
                <td>
                    <div id=\"noEditScoreLast_Name".$row['student_id']."\" >".$row['last_name']."</div> 
                    <input style=\"display:none\" id=\"editScoreLast_Name".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Last Name\" value=\"".$row['last_name']."\">
                </td>
                ";

              if($text_score_test == "false")
              {
              echo " 

                <td>
                    <div id=\"noEditScoreScore".$row['student_id']."\">".$row['score']."</div>
                    <input style=\"display:none\" id=\"editScoreScore".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Score\" value=\"".$row['score']."\">
                </td>
                <td>
                    <!-- <div id=\"noEditScorePercent".$row['student_id']."\">".sprintf("%.0f%%", ($row['score']/$testTotalPoints) * 100)."</div> -->
                    <div id=\"noEditScorePercent".$row['student_id']."\">".floor(($row['score']/$testTotalPoints) * 100)."%</div>
                    <input style=\"display:none\" id=\"editScorePercent".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"%\" value=\"".sprintf("%.2f%%", ($row['score']/$testTotalPoints) * 100)."\">
                </td>
              ";
              }
              else
              {
              echo "
                <td>
                    <div id=\"noEditScoreScore".$row['student_id']."\">".$row['text_score']."</div>
                    <input style=\"display:none\" id=\"editScoreScore".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Score\" value=\"".$row['text_score']."\">
                </td>
              ";
              }

              echo "
                </tr>";
    }
}
else
{ // if there are no matching rows do following 
    echo "<tr style = \"font-weight: bold\">
          <td>
             <h2>Nothing to see here</h2>
          </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>";
}

echo "</table>";

echo "</div>"; //END OF panel panel-default div
?>

</div>

</div> <!-- END OF CONTAINER DIV -->
</body>

<?php
mysqli_close($con);
?>
</html>					