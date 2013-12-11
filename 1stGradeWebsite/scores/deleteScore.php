<?php 

include "../header.php"; 

// gets value sent over search form 
$test_id = $_GET['test_id']; 
$student_id = $_GET['student_id'];
$text_score_test = $_GET['text_score_test'];

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
       
// changes characters used in html to their equivalents, for example: < to &gt;
//$studentid = htmlspecialchars($studentid);
 
// makes sure nobody uses SQL injection            
//$studentid = mysqli_real_escape_string($studentid);

//Delete the old score record
$queryDeleteOld = "DELETE FROM Students_Tests
                   WHERE (student_id =".$student_id."
                   AND test_id =".$test_id.")";

$response = "Error A: Error in searching for the student<br>";

if(!$con->query($queryDeleteOld))
{
    echo "Delete of the old score failed: (" . $con->errno . ") " . $con->error;
}
else
{

    $querySearch = "SELECT * FROM Student WHERE student_id =".$student_id;

    $raw_results = $con->query($querySearch);

            while($row = $raw_results->fetch_array())
            {
                $response = "";
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
                
            }//END OF WHILE LOOP

}
echo $response;


?>