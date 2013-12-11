<?php 

include "../header.php"; 

$response = ""; 

// gets value sent over search form 
$title = $_GET['title']; 
$author = $_GET['author']; 
$category = $_GET['category'];   
$fnf = $_GET['fnf']; 
$picphon = $_GET['picphon']; 
$copies = $_GET['copies']; 
       
// changes characters used in html to their equivalents, for example: < to &gt;
$title = htmlspecialchars($title);
$author = htmlspecialchars($author);
$category = htmlspecialchars($category); 
$fnf = htmlspecialchars($fnf);
$picphon = htmlspecialchars($picphon);
$copies = htmlspecialchars($copies);  

//Allow quotes in an input 
$title = addslashes($title);
$author = addslashes($author);
$category = addslashes($category);
$fnf = addslashes($fnf);
$picphon = addslashes($picphon);
$copies = addslashes($copies);

// makes sure nobody uses SQL injection 
//$title = mysql_real_escape_string($title);
//$author = mysql_real_escape_string($author);
//$category = mysql_real_escape_string($category);
//$fnf = mysql_real_escape_string($fnf);
//$picphon = mysql_real_escape_string($picphon);
//$copies = mysql_real_escape_string($copies);

echo "php works";
echo $title;
echo $author;
echo $category;
echo $fnf;
echo $picphon;
echo $copies;


$query = "INSERT INTO  Book 
VALUES (
'$category',  '$title',  '$author',  '$fnf',  '$picphon',  '$copies',  'Laurel Dean Karlsven', NULL
)";

if(!$con->query($query))
{
    echo "INSERT failed: (" . $con->errno . ") " . $con->error;
}
echo "Newest user id = ",$con->insert_id;
?>