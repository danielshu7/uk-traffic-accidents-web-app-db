<?php
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_rev_submit'])) {
    // Refer to conn.php file and open a connection.
    require_once("conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_code = $_POST['field_rev_code'];
    // Save the query into variable called $query. Note that :ph_director is a place holder
    if(!empty($var_code)) {
        $query = "UPDATE misc_info SET review_flag = 1 WHERE collision_code = :ph_code";

        try
            {
              // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
              $prepared_stmt = $dbo->prepare($query);
              //bind the value saved in the variable $var_director to the place holder :ph_director  
              // Use PDO::PARAM_STR to sanitize user string.
              $prepared_stmt->bindValue(':ph_code', $var_code, PDO::PARAM_INT);
              $result = $prepared_stmt->execute();

              if($result) {
                    $message = "Accident record was flagged for review.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
              }
              else {
                    $message = "Sorry, there was an error. Accident record was not flagged.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    print_r($prepared_stmt->errorInfo());
              }
            }
            catch (PDOException $ex)
            { // Error in database processing.
              echo $query . "<br>" . $ex->getMessage(); // HTTP 500 - Internal Server Error
            }
    }
}
elseif (isset($_POST['field_del_submit'])) {
    // Refer to conn.php file and open a connection.
    require_once("conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_code = $_POST['field_del_code'];
    // Save the query into variable called $query. Note that :ph_director is a place holder
    if(!empty($var_code)) {
        $query = "DELETE FROM misc_info WHERE collision_code = :ph_code";

        try
            {
              // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
              $prepared_stmt = $dbo->prepare($query);
              //bind the value saved in the variable $var_director to the place holder :ph_director  
              // Use PDO::PARAM_STR to sanitize user string.
              $prepared_stmt->bindValue(':ph_code', $var_code, PDO::PARAM_INT);
              $result = $prepared_stmt->execute();

              if($result) {
                    $message = "Accident record was deleted successfully.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
              }
              else {
                    $message = "Sorry, there was an error. Accident record was not deleted.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    print_r($prepared_stmt->errorInfo());
              }
            }
            catch (PDOException $ex)
            { // Error in database processing.
              echo $query . "<br>" . $ex->getMessage(); // HTTP 500 - Internal Server Error
            }
    }
    
}
?>

<html>
<!-- Any thing inside the HEAD tags are not visible on page.-->
  <head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
    <link rel="stylesheet" type="text/css" href="project.css" />
  </head> 
<!-- Everything inside the BODY tags are visible on page.-->
  <body>
  <div class="header" id="myHeader">
			<div id="navbar">
				<ul>
					<li><a href="index.html">Home</a></li>
					<li><a href="statistics.php">Summary Statistics</a></li>
					<li><a href="travelPlanner.php">Travel Planner</a></li>
					<li><a href="searchAccidents.php">Search Accidents</a></li>
					<li><a href="insertAccidents.php">Report an Accident</a></li>
					<li><a href="flagAccidents.php">Faulty Entry Report</a></li>
				</ul>
			</div>
		  </div>
    
    <h1>Faulty Entry Report</h1>
        <h4>If any possibly faulty entries are found, please submit its code either to be reviewed or to be immediately deleted.</h4>

    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
    <form method="post"><p>
      <label for="id_rev_code">Enter collision code here to flag for review:</label>
      <input type="number" name="field_rev_code" id = "id_rev_code" min="1">
      <input type="submit" name="field_rev_submit" value="Submit">

      <label for="id_del_code">Enter collision code here to delete:</label>
      <input type="number" name="field_del_code" id = "id_del_code" min="1">
      <input type="submit" name="field_del_submit" value="Submit"></p>
    </form>
  </body>
  <footer></footer>
</html>
