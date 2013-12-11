<?php 

include "../header.php"; 

// gets value sent over search form 
$Testid = $_GET['TestID'];  
       
// changes characters used in html to their equivalents, for example: < to &gt;
//$Testid = htmlspecialchars($Testid);
 
// makes sure nobody uses SQL injection            
//$Testid = mysqli_real_escape_string($Testid);

$queryDeleteScores = "DELETE FROM Students_Tests WHERE test_id = '$Testid'";
if(!$con->query($queryDeleteScores))
{
    echo "DELETE of scores for Test " . $Testid . " failed: (" . $con->errno . ") " . $con->error;
}
else
{
    echo "Students_Tests (scores) for Test " . $Testid . " have been deleted.";
}
$query = "DELETE FROM Test WHERE test_id = '$Testid'";

if(!$con->query($query))
{
    echo "DELETE failed: (" . $con->errno . ") " . $con->error;
}
else
{
    echo "Test " . $Testid . " has been deleted.";
}
?>