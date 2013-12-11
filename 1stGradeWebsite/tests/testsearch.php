<?php 

include "../header.php"; 

$response = ""; 

// gets value sent over search form 
$name = $_GET['name'];  
$quarter = $_GET['quarter'];
$category = $_GET['category']; 

$edittestID = $_GET['edittestID'];  
       
// changes characters used in html to their equivalents, for example: < to &gt;
$quarter = htmlspecialchars($quarter);
$name = htmlspecialchars($name);
$category = htmlspecialchars($category);  
//$total_points = htmlspecialchars($total_points);

// changes characters used in html to their equivalents, for example: < to &gt;
$quarter = addslashes($quarter);
$name = addslashes($name);
$category = addslashes($category); 
//$total_points = addslashes($total_points);   

// makes sure nobody uses SQL injection            
//$title = mysqli_real_escape_string($title);
//$author = mysqli_real_escape_string($author);
//$category = mysqli_real_escape_string($category); 

//$query = "SELECT * FROM Test";
$query = "SELECT * FROM Test WHERE 
                          (name LIKE '%".$name."%') AND 
                          (quarter LIKE '%".$quarter."%') AND 
                          (category LIKE '%".$category."%') ORDER BY quarter";



$raw_results = $con->query($query);

$response .= "<table class=\"table table-hover\">

    <tr style = \"font-weight: bold\">
        <td>".$raw_results->num_rows." tests Found</td>
        <td></td>
        <td></td>
        <td>Quarter</td>
        <td>Test Name</td>
        <td>Category</td>
        <td>Total Points</td>
    </tr>";

$response .="
    <tr style=\"display:none\" id=\"newTest\">
        <form class=\"navbar-form navbar-left\" method=\"GET\">
            <td>
                <button type=\"button\" class=\"btn btn-warning btn-lg\" onclick=\"addTest()\">
                    <span class=\"glyphicon glyphicon-plus\"></span> Save New test
                </button>
            </td>
            <td>
                <button type=\"button\" class=\"btn btn-default btn-lg\" onclick=\"toggleAddTest()\">
                    <span class=\"glyphicon glyphicon-remove\"></span> Cancel
                </button>
            </td>
            <td></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newQuarter\" placeholder=\"Quarter\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newName\" placeholder=\"Test Name\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newCategory\" placeholder=\"Category\" ></td>
            <td><input type=\"text\" class=\"form-control\" id=\"newTotal_Points\" placeholder=\"Total Points\" ></td>
        </form>
    </tr>";

if($raw_results->num_rows > 0)
{       
    while($row = $raw_results->fetch_array())
    {
             $response .=  
             "<tr id=\"Test".$row['test_id']."\">
                <td>
                    <button type=\"button\" class=\"btn btn-success\" onclick=\"OpenInNewTab('http://www.marlsven.byethost18.com/scores/index.php?test_id=".$row['test_id']."')\">
                        <span class=\"glyphicon glyphicon-plus\"></span> Add Scores
                    </button>
                </td>
                <td>
                    <button type=\"button\" id=\"noEditTestEditButton".$row['test_id']."\" class=\"btn btn-info btn-lg\" onclick=\"goToEditView(".$row['test_id'].")\">
                        <span class=\"glyphicon glyphicon-pencil\"></span> Edit
                    </button>
                    
                    <button style=\"display:none\" type=\"button\" id=\"editTestSaveButton".$row['test_id']."\" class=\"btn btn-warning btn-lg\" onclick=\"saveEditTest(".$row['test_id'].")\">
                        <span class=\"glyphicon glyphicon-plus\"></span> Save
                    </button>
                </td>
                <td>
                    <button type=\"button\" id=\"noEditTestDeleteButton".$row['test_id']."\" class=\"btn btn-default btn-lg\" onclick=\"deleteTest(".$row['test_id'].")\">
                        <span class=\"glyphicon glyphicon-trash\"></span> Delete
                    </button>
 
                    <button style=\"display:none\" type=\"button\" id=\"editTestCancelButton".$row['test_id']."\" class=\"btn btn-default btn-lg\" onclick=\"goToNoEditView(".$row['test_id'].")\">
                        <span class=\"glyphicon glyphicon-remove\"></span> Cancel
                    </button>
                </td>
                <td>
                    <div id=\"noEditTestQuarter".$row['test_id']."\" >".$row['quarter']."</div> 
                    <input style=\"display:none\" id=\"editTestQuarter".$row['test_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Quarter\" value=\"".$row['quarter']."\">
                </td>
                <td>
                    <div id=\"noEditTestName".$row['test_id']."\">".$row['name']."</div>
                    <input style=\"display:none\" id=\"editTestName".$row['test_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Test Name\" value=\"".$row['name']."\">
                </td>
                <td>
                    <div id=\"noEditTestCategory".$row['test_id']."\">".$row['category']."</div>
                    <input style=\"display:none\" id=\"editTestCategory".$row['test_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Category\" value=\"".$row['category']."\">
                </td>
                <td>
                    <div id=\"noEditTestTotal_Points".$row['test_id']."\">".$row['total_points']."</div>
                    <input style=\"display:none\" id=\"editTestTotal_Points".$row['test_id']."\" type=\"text\" class=\"form-control\" placeholder=\"Total Points\" value=\"".$row['total_points']."\">
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
      </tr>";
}

$response .= "</table>";

echo $response; 
?>