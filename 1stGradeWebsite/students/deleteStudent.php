<?php 

include "../header.php"; 

// gets value sent over search form 
$student_id = $_GET['studentID'];  
       
// changes characters used in html to their equivalents, for example: < to &gt;
//$studentid = htmlspecialchars($student_id);
 
// makes sure nobody uses SQL injection            
//$studentid = mysqli_real_escape_string($student_id);

//Delete all students_tests records (scores) associated with this student

$queryDeleteScores = "DELETE FROM Students_Tests WHERE student_id = '$student_id'";
if(!$con->query($queryDeleteScores))
{
    echo "DELETE of scores for Student " . $student_id . " failed: (" . $con->errno . ") " . $con->error;
}
else
{
    echo "Students_Tests (scores) for Student " . $student_id . " have been deleted.";
}

$query = "DELETE FROM Student WHERE student_id = '$student_id'";

if(!$con->query($query))
{
    echo "DELETE of Student " . $student_id . " failed: (" . $con->errno . ") " . $con->error;
}
else
{
    echo "Student " . $student_id . " has been deleted.";
}
?>