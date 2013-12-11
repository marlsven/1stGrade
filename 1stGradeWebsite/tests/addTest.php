<?php 

include "../header.php"; 

$response = ""; 

// gets value sent over search form 
$quarter = $_GET['quarter']; 
$name = $_GET['name']; 
$category = $_GET['category'];   
$total_points = $_GET['total_points']; 
       
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
//$quarter = mysqli_real_escape_string($quarter);
//$name = mysqli_real_escape_string($name);
//$category = mysqli_real_escape_string($category); 
//$total_points = mysqli_real_escape_string($total_points);

echo "php works";
echo $quarter;
echo $name;
echo $category;
echo $total_points;

$query = "INSERT INTO  Test 
VALUES (
0,  '$name',  '$total_points',  '$quarter',  '$category'
)";

if(!$con->query($query))
{
    echo "INSERT failed: (" . $con->errno . ") " . $con->error;
}
echo "Newest user id = ",$con->insert_id;
?>