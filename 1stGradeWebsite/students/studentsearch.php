<?php 

include "../header.php"; 

$response = ""; 

// gets value sent over search form 
$display_id = $_GET['display_id']; 
$first_name = $_GET['first_name']; 
$last_name = $_GET['last_name']; 

$editStudentID = $_GET['editStudentID'];  
       
// changes characters used in html to their equivalents, for example: < to &gt;
$display_id = htmlspecialchars($display_id);
$first_name = htmlspecialchars($first_name);
$last_name = htmlspecialchars($last_name); 

// Adds slashes to quotes and other not-friendly sql characters
$display_id = addslashes($display_id);
$first_name = addslashes($first_name);
$last_name = addslashes($last_name);  

// makes sure nobody uses SQL injection            
//$display_id = mysqli_real_escape_string($display_id);
//$first_name = mysqli_real_escape_string($first_name);
//$last_name = mysqli_real_escape_string($last_name); 

//$query = "SELECT * FROM Student";
$query = "SELECT * FROM Student WHERE 
                          (display_id LIKE '%".$display_id."%') AND 
                          (first_name LIKE '%".$first_name."%') AND 
                          (last_name LIKE '%".$last_name."%') ORDER BY Display_id";



$raw_results = $con->query($query);

$response .= "<table class=\"table table-hover\">

    <tr style = \"font-weight: bold\">
        <td>".$raw_results->num_rows." Students Found</td>
        <td>ID</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td></td>
    </tr>";

$response .="
    <tr style=\"display:none\" id=\"newStudent\">
        <form class=\"navbar-form navbar-left\" method=\"GET\">
            <td>
                <button type=\"button\" class=\"btn btn-warning btn-lg\" onclick=\"addStudent()\">
                    <span class=\"glyphicon glyphicon-plus\"></span> Save New Student
                </button>
                <button type=\"button\" class=\"btn btn-default btn-lg\" onclick=\"toggleAddStudent()\">
                    <span class=\"glyphicon glyphicon-remove\"></span> Cancel 
                </button>
            </td>
            <td><input type=\"text\" class=\"form-control\" id=\"newDisplay_id\" placeholder=\"ID\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newFirst_name\" placeholder=\"First Name\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newLast_name\" placeholder=\"Last Name\" ></td>
            <td></td>
        </form>
    </tr>";

if($raw_results->num_rows > 0)
{       
    while($row = $raw_results->fetch_array())
    {
             $response .=  
             "<tr id=\"student".$row['student_id']."\">
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
            </tr>";
    }
}
else
{ // if there are no matching rows do following 
    $response .= "<tr style = \"font-weight: bold\">
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

$response .= "</table>";

echo $response; 
?>	