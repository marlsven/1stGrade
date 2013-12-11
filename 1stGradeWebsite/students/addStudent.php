<?php 

include "../header.php"; 

$response = ""; 

// gets value sent over search form 
$display_id = $_GET['display_id']; 
$first_name = $_GET['first_name']; 
$last_name = $_GET['last_name'];  
    
// changes characters used in html to their equivalents, for example: < to &gt;
$display_id = htmlspecialchars($display_id);
$first_name = htmlspecialchars($first_name);
$last_name = htmlspecialchars($last_name); 

// Adds slashes to quotes and other not-friendly sql characters
$display_id = addslashes($display_id);
$first_name = addslashes($first_name);
$last_name = addslashes($last_name); 

// makes sure nobody uses SQL injection            
//$title = mysqli_real_escape_string($title);
//$author = mysqli_real_escape_string($author);
//$category = mysqli_real_escape_string($category); 

echo "php works";
echo $display_id;
echo $first_name;
echo $last_name;

$query = "INSERT INTO  Student 
VALUES (
0, '$display_id',  '$first_name',  '$last_name', 'Laurel Dean Karlsven'
)";

if(!$con->query($query))
{
    echo "INSERT failed: (" . $con->errno . ") " . $con->error;
}
echo "Newest student_id = ",$con->insert_id;
?>