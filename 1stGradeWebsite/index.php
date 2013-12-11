<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>

<?php

require "header.php";

/*

$result = mysqli_query($con,"SELECT * FROM Teacher");

while($row = mysqli_fetch_array($result))
  {
  echo $row['Name'];
  echo "<br>";
  }

*/

mysqli_close($con);
?>

</head>

<body>

<div class="container">

<?php
include "menu.php";
?>

<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><h2>1st Grade Classroom</h2></div>
  <div class="panel-body"><h3>Welcome, Mrs Karlsven</h3></div>
</div>

</div> <!-- END OF CONTAINER DIV -->
</body>

</html>	