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

//$query = "SELECT * FROM Book";
$query = "SELECT * FROM Book WHERE 
                          (Title LIKE '%".$title."%') AND 
                          (Author LIKE '%".$author."%') AND 
                          (Subject LIKE '%".$category."%') ORDER BY Title";



$raw_results = $con->query($query);

$response .= "<table class=\"table table-hover\">

    <tr style = \"font-weight: bold\">
        <td>".$raw_results->num_rows." Books Found</td>
        <td></td>
        <td>Title</td>
        <td>Author</td>
        <td>Category</td>
        <td>Fiction/Non-Fiction</td>
        <td>Picture/Phonics</td>
        <td># of Copies</td>
    </tr>";

$response .="
    <tr style=\"display:none\" id=\"newBook\">
        <form class=\"navbar-form navbar-left\" method=\"GET\">
            <td>
                <button type=\"button\" class=\"btn btn-warning btn-lg\" onclick=\"addBook()\">
                    <span class=\"glyphicon glyphicon-plus\"></span> Save New Book
                </button>
            </td>
            <td>
                <button type=\"button\" class=\"btn btn-default btn-lg\" onclick=\"toggleAddBook()\">
                    <span class=\"glyphicon glyphicon-remove\"></span> Cancel
                </button>
            </td>
            <td><input type=\"text\" class=\"form-control\" id=\"newTitle\" placeholder=\"Title\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newAuthor\" placeholder=\"Author\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newCategory\" placeholder=\"Category\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newFiction_Non-Fiction\" placeholder=\"Fiction/Non-Fiction\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newPicture_Phonics\" placeholder=\"Picture/Phonics\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newCopies\" placeholder=\"# Of Copies\" ></td>
        </form>
    </tr>";

if($raw_results->num_rows > 0)
{       
    while($row = $raw_results->fetch_array())
    {
             $response .=  
             "<tr id=\"book".$row[Book_ID]."\">
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
            </tr>";
    }
}
else
{ // if there are no matching rows do following 
    $response .= "<tr style = \"font-weight: bold\">
          <td>
             <h2>Nothing to see here</h2>
          </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>";
}

$response .= "</table>";

echo $response; 
?>