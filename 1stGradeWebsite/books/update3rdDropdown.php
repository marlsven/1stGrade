<?php 

include "../header.php"; 

$response = ""; 

// gets value sent over search form 
$title = $_GET['title']; 
$author = $_GET['author']; 
$category = $_GET['category']; 

$editBookID = $_GET['editBookID'];  
       
// changes characters used in html to their equivalents, for example: < to &gt;
$title = htmlspecialchars($title);
$author = htmlspecialchars($author);
$category = htmlspecialchars($category); 
//$fnf = htmlspecialchars($fnf);
//$picphon = htmlspecialchars($picphon);
//$copies = htmlspecialchars($copies);  

//Allow quotes in an input 
$title = addslashes($title);
$author = addslashes($author);
$category = addslashes($category);
//$fnf = addslashes($fnf);
//$picphon = addslashes($picphon);
//$copies = addslashes($copies);

// makes sure nobody uses SQL injection            
//$title = mysqli_real_escape_string($title);
//$author = mysqli_real_escape_string($author);
//$category = mysqli_real_escape_string($category); 

//Get unique titles
$queryCategoriesDistinct = "SELECT DISTINCT Subject FROM Book
                          WHERE
                          (Title LIKE '%".$title."%') AND 
                          (Author LIKE '%".$author."%')
                          ORDER BY Subject";
$distinctCategories = $con->query($queryCategoriesDistinct);

              $categoryCounter = 0;
              while($categoryRow = mysqli_fetch_assoc($distinctCategories))
              {
                  $response .= "
                       <li><a id=\"searchcategory".$categoryCounter."\" onclick=\"chooseSearch('".$categoryCounter."','category')\">".$categoryRow['Subject']."</a></li>
                       ";
                  $categoryCounter++;
              }

echo $response; 
?>