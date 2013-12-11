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
$queryAuthorsDistinct = "SELECT DISTINCT Author FROM Book
                          WHERE
                          (Title LIKE '%".$title."%') AND  
                          (Subject LIKE '%".$category."%')
                          ORDER BY Author";
$distinctAuthors = $con->query($queryAuthorsDistinct);

              $authorCounter = 0;
              while($authorRow = mysqli_fetch_assoc($distinctAuthors))
              {
                  $response .= "
                       <li><a id=\"searchauthor".$authorCounter."\" onclick=\"chooseSearch('".$authorCounter."','author')\">".$authorRow['Author']."</a></li>
                       ";
                  $authorCounter++;
              }

echo $response; 
?>