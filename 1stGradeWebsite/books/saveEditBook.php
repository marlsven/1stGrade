<?php 

include "../header.php"; 

// gets value sent over search form 
$title = $_GET['title']; 
$author = $_GET['author'];
$category = $_GET['category'];
$fnf = $_GET['fnf'];
$picPhon = $_GET['picPhon'];
$copies = $_GET['copies'];
$bookid = $_GET['editBookID']; 

// changes characters used in html to their equivalents, for example: < to &gt;
$title = htmlspecialchars($title);
$author = htmlspecialchars($author);
$category = htmlspecialchars($category); 
$fnf = htmlspecialchars($fnf);
$picPhon = htmlspecialchars($picPhon);
$copies = htmlspecialchars($copies);  

//Allow quotes in an input 
$title = addslashes($title);
$author = addslashes($author);
$category = addslashes($category);
$fnf = addslashes($fnf);
$picPhon = addslashes($picPhon);
$copies = addslashes($copies);
     
// changes characters used in html to their equivalents, for example: < to &gt;
//$bookid = htmlspecialchars($bookid);
 
// makes sure nobody uses SQL injection            
//$bookid = mysqli_real_escape_string($bookid);

$query = "UPDATE  Book SET  Subject =  '$category',
Title =  '$title',
Author =  '$author',
`Fiction_Non-Fiction` =  '$fnf',
Picture_Phonics =  '$picPhon',
Copies =  '$copies' 
WHERE  Book_ID = '$bookid'";

if(!$con->query($query))
{
    echo "UPDATE failed: (" . $con->errno . ") " . $con->error;
}
else
{
$response = "";

$query2 = "SELECT * FROM Book WHERE Book_ID = '$bookid'";

$raw_results = $con->query($query2);

if($raw_results->num_rows > 0)
{
    while($row = $raw_results->fetch_array())
    {
        $response .=
                "
                 <td>
                    <button type=\"button\" id=\"noEditBookEditButton".$row[Book_ID]."\" class=\"btn btn-info btn-lg\" onclick=\"goToEditView(".$row[Book_ID].")\">
                        <span class=\"glyphicon glyphicon-pencil\"></span> Edit
                    </button>
                    
                    <button style=\"display:none\" type=\"button\" id=\"editBookSaveButton".$row[Book_ID]."\" class=\"btn btn-warning btn-lg\" onclick=\"saveEditBook(".$row[Book_ID].")\">
                        <span class=\"glyphicon glyphicon-plus\"></span> Save
                    </button>
                </td>
                <td>
                    <button type=\"button\" id=\"noEditBookDeleteButton".$row[Book_ID]."\" class=\"btn btn-default btn-lg\" onclick=\"deleteBook(".$row[Book_ID].")\">
                        <span class=\"glyphicon glyphicon-trash\"></span> Delete
                    </button>
 
                    <button style=\"display:none\" type=\"button\" id=\"editBookCancelButton".$row[Book_ID]."\" class=\"btn btn-default btn-lg\" onclick=\"goToNoEditView(".$row[Book_ID].")\">
                        <span class=\"glyphicon glyphicon-remove\"></span> Cancel
                    </button>
                </td>
                <td>
                    <div id=\"noEditBookTitle".$row[Book_ID]."\" >".$row['Title']."</div> 
                    <input style=\"display:none\" id=\"editBookTitle".$row[Book_ID]."\" type=\"text\" class=\"form-control\" placeholder=\"Title\" value=\"".$row['Title']."\">
                </td>
                <td>
                    <div id=\"noEditBookAuthor".$row[Book_ID]."\">".$row['Author']."</div>
                    <input style=\"display:none\" id=\"editBookAuthor".$row[Book_ID]."\" type=\"text\" class=\"form-control\" placeholder=\"Author\" value=\"".$row['Author']."\">
                </td>
                <td>
                    <div id=\"noEditBookCategory".$row[Book_ID]."\">".$row['Subject']."</div>
                    <input style=\"display:none\" id=\"editBookCategory".$row[Book_ID]."\" type=\"text\" class=\"form-control\" placeholder=\"Category\" value=\"".$row['Subject']."\">
                </td>
                <td>
                    <div id=\"noEditBookFNF".$row[Book_ID]."\">".$row['Fiction_Non-Fiction']."</div>
                    <input style=\"display:none\" id=\"editBookFNF".$row[Book_ID]."\" type=\"text\" class=\"form-control\" placeholder=\"Fiction or Non-Fiction\" value=\"".$row['Fiction_Non-Fiction']."\">
                </td>
                <td>
                    <div id=\"noEditBookPicPhon".$row[Book_ID]."\">".$row['Picture_Phonics']."</div>
                    <input style=\"display:none\" id=\"editBookPicPhon".$row[Book_ID]."\" type=\"text\" class=\"form-control\" placeholder=\"Picture or Phonics\" value=\"".$row['Picture_Phonics']."\">
                </td>
                <td>
                    <div id=\"noEditBookCopies".$row[Book_ID]."\">".$row['Copies']."</div>
                    <input style=\"display:none\" id=\"editBookCopies".$row[Book_ID]."\" type=\"text\" class=\"form-control\" placeholder=\"# of Copies\" value=\"".$row['Copies']."\">
                </td>
                ";
    }
}

echo $response;
    //echo "Book " . $bookid . " has been updated.";
}
?>