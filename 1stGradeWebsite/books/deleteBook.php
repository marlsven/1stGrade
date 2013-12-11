<?php 

include "../header.php"; 

// gets value sent over search form 
$bookid = $_GET['bookID'];  
       
// changes characters used in html to their equivalents, for example: < to &gt;
//$bookid = htmlspecialchars($bookid);
 
// makes sure nobody uses SQL injection            
//$bookid = mysqli_real_escape_string($bookid);

$query = "DELETE FROM Book WHERE Book_ID = '$bookid'";

if(!$con->query($query))
{
    echo "DELETE failed: (" . $con->errno . ") " . $con->error;
}
else
{
    echo "Book " . $bookid . " has been deleted.";
}
?>