<?php 

include "../header.php"; 

// gets value sent over search form 
$test_id = $_GET['test_id']; 
$student_id = $_GET['student_id'];
$score = $_GET['score'];

$text_score_test = $_GET['text_score_test'];

// changes characters used in html to their equivalents, for example: < to &gt;
$test_id = htmlspecialchars($test_id);
$student_id = htmlspecialchars($student_id);
$score = htmlspecialchars($score);

// changes characters used in html to their equivalents, for example: < to &gt;
$test_id = addslashes($test_id);
$student_id = addslashes($student_id);
$score = addslashes($score);

// makes sure nobody uses SQL injection            
//$studentid = mysqli_real_escape_string($studentid);

//Get the test name
$testQuery = "SELECT * FROM Test WHERE test_id ='".$test_id."'";
$testQueryResult = $con->query($testQuery);

$testName = "No Test Name found for this test";
$testCategory = "No Test Category found for this test";
$testTotalPoints = "No Total Points found for this test";

if($testQueryResult->num_rows == 1)
{       
    while($row = $testQueryResult->fetch_array())
    {
        $testName = $row['name'];
        $testCategory = $row['category'];
        $testTotalPoints = $row['total_points'];
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

//Delete the old score record
$queryDeleteOld = "DELETE FROM Students_Tests
                   WHERE (student_id =".$student_id."
                   AND test_id =".$test_id.")";
if(!$con->query($queryDeleteOld))
{
    echo "Delete of the old score failed: (" . $con->errno . ") " . $con->error;
}

$query = "";

//Insert a new Students_Tests record to save the new score
if($text_score_test == "false")
{
    $query = "INSERT INTO Students_Tests (student_id, test_id, score)
          VALUES('".$student_id."', '".$test_id."', '".$score."')
             ";
}
else
{
    $query = "INSERT INTO Students_Tests (student_id, test_id, text_score)
          VALUES('".$student_id."', '".$test_id."', '".$score."')
             ";
}


if(!$con->query($query))
{
    echo "UPDATE failed: (" . $con->errno . ") " . $con->error;
}
else
{
$response = "";

$allStudentsQuery = "SELECT Student.student_id, Student.display_id, Student.first_name, Student.last_name, Student.teacher_name,
                     Students_Tests.student_test_id, Students_Tests.test_id, Students_Tests.score, Students_Tests.text_score
                     FROM Student 
                     LEFT JOIN Students_Tests 
                     ON  (Students_Tests.student_id = Student.student_id)
                     WHERE (test_id = ".$test_id." AND Students_Tests.student_id = ".$student_id.")
                     ORDER BY display_id";

$raw_results = $con->query($allStudentsQuery);

if($raw_results->num_rows > 0)
{
    while($row = $raw_results->fetch_array())
    {
        $response .=
                "
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
                </td>";

              if($text_score_test == "false")
              {
              $response .= " 

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
              $response .= "
                <td>
                    <div id=\"noEditScoreScore".$row['student_id']."\">".$row['text_score']."</div>
                    <input style=\"display:none\" id=\"editScoreScore".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Score\" value=\"".$row['text_score']."\">
                </td>
              ";
              }
    }
}
else
{$response = "Error: No record found for this student and this test";}

echo $response;
    //echo "Student " . $studentid . " has been updated.";
}

?>