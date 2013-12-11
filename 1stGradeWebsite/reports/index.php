<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
<head>

<?php
require "../header.php";

$student_id = $_GET['studentID']; 
$quarter = $_GET['quarter']; 

// changes characters used in html to their equivalents, for example: < to &gt;
$student_id = htmlspecialchars($student_id);
$quarter = htmlspecialchars($quarter);

// changes characters used in html to their equivalents, for example: < to &gt;
$student_id = addslashes($student_id);
$quarter = addslashes($quarter);

$studentFirstName = "First Name";
$studentLastName = "Last Name";
$quarterText = "Quarter ".$quarter;

//Retrieve the student's name
$queryName = "SELECT first_name, last_name FROM Student WHERE student_id =".$student_id;

$name_results = $con->query($queryName);
if($name_results->num_rows > 0)
{     
    while($row_name = $name_results->fetch_array())
    {
        $studentFirstName = $row_name['first_name'];
        $studentLastName = $row_name['last_name'];
    }
}

if($quarter == 1)
{
    $quarterText = "November SEP Report";
}
else if($quarter == 2)
{
    $quarterText = "February SEP Report";
}
else if($quarter == 3)
{
    $quarterText = "March SEP Report";
}

?>

</head>

<body>

<?php
//echo "Student: ".$student_id;
//echo "<br>Quarter: ".$quarter;

echo "
	<div class=\"container\">";

//Display Name of Student and Date of Report

echo "
<div class=\"row\">
  <div style=\"float: left; margin-left: 13px\"><h1>".$studentFirstName." ".$studentLastName."</h1></div>
  <div style=\"float: right; margin-right: 18px\"><h1>".$quarterText."</h1></div>
</div>
     ";

//Display all test categories
$queryCategories = "SELECT DISTINCT category FROM Test WHERE quarter =".$quarter;

$categories_raw_results = $con->query($queryCategories);



if($categories_raw_results->num_rows > 0)
{     
    while($row_category = $categories_raw_results->fetch_array())
    {

        echo "
	    <div class=\"panel panel-primary\">
	        <!-- Default panel contents -->
	        <div class=\"panel-heading\">".$row_category['category']."</div>
	        <!-- <div class=\"panel-body\"></div> -->
             ";

         //Display all tests in the category for this student
         $queryScores = "SELECT Test. * , Students_Tests.score, Students_Tests.text_score, Students_Tests.student_id
                         FROM Test
                         JOIN Students_Tests 
                         ON ( Students_Tests.test_id = Test.test_id ) 
                         WHERE Students_Tests.student_id =".$student_id."
                               AND Test.category = '".$row_category['category']."'
                               AND Test.quarter =".$quarter
                         ;
  
         $scores_raw_results = $con->query($queryScores);

//echo "Searching for Scores failed: (" . $con->errno . ") " . $con->error;
 
         if($scores_raw_results->num_rows > 0)
         {      
             echo "
                        <!-- Table -->
		        <table class=\"table\">
			    <tr>
                  ";
       
             while($row_score = $scores_raw_results->fetch_array())
             {	
                  //Only display the % if it is a test out of a Total Point number
                  if($row_score['total_points'] != 0) 
                  {
                      echo "	  
			        <td class=\"reportItem\"><center>".$row_score['name']."
                                <br>
                                <b>".$row_score['score']."/".$row_score['total_points']." </b>
                                <br><b>".floor(($row_score['score']/$row_score['total_points']) * 100)."%</b>                   
                                </center></td>
                           ";
                  }
                  else
                  {
                      echo "	  
			        <td class=\"reportItem\"><center>".$row_score['name']."
                                <br>
                                <b>".$row_score['text_score']."</b>                   
                                </center></td>
                           ";
                  }
             }
              
              echo "
			    </tr>
                            <tr>
                   ";    

             while($row_score = $scores_raw_results->fetch_array())
             {	
                  echo "	  
			        <td>".$row_score['score']."</td>
                        ";
             }

              echo "
                        </tr>
		        </table>
                   ";
         }    
echo "
	    </div> <!-- END OF A TEST CATEGORY -->
            
    ";

    }

}


echo "</div> <!-- END OF CONTAINER CLASS -->";


?>
</body>

<?php
mysqli_close($con);
?>
</html>	