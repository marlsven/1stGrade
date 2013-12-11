<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>

<?php
require "../header.php";

//Get unique titles
$queryTitlesDistinct = "SELECT DISTINCT Title FROM Book
                        ORDER BY Title";
$distinctTitles = $con->query($queryTitlesDistinct);

//Get unique authors
$queryAuthorsDistinct = "SELECT DISTINCT Author FROM Book
                         ORDER BY Author";
$distinctAuthors = $con->query($queryAuthorsDistinct);

//Get unique categories
$queryCategoriesDistinct = "SELECT DISTINCT Subject FROM Book
                            ORDER BY Subject";
$distinctCategories = $con->query($queryCategoriesDistinct);
?>

</head>

<body onLoad="searchBooks()">

<div class="container">

<?php
include "../menu.php";
?>

<script> 

function searchBooks() 
{ 
var title = document.getElementById("title").value; 
var author = document.getElementById("author").value;
var category = document.getElementById("category").value; 

//Change all characters that cannot occur verbatim in a URL
title = encodeURIComponent(title);  
author = encodeURIComponent(author);
category = encodeURIComponent(category);
//fnf = encodeURIComponent(fnf);
//picphon = encodeURIComponent(picphon);
//copies = encodeURIComponent(copies);
  
document.getElementById("bookResults").innerHTML = "<h1>Loading Books...</h1>"; 
  
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    { 
    document.getElementById("bookResults").innerHTML=xmlhttp.responseText;
    updateFirstDropdown(title, author, category); 
    } 
  } 
xmlhttp.open("GET","booksearch.php?title="+title+"&author="+author+"&category="+category,true); 
xmlhttp.send(); 
}

function updateFirstDropdown(title, author, category)
{
//Update the First Search Dropdown Menu
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    { 
    document.getElementById("searchTitleList").innerHTML=xmlhttp.responseText; 
    updateSecondDropdown(title, author, category);
    } 
  } 
xmlhttp.open("GET","update1stDropdown.php?title="+title+"&author="+author+"&category="+category,true); 
xmlhttp.send(); 
}

function updateSecondDropdown(title, author, category)
{
//Update the 2nd search box dropdown menu
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    { 
    document.getElementById("searchAuthorList").innerHTML=xmlhttp.responseText; 
    updateThirdDropdown(title, author, category);
    } 
  } 
xmlhttp.open("GET","update2ndDropdown.php?title="+title+"&author="+author+"&category="+category,true); 
xmlhttp.send(); 
}

function updateThirdDropdown(title, author, category)
{
//Update the 3rd search box dropdown menu
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    { 
    document.getElementById("searchCategoryList").innerHTML=xmlhttp.responseText; 
    } 
  } 
xmlhttp.open("GET","update3rdDropdown.php?title="+title+"&author="+author+"&category="+category,true); 
xmlhttp.send(); 
}

<!-- ADD BOOK -->

function toggleAddBook()
{

    if(document.getElementById("newBook").style.display == "none")
    {
        document.getElementById("newBook").style.display = "";
        document.getElementById("addBookButton").style.visibility = "hidden";
    }
    else
    {
        document.getElementById("newBook").style.display = "none";
        document.getElementById("addBookButton").style.visibility = "visible";

        document.getElementById("newTitle").value = "";
        document.getElementById("newAuthor").value = "";
        document.getElementById("newCategory").value = "";
        document.getElementById("newFiction_Non-Fiction").value = "";
        document.getElementById("newPicture_Phonics").value = "";
        document.getElementById("newCopies").value = "";
    }
}

function addBook() 
{ 
var title = document.getElementById("newTitle").value; 
var author = document.getElementById("newAuthor").value;
var category = document.getElementById("newCategory").value; 
var fnf = document.getElementById("newFiction_Non-Fiction").value; 
var picphon = document.getElementById("newPicture_Phonics").value;
var copies = document.getElementById("newCopies").value;

//Change all characters that cannot occur verbatim in a URL
title = encodeURIComponent(title);  
author = encodeURIComponent(author);
category = encodeURIComponent(category);
fnf = encodeURIComponent(fnf);
picphon = encodeURIComponent(picphon);
copies = encodeURIComponent(copies);
  
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    { 
        //Put whatever div of the html you want to update with the response text here.
    } 
  } 
xmlhttp.open("GET","addBook.php?title="+title+"&author="+author+"&category="+category+"&fnf="+fnf+"&picphon="+picphon+"&copies="+copies,true); 
xmlhttp.send(); 

toggleAddBook();
blankAddBook();
searchBooks();
} 

function blankAddBook()
{
document.getElementById("newTitle").value = ""; 
document.getElementById("newAuthor").value = "";
document.getElementById("newCategory").value = ""; 
document.getElementById("newFiction_Non-Fiction").value = ""; 
document.getElementById("newPicture_Phonics").value = "";
document.getElementById("newCopies").value = ""; 
}

<!-- DELETE BOOK -->

function deleteBook(bookid)
{  
	var confirmDelete = confirm("Do You Really Want To Delete This Book?");

	if(confirmDelete == true)
	{
		if (window.XMLHttpRequest) 
		  {// code for IE7+, Firefox, Chrome, Opera, Safari 
		  xmlhttp=new XMLHttpRequest(); 
		  } 
		else
		  {// code for IE6, IE5 
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		  } 
		xmlhttp.onreadystatechange=function() 
		  { 
		  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				//Put whatever div of the html you want to update with the response text here.
			} 
		  } 
		xmlhttp.open("GET","deleteBook.php?bookID="+bookid,true); 
		xmlhttp.send(); 

                document.getElementById("book" + bookid).style.display = "none";
		//searchBooks();
	}
}


<!-- EDIT BOOK -->

function goToEditView(editBookID)
{
        document.getElementById("noEditBookEditButton" + editBookID).style.display = "none";
        document.getElementById("noEditBookDeleteButton" + editBookID).style.display = "none";
        document.getElementById("noEditBookTitle" + editBookID).style.display = "none";
        document.getElementById("noEditBookAuthor" + editBookID).style.display = "none";
        document.getElementById("noEditBookCategory" + editBookID).style.display = "none";
        document.getElementById("noEditBookFNF" + editBookID).style.display = "none";
        document.getElementById("noEditBookPicPhon" + editBookID).style.display = "none";
        document.getElementById("noEditBookCopies" + editBookID).style.display = "none";

        document.getElementById("editBookSaveButton" + editBookID).style.display = "inline-block";
        document.getElementById("editBookCancelButton" + editBookID).style.display = "inline-block";
        document.getElementById("editBookTitle" + editBookID).style.display = "inline-block";
        document.getElementById("editBookAuthor" + editBookID).style.display = "inline-block";
        document.getElementById("editBookCategory" + editBookID).style.display = "inline-block";
        document.getElementById("editBookFNF" + editBookID).style.display = "inline-block";
        document.getElementById("editBookPicPhon" + editBookID).style.display = "inline-block";
        document.getElementById("editBookCopies" + editBookID).style.display = "inline-block";
}

function goToNoEditView(editBookID)
{
        document.getElementById("noEditBookEditButton" + editBookID).style.display = "inline-block";
        document.getElementById("noEditBookDeleteButton" + editBookID).style.display = "inline-block";
        document.getElementById("noEditBookTitle" + editBookID).style.display = "inline-block";
        document.getElementById("noEditBookAuthor" + editBookID).style.display = "inline-block";
        document.getElementById("noEditBookCategory" + editBookID).style.display = "inline-block";
        document.getElementById("noEditBookFNF" + editBookID).style.display = "inline-block";
        document.getElementById("noEditBookPicPhon" + editBookID).style.display = "inline-block";
        document.getElementById("noEditBookCopies" + editBookID).style.display = "inline-block";

        document.getElementById("editBookSaveButton" + editBookID).style.display = "none";
        document.getElementById("editBookCancelButton" + editBookID).style.display = "none";
        document.getElementById("editBookTitle" + editBookID).style.display = "none";
        document.getElementById("editBookAuthor" + editBookID).style.display = "none";
        document.getElementById("editBookCategory" + editBookID).style.display = "none";
        document.getElementById("editBookFNF" + editBookID).style.display = "none";
        document.getElementById("editBookPicPhon" + editBookID).style.display = "none";
        document.getElementById("editBookCopies" + editBookID).style.display = "none";

        var originalTitle = document.getElementById("noEditBookTitle" + editBookID).innerHTML;
        var originalAuthor = document.getElementById("noEditBookAuthor" + editBookID).innerHTML;
        var originalCategory = document.getElementById("noEditBookCategory" + editBookID).innerHTML;
        var originalFNF = document.getElementById("noEditBookFNF" + editBookID).innerHTML;
        var originalPicPhon = document.getElementById("noEditBookPicPhon" + editBookID).innerHTML;
        var originalCopies = document.getElementById("noEditBookCopies" + editBookID).innerHTML;

        document.getElementById("editBookTitle" + editBookID).value = originalTitle;
        document.getElementById("editBookAuthor" + editBookID).value = originalAuthor;
        document.getElementById("editBookCategory" + editBookID).value = originalCategory;
        document.getElementById("editBookFNF" + editBookID).value = originalFNF;
        document.getElementById("editBookPicPhon" + editBookID).value = originalPicPhon;
        document.getElementById("editBookCopies" + editBookID).value = originalCopies; 
}

function saveEditBook(editBookID)
{ 
var title = document.getElementById("editBookTitle" + editBookID).value; 
var author = document.getElementById("editBookAuthor" + editBookID).value;
var category = document.getElementById("editBookCategory" + editBookID).value; 
var fnf = document.getElementById("editBookFNF" + editBookID).value; 
var picphon = document.getElementById("editBookPicPhon" + editBookID).value;
var copies = document.getElementById("editBookCopies" + editBookID).value; 

//Change all characters that cannot occur verbatim in a URL
title = encodeURIComponent(title);  
author = encodeURIComponent(author);
category = encodeURIComponent(category);
fnf = encodeURIComponent(fnf);
picphon = encodeURIComponent(picphon);
copies = encodeURIComponent(copies);


if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest(); 
  } 
else
  {// code for IE6, IE5 
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  } 
xmlhttp.onreadystatechange=function() 
  { 
  if (xmlhttp.readyState==4 && xmlhttp.status==200) 
    {  
        document.getElementById("book" + editBookID).innerHTML=xmlhttp.responseText;
    } 
  } 
xmlhttp.open("GET","saveEditBook.php?title="+title+"&author="+author+"&category="+category+"&fnf="+fnf+"&picPhon="+picphon+"&copies="+copies+"&editBookID="+editBookID,true); 
//Test code: marlsven.byethost18.com/books/saveEditBook.php?title=00asdf&author=authorasdf&category=categoryASDF&fnf=fnfASDF&picPhon=picPhonASDF&copies=10&editBookID=664
xmlhttp.send(); 

//searchBooks();
} 

function addslashes (str) {
  return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function chooseSearch(itemID, TitleAuthorCategory)
{
var newSearchValue = document.getElementById("search"+TitleAuthorCategory+itemID).innerHTML;
document.getElementById(TitleAuthorCategory).value = newSearchValue;
searchBooks();
}

</script>


<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><h2>Mrs Karlsven's Books</h2></div>

  <!-- Search Table -->
  <table class="table">
    <tr>
        <form class="navbar-form navbar-left" method="GET">
            <td>            
                <button id="addBookButton" type="button" class="btn btn-primary btn-lg" onclick="toggleAddBook()">
                    Add New Book
                </button>
            </td>
            <td></td>
            <td>
    <div class="input-group">
      <input type="text" class="clearable form-control" id="title" placeholder="Search Titles" onkeyup="searchBooks()">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
        <ul id="searchTitleList" class="searchList dropdown-menu pull-right">

          <?php
              $titleCounter = 0;
              while($titleRow = mysqli_fetch_assoc($distinctTitles))
              {
                  echo "
                       <li><a id=\"searchtitle".$titleCounter."\" onclick=\"chooseSearch('".$titleCounter."','title')\">".$titleRow['Title']."</a></li>
                       ";
                  $titleCounter++;
              }
          ?>

        </ul>
      </div><!-- /btn-group -->
    </div><!-- /input-group -->
            </td>
            <td>
    <div class="input-group">
      <input type="text" class="form-control" id="author" placeholder="Search Authors" onkeyup="searchBooks()">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
        <ul id="searchAuthorList" class="searchList dropdown-menu pull-right">

          <?php 
              $authorCounter = 0;
              while($authorRow = mysqli_fetch_assoc($distinctAuthors))
              {
                  echo "
                       <li><a id=\"searchauthor".$authorCounter."\" onclick=\"chooseSearch('".$authorCounter."','author')\">".$authorRow['Author']."</a></li>
                       ";
                  $authorCounter++;
              } 
          ?>

        </ul>
      </div><!-- /btn-group -->
    </div><!-- /input-group -->
            </td>
            <td>
    <div class="input-group">
      <input type="text" class="form-control" id="category" placeholder="Search Categories" onkeyup="searchBooks()">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
        <ul id="searchCategoryList" class="searchList dropdown-menu pull-right">

          <?php
              $categoryCounter = 0;
              while($categoryRow = mysqli_fetch_assoc($distinctCategories))
              {
                  echo "
                       <li><a id=\"searchcategory".$categoryCounter."\" onclick=\"chooseSearch('".$categoryCounter."','category')\">".$categoryRow['Subject']."</a></li>
                       ";
                  $categoryCounter++;
              }
          ?>

        </ul>
      </div><!-- /btn-group -->
    </div><!-- /input-group -->
            </td>
            <td></td>
            <td></td>
            <td></td>
        </form>
    </tr>
  </table>


  <!-- Add Book Table -->
  <!-- <table id="addBookTable" class="table" style="display:none">
    <tr id="newBook">
        <form class="navbar-form navbar-left" method="GET">
            <td>
                <button type="button" class="btn btn-warning btn-lg" onclick="addBook()">
                    <span class="glyphicon glyphicon-plus"></span> Save
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-default btn-lg" onclick="toggleAddBook()">
                    <span class="glyphicon glyphicon-remove"></span> Cancel
                </button>
            </td>
            <td><input type="text" class="form-control" id="newTitle" placeholder="Title" ></td>
            <td><input type="text" class="form-control" id="newAuthor" placeholder="Author" ></td>
            <td><input type="text" class="form-control" id="newCategory" placeholder="Category" ></td>
            <td><input type="text" class="form-control" id="newFiction_Non-Fiction" placeholder="Fiction/Non-Fiction" ></td>
            <td><input type="text" class="form-control" id="newPicture_Phonics" placeholder="Picture/Phonics" ></td>
            <td><input type="text" class="form-control" id="newCopies" placeholder="# Of Copies" ></td>
        </form>
    </tr>
  </table> -->

<span id="bookResults"></span>
</div>

</div> <!-- END OF CONTAINER DIV -->
</body>

<?php
mysqli_close($con);
?>
</html>					