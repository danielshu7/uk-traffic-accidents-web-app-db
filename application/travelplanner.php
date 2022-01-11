<?php
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_road_submit'])) {
    // Refer to conn.php file and open a connection.
    require_once("conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_first_road = !empty($_POST['field_first_road']) ? $_POST['field_first_road'] : 0;
    $var_second_road = !empty($_POST['field_second_road']) ? $_POST['field_second_road'] : 0;
    // Save the query into variable called $query. Note that :ph_director is a place holder
    $query = "CALL propensity_index(:ph_first_road, :ph_second_road)";

    try
        {
            // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
            $prepared_stmt = $dbo->prepare($query);
            //bind the value saved in the variable $var_director to the place holder :ph_director  
            // Use PDO::PARAM_STR to sanitize user string.
            $prepared_stmt->bindValue(':ph_first_road', $var_first_road, PDO::PARAM_INT);
            $prepared_stmt->bindValue(':ph_second_road', $var_second_road, PDO::PARAM_INT);
            $prepared_stmt->execute();
            $result1 = $prepared_stmt->fetchAll();
        }
        catch (PDOException $ex)
        { // Error in database processing.
            echo $query . "<br>" . $ex->getMessage(); // HTTP 500 - Internal Server Error
        }
}
elseif (isset($_POST['field_date_submit'])) {
    // Refer to conn.php file and open a connection.
    require_once("conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_date = $_POST['field_date'];
    $var_weather_cond = $_POST['field_weather_cond'];
    // Save the query into variable called $query. Note that :ph_director is a place holder
    $query = "CALL date_safety(:ph_date, :ph_weather_cond)";

    try
        {
            // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
            $prepared_stmt = $dbo->prepare($query);
            //bind the value saved in the variable $var_director to the place holder :ph_director  
            // Use PDO::PARAM_STR to sanitize user string.
            $prepared_stmt->bindValue(':ph_date', $var_date, PDO::PARAM_STR);
            $prepared_stmt->bindValue(':ph_weather_cond', $var_weather_cond, PDO::PARAM_STR);
            $prepared_stmt->execute();
            $result2 = $prepared_stmt->fetchAll();
        }
        catch (PDOException $ex)
        { // Error in database processing.
            echo $query . "<br>" . $ex->getMessage(); // HTTP 500 - Internal Server Error
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
    
    <h1>Travel Planner</h1>
        <h4>Here are various tools for viewing how safe certain locations or dates are based on historical data.</h4>

        <h2> Accident Propensity Index Calculator </h2>
            <p>Enter up to two roads to see an internally-calculated index for how dangerous they are.  
            An index of less than .5 is considered to be safe.  An index of at least 1 is considered to be highly dangerous.</p>

    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
        <form method="post"><p>
          <label for="id_first_road">First Road Number:</label>
          <input type="number" name="field_first_road" id = "id_first_road" min="0">
          <label for="id_second_road">Second Road Number:</label>
          <input type="number" name="field_second_road" id = "id_second_road" min="0">
          <input type="submit" name="field_road_submit" value="Submit"></p>
        </form>

        <?php
          if (isset($_POST['field_road_submit'])) {
            // If the query executed (result is true) and the row count returned from the query is greater than 0 then...
            if ($result1 && $prepared_stmt->rowCount() > 0 && $result1[0][0] != "") { ?>
                  <!-- first show the header RESULT -->
                  <p> Index: 
                        <?php echo $result1[0][0]?> </p>
            <?php } else { ?>
              <!-- IF query execution resulted in error display the following message-->
              <h3>Sorry, no results found. </h3>
            <?php }
          } ?>

        <h2> Date Safety Tool</h2>
            <p>Enter a date and the expected weather conditions to see whether it has historically been safe or not.</p>
        <form method="post"><p>
          <label for="id_date">Date of Travel:</label>
          <input type="date" name="field_date" id="id_date">
          <script>
            document.getElementById('id_date').value = new Date().toISOString().substring(0, 10);
          </script>

          <label for="id_weather_cond">Expected Weather Conditions:</label>
    	  <select name="field_weather_cond" id="id_weather_cond">
            <option value="Unknown">Unknown</option>
            <option value="Fine without high winds">Fine without high winds</option>
            <option value="Fine with high winds">Fine with high winds</option>
            <option value="Raining without high winds">Raining without high winds</option>
            <option value="Raining with high winds">Raining with high winds</option>
            <option value="Snowing without high winds">Snowing without high winds</option>
            <option value="Snowing with high winds">Snowing with high winds</option>
            <option value="Fog or mist">Fog or mist</option>
            <option value="Other">Other</option>
          </select>

          <input type="submit" name="field_date_submit" value="Submit"></p>
        </form>

        <?php
          if (isset($_POST['field_date_submit'])) {
            // If the query executed (result is true) and the row count returned from the query is greater than 0 then...
            if ($result2 && $prepared_stmt->rowCount() > 0) { ?>
                  <!-- first show the header RESULT -->
                  <p> <?php echo $result2[0][0] ?> </p>
            <?php } else { ?>
              <!-- IF query execution resulted in error display the following message-->
              <h3>Sorry, no results found. </h3>
            <?php }
          } ?>
          <footer></footer>
  </body>
</html>
