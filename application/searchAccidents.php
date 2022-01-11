<?php
require_once("conn.php");

$query_max = "SELECT MAX(collision_code) AS max_code
                FROM misc_info";

try
    {
      // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
      $prepared_stmt_max = $dbo->prepare($query_max);
      $prepared_stmt_max->execute();
      // Fetch all the values based on query and save that to variable $result
      $result_max = $prepared_stmt_max->fetchAll();
    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $query_max . "<br>" . $ex->getMessage(); // HTTP 500 - Internal Server Error
    }

// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_submit'])) {
    // Will get the value typed in the form text field and save into variable
    $var_lower_code = !empty($_POST['field_lower_code']) ? $_POST['field_lower_code'] : 1;
    $var_upper_code = min(!empty($_POST['field_upper_code']) ? $_POST['field_upper_code'] : 1,
                           $var_lower_code + 9999);
    // Save the query into variable called $query. Note that :ph_director is a place holder
    $query = "SELECT * 
              FROM misc_info 
              WHERE :ph_lower_code <= collision_code AND :ph_upper_code >= collision_code
              ORDER BY collision_code";

try
    {
      // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
      $prepared_stmt = $dbo->prepare($query);
      //bind the value saved in the variable $var_director to the place holder :ph_director  
      // Use PDO::PARAM_STR to sanitize user string.
      $prepared_stmt->bindValue(':ph_lower_code', $var_lower_code, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':ph_upper_code', $var_upper_code, PDO::PARAM_INT);
      $prepared_stmt->execute();
      // Fetch all the values based on query and save that to variable $result
      $result = $prepared_stmt->fetchAll();

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
    
    <h1> Search Accidents</h1>
    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
      <h2>Specify a range to find accidents.</h2>
      <h3> Current max code: <?php echo $result_max[0][0]?><br>
            (Max range size of 10000)</h3>
    <form method="post"><p>

      <label for="id_lower_code">Lower-bound Collision Code:</label>
      <!-- The input type is a text field. Note the name and id. The name attribute
        is referred above on line 7. $var_director = $_POST['field_director']; id attribute is referred in label tag above on line 52-->
      <input type="number" name="field_lower_code" id = "id_lower_code" min="1">
      <label for="id_upper_code">Upper-bound Collision Code:</label>
      <input type="number" name="field_upper_code" id = "id_upper_code" min="1">
      <!-- The input type is a submit button. Note the name and value. The value attribute decides what will be dispalyed on Button. In this case the button shows Submit.
      The name attribute is referred  on line 3 and line 61. -->
      <input type="submit" name="field_submit" value="Submit"></p>
    </form>
    
    <?php
      if (isset($_POST['field_submit'])) {
        // If the query executed (result is true) and the row count returned from the query is greater than 0 then...
        if ($result && $prepared_stmt->rowCount() > 0) { ?>
              <!-- first show the header RESULT -->
              <h2> Results: </h2>
              <p> Displaying accidents between codes
                    <?php echo $var_lower_code?> and
                    <?php echo $var_upper_code ?> (inclusive) </p>
              <!-- THen create a table like structure. See the project.css how table is stylized. -->
              <div class="table-container">
              <table>
                <!-- Create the first row of table as table head (thead). -->
                <thead>
                   <!-- The top row is table head with four columns named -- ID, Title ... -->
                  <tr>
                    <th>Collision Code</th>
                    <th>Location Easting Osgr</th>
                    <th>Location Northing Osgr</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>Accident Severity</th>
                    <th>Number of Vehicles</th>
                    <th>Number of Casualties</th>
                    <th>Date of Accident</th>
                    <th>Time of Accident</th>
                    <th>First Road Class</th>
                    <th>First Road Number</th>
                    <th>Road Type</th>
                    <th>Speed Limit</th>
                    <th>Junction Detail</th>
                    <th>Junction Control</th>
                    <th>Pedestrian Crossing Human Control</th>
                    <th>Pedestrian Crossing Physical Facilities</th>
                    <th>Second Road Class</th>
                    <th>Second Road Number</th>
                    <th>Light Conditions</th>
                    <th>Weather Conditions</th>
                    <th>Road Surface Conditions</th>
                    <th>Special Conditions at Site</th>
                    <th>Carriageway Hazards</th>
                    <th>Urban or Rural Area?</th>
                    <th>Police Officer Attendance?</th>
                    <th>LSOA</th>
                  </tr>
                </thead>
                 <!-- Create rest of the the body of the table -->
                <tbody>
                   <!-- For each row saved in the $result variable ... -->
                  <?php foreach ($result as $row) { ?>
                
                    <tr>
                       <!-- Print (echo) the value of mID in first column of table -->
                      <td><?php echo $row["collision_code"]; ?></td>
                      <!-- Print (echo) the value of title in second column of table -->
                      <td><?php echo $row["location_easting_osgr"]; ?></td>
                      <!-- Print (echo) the value of movieYear in third column of table and so on... -->
                      <td><?php echo $row["location_northing_osgr"]; ?></td>
                      <td><?php echo $row["longitude"]; ?></td>
                      <td><?php echo $row["latitude"]; ?></td>
                      <td><?php echo $row["accident_severity"]; ?></td>
                      <td><?php echo $row["number_of_vehicles"]; ?></td>
                      <td><?php echo $row["number_of_casualties"]; ?></td>
                      <td><?php echo $row["date_accident"]; ?></td>
                      <td><?php echo $row["time_accident"]; ?></td>
                      <td><?php echo $row["first_road_class"]; ?></td>
                      <td><?php echo $row["first_road_number"]; ?></td>
                      <td><?php echo $row["road_type"]; ?></td>
                      <td><?php echo $row["speed_limit"]; ?></td>
                      <td><?php echo $row["junction_detail"]; ?></td>
                      <td><?php echo $row["junction_control"]; ?></td>
                      <td><?php echo $row["pedestrian_crossing_human_control"]; ?></td>
                      <td><?php echo $row["pedestrian_crossing_physical_facilities"]; ?></td>
                      <td><?php echo $row["second_road_class"]; ?></td>
                      <td><?php echo $row["second_road_number"]; ?></td>
                      <td><?php echo $row["light_conditions"]; ?></td>
                      <td><?php echo $row["weather_conditions"]; ?></td>
                      <td><?php echo $row["road_surface_conditions"]; ?></td>
                      <td><?php echo $row["special_conditions_at_site"]; ?></td>
                      <td><?php echo $row["carriageway_hazards"]; ?></td>
                      <td><?php echo $row["urban_or_rural_area"]; ?></td>
                      <td><?php echo $row["did_police_officer_attend_scene_of_accident"]; ?></td>
                      <td><?php echo $row["lsoa_of_accident_location"]; ?></td>
                    <!-- End first row. Note this will repeat for each row in the $result variable-->
                    </tr>
                  <?php } ?>
                  <!-- End table body -->
                </tbody>
                <!-- End table -->
            </table>
            </div>
  
        <?php } else { ?>
          <!-- IF query execution resulted in error display the following message-->
          <h3>Sorry, no results found. </h3>
        <?php }
    } ?>
    <footer></footer>
</html>






