<?php 

include "../header.php"; 

// gets value sent over search form 
$display_id = $_GET['display_id']; 
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];

$student_id = $_GET['editStudentID']; 
       
// changes characters used in html to their equivalents, for example: < to &gt;
$display_id = htmlspecialchars($display_id);
$first_name = htmlspecialchars($first_name);
$last_name = htmlspecialchars($last_name); 

// Adds slashes to quotes and other not-friendly sql characters
$display_id = addslashes($display_id);
$first_name = addslashes($first_name);
$last_name = addslashes($last_name); 
 
// makes sure nobody uses SQL injection            
//$studentid = mysqli_real_escape_string($studentid);

$query = "UPDATE  Student SET  display_id =  '$display_id',
first_name =  '$first_name',
last_name =  '$last_name'
WHERE  student_id = '$student_id'";

if(!$con->query($query))
{
    echo "UPDATE failed: (" . $con->errno . ") " . $con->error;
}
else
{
$response = "";

$query2 = "SELECT * FROM Student WHERE student_id = '$student_id'";

$raw_results = $con->query($query2);

if($raw_results->num_rows > 0)
{
    while($row = $raw_results->fetch_array())
    {
        $response .=
                "
                 <td>
                    <button type=\"button\" id=\"noEditStudentEditButton".$row['student_id']."\" class=\"btn btn-info btn-lg\" onclick=\"goToEditView(".$row['student_id'].")\">
                        <span class=\"glyphicon glyphicon-pencil\"></span> Edit
                    </button>
                    
                    <button style=\"display:none\" type=\"button\" id=\"editStudentSaveButton".$row['student_id']."\" class=\"btn btn-warning btn-lg\" onclick=\"saveEditStudent(".$row['student_id'].")\">
                        <span class=\"glyphicon glyphicon-plus\"></span> Save
                    </button>

                    <button type=\"button\" id=\"noEditStudentDeleteButton".$row['student_id']."\" class=\"btn btn-default btn-lg\" onclick=\"deleteStudent(".$row['student_id'].")\">
                        <span class=\"glyphicon glyphicon-trash\"></span> Delete
                    </button>
 
                    <button style=\"display:none\" type=\"button\" id=\"editStudentCancelButton".$row['student_id']."\" class=\"btn btn-default btn-lg\" onclick=\"goToNoEditView(".$row['student_id'].")\">
                        <span class=\"glyphicon glyphicon-remove\"></span> Cancel
                    </button>
                </td>
                <td>
                    <div id=\"noEditStudentDisplay_id".$row['student_id']."\" >".$row['display_id']."</div> 
                    <input style=\"display:none\" id=\"editStudentDisplay_id".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"ID\" value=\"".$row['display_id']."\">
                </td>
                <td>
                    <div id=\"noEditStudentFirst_name".$row['student_id']."\">".$row['first_name']."</div>
                    <input style=\"display:none\" id=\"editStudentFirst_name".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"First Name\" value=\"".$row['first_name']."\">
                </td>
                <td>
                    <div id=\"noEditStudentLast_name".$row['student_id']."\">".$row['last_name']."</div>
                    <input style=\"display:none\" id=\"editStudentLast_name".$row['student_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Last Name\" value=\"".$row['last_name']."\">
                </td>

                <td>
			<!-- Single button -->
			<div class=\"btn-group\">
			        <button type=\"button\" class=\"btn btn-success dropdown-toggle\" data-toggle=\"dropdown\">
				    View Grade Reports <span class=\"caret\"></span>
				</button>
		            <ul class=\"dropdown-menu\" role=\"menu\">
				<li> <a onclick=\"OpenInNewTab('http://www.marlsven.byethost18.com/reports?quarter=1&studentID=".$row['student_id']."');\">Quarter 1</a></li>
				<li> <a onclick=\"OpenInNewTab('http://www.marlsven.byethost18.com/reports?quarter=2&studentID=".$row['student_id']."');\">Quarter 2</a></li>
				<li> <a onclick=\"OpenInNewTab('http://www.marlsven.byethost18.com/reports?quarter=3&studentID=".$row['student_id']."');\">Quarter 3</a></li>
				<li> <a onclick=\"OpenInNewTab('http://www.marlsven.byethost18.com/reports?quarter=4&studentID=".$row['student_id']."');\">Quarter 4</a></li>
			    </ul>
			</div>
                </td>
                ";
    }
}

echo $response;
    //echo "Student " . $studentid . " has been updated.";
}
?>