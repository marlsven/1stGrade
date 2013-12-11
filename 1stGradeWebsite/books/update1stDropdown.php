<?php 

include "../header.php"; 

$response = ""; 

// gets value sent over search form 
$title = $_GET['title']; 
$author = $_GET['author']; 
$category = $_GET['category'];  
       
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
$queryTitlesDistinct = "SELECT DISTINCT Title FROM Book
                          WHERE
                          (Author LIKE '%".$author."%') AND 
                          (Subject LIKE '%".$category."%')
                          ORDER BY Title";

$distinctTitles = $con->query($queryTitlesDistinct);

              $titleCounter = 0;
              while($titleRow = mysqli_fetch_assoc($distinctTitles))
              {
                  $response .= "
                       <li><a id=\"searchtitle".$titleCounter."\" onclick=\"chooseSearch('".$titleCounter."','title')\">".$titleRow['Title']."</a></li>
                       ";
                  $titleCounter++;
              }

echo $response; 
?>