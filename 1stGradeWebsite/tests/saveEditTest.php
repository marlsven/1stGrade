<?php 

include "../header.php"; 

// gets value sent over search form 
$quarter = $_GET['quarter']; 
$name = $_GET['name'];
$category = $_GET['category'];
$total_points = $_GET['total_points'];

$testid = $_GET['editTestID']; 
       
// changes characters used in html to their equivalents, for example: < to &gt;
$quarter = htmlspecialchars($quarter);
$name = htmlspecialchars($name);
$category = htmlspecialchars($category);  
$total_points = htmlspecialchars($total_points);

// changes characters used in html to their equivalents, for example: < to &gt;
$quarter = addslashes($quarter);
$name = addslashes($name);
$category = addslashes($category); 
$total_points = addslashes($total_points);  
 
// makes sure nobody uses SQL injection            
//$testid = mysqli_real_escape_string($testid);

$query = "UPDATE  Test SET  quarter =  '$quarter',
name =  '$name',
category =  '$category',
`total_points` =  '$total_points'
WHERE  test_id = '$testid'";

if(!$con->query($query))
{
    echo "UPDATE failed: (" . $con->errno . ") " . $con->error;
}
else
{
$response = "";

$query2 = "SELECT * FROM Test WHERE test_id = '$testid'";

$raw_results = $con->query($query2);

if($raw_results->num_rows > 0)
{
    while($row = $raw_results->fetch_array())
    {
        $response .=
                "
                 <td>
                    <button type=\"button\" class=\"btn btn-success\" onclick=\"OpenInNewTab('http://www.marlsven.byethost18.com/scores/index.php?test_id=".$row['test_id']."')\">
                        <span class=\"glyphicon glyphicon-plus\"></span> Add Scores
                    </button>
                 </td>
                 <td>
                    <button type=\"button\" id=\"noEditTestEditButton".$row['test_id']."\" class=\"btn btn-info btn-lg\" onclick=\"goToEditView(".$row['test_id'].")\">
                        <span class=\"glyphicon glyphicon-pencil\"></span> Edit
                    </button>
                    
                    <button style=\"display:none\" type=\"button\" id=\"editTestSaveButton".$row['test_id']."\" class=\"btn btn-warning btn-lg\" onclick=\"saveEditTest(".$row['test_id'].")\">
                        <span class=\"glyphicon glyphicon-plus\"></span> Save
                    </button>
                </td>
                <td>
                    <button type=\"button\" id=\"noEditTestDeleteButton".$row['test_id']."\" class=\"btn btn-default btn-lg\" onclick=\"deleteTest(".$row['test_id'].")\">
                        <span class=\"glyphicon glyphicon-trash\"></span> Delete
                    </button>
 
                    <button style=\"display:none\" type=\"button\" id=\"editTestCancelButton".$row['test_id']."\" class=\"btn btn-default btn-lg\" onclick=\"goToNoEditView(".$row['test_id'].")\">
                        <span class=\"glyphicon glyphicon-remove\"></span> Cancel
                    </button>
                </td>
                <td>
                    <div id=\"noEditTestQuarter".$row['test_id']."\" >".$row['quarter']."</div> 
                    <input style=\"display:none\" id=\"editTestQuarter".$row['test_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Quarter\" value=\"".$row['quarter']."\">
                </td>
                <td>
                    <div id=\"noEditTestName".$row['test_id']."\">".$row['name']."</div>
                    <input style=\"display:none\" id=\"editTestName".$row['test_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Name\" value=\"".$row['name']."\">
                </td>
                <td>
                    <div id=\"noEditTestCategory".$row['test_id']."\">".$row['category']."</div>
                    <input style=\"display:none\" id=\"editTestCategory".$row['test_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Category\" value=\"".$row['category']."\">
                </td>
                <td>
                    <div id=\"noEditTestTotal_Points".$row['test_id']."\">".$row['total_points']."</div>
                    <input style=\"display:none\" id=\"editTestTotal_Points".$row['test_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Total Points\" value=\"".$row['total_points']."\">
                </td>
                ";
    }
}

echo $response;
    //echo "test " . $testid . " has been updated.";
}
?>