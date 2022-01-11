<?php

if (isset($_POST['f_submit'])) {

    require_once("conn.php");

    $var_lEOSGR = $_POST['f_lEOSGR'];
    $var_lNOSGR = $_POST['f_lNOSGR'];
    $var_longitude = $_POST['f_longitude'];
    $var_latitude = $_POST['f_latitude'];
    $var_severity = $_POST['f_severity'];
    $var_vehicles = $_POST['f_vehicles'];
    $var_casualties = $_POST['f_casualties'];
    $var_date = $_POST['f_date'];
    $var_time = $_POST['f_time'];
    $var_first_road_class = $_POST['f_first_road_class'];
    $var_first_road_number = !empty($_POST['f_first_road_number']) ? $_POST['f_first_road_number'] : 0;
    $var_road_type = $_POST['f_road_type'];
    $var_speed_limit = $_POST['f_speed_limit'];
    $var_junction_detail = $_POST['f_junction_detail'];
    $var_junction_control= $_POST['f_junction_control'];
    $var_human_control= $_POST['f_human_control'];
    $var_crossing_facilities = $_POST['f_crossing_facilities'];
    $var_second_road_class = $_POST['f_second_road_class'];
    $var_second_road_number = !empty($_POST['f_second_road_number']) ? $_POST['f_second_road_number'] : 0;
    $var_light_cond = $_POST['f_light_cond'];
    $var_weather_cond = $_POST['f_weather_cond'];
    $var_rs_cond = $_POST['f_rs_cond'];
    $var_spec_cond = $_POST['f_spec_cond'];
    $var_carriageway_hazards= $_POST['f_carriageway_hazards'];
    $var_ur = $_POST['f_ur'];
    $var_attend_scene = $_POST['f_attend_scene'];
    $var_LSOA = $_POST['f_LSOA'];

    $query = "INSERT INTO misc_info
              VALUES (DEFAULT, 
                        '',
                        :lEOSGR, 
                        :lNOSGR, 
                        :longitude,
                        :latitude,
                        :severity,
                        :vehicles,
                        :casualties,
                        :date,
                        :time,
                        :first_road_class,
                        :first_road_number,
                        :road_type,
                        :speed_limit,
                        :junction_detail,
                        :junction_control,
                        :human_control,
                        :crossing_facilities,
                        :second_road_class,
                        :second_road_number,
                        :light_cond,
                        :weather_cond,
                        :rs_cond,
                        :spec_cond,
                        :carriageway_hazards,
                        :ur,
                        :attend_scene,
                        :LSOA,
                        0)";

    try
    {
      $prepared_stmt = $dbo->prepare($query);
      $prepared_stmt->bindValue(':lEOSGR', $var_lEOSGR, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':lNOSGR', $var_lNOSGR, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':longitude', $var_longitude, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':latitude', $var_latitude, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':severity', $var_severity, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':vehicles', $var_vehicles, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':casualties', $var_casualties, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':date', $var_date, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':time', $var_time, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':first_road_class', $var_first_road_class, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':first_road_number', $var_first_road_number, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':road_type', $var_road_type, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':speed_limit', $var_speed_limit, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':junction_detail', $var_junction_detail, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':junction_control', $var_junction_control, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':human_control', $var_human_control, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':crossing_facilities', $var_crossing_facilities, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':second_road_class', $var_second_road_class, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':second_road_number', $var_second_road_number, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':light_cond', $var_light_cond, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':weather_cond', $var_weather_cond, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':rs_cond', $var_rs_cond, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':spec_cond', $var_spec_cond, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':carriageway_hazards', $var_carriageway_hazards, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':ur', $var_ur, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':attend_scene', $var_attend_scene, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':LSOA', $var_LSOA, PDO::PARAM_STR);
      $result = $prepared_stmt->execute();

      if($result) {
            $message = "Accident record was inserted successfully.";
            echo "<script type='text/javascript'>alert('$message');</script>";
      }
      else {
            $message = "Sorry, there was an error. Accident record was not inserted.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            print_r($prepared_stmt->errorInfo());
      }
    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $sql . "<br>" . $ex->getMessage(); // HTTP 500 - Internal Server Error
    }
}

?>

<html>
  <head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
    <link rel="stylesheet" type="text/css" href="project.css" />
  </head> 

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


<script>
function submitForm() {
        if (myForm.f_lEOSGR.value == ''
            || myForm.f_lNOSGR.value == ''
            || myForm.f_longitude.value == ''
            || myForm.f_latitude.value == '') {
            alert("Please submit location values");
            return false;
        }
        if (myForm.f_severity.value == '') {
            alert("Please select a value for Accident Severity.");
            return false;
        }
        if (myForm.f_vehicles.value == '') {
            alert("Please submit number of vehicles.");
            return false;
        }
        if (myForm.f_casualties.value == '') {
            alert("Please submit number of casualties.");
            return false;
        }
        if (myForm.f_date.value == ''
            || myForm.f_time.value == '') {
            alert("Please submit datetime values");
            return false;
        }
        if (myForm.f_first_road_class.value == '') {
            alert("Please select a value for First Road Class.");
            return false;
        }
        if (myForm.f_road_type.value == '') {
            alert("Please select a value for Road Type.");
            return false;
        }
        if (myForm.f_speed_limit.value == '') {
            alert("Please submit the speed limit.");
            return false;
        }
        if (myForm.f_human_control.value == '') {
            alert("Please select a value for Pedestrian Crossing Human Control.");
            return false;
        }
        if (myForm.f_crossing_facilities.value == '') {
            alert("Please select a value for Pedestrian Crossing Physcial Facilities.");
            return false;
        }
        if (myForm.f_second_road_class.value == '') {
            alert("Please select a value for Second Road Class.");
            return false;
        }
        if (myForm.f_light_cond.value == '') {
            alert("Please select a value for Light Conditions.");
            return false;
        }
        if (myForm.f_rs_cond.value == '') {
            alert("Please select a value for Road Surface Conditions.");
            return false;
        }
        if (myForm.f_ur.value == '') {
            alert("Please select a value for Urban or Rural Area.");
            return false;
        }
        return true;
    }
</script>

<h1> Insert Accident </h1>

    <form name="myForm" method="post" id="myForm" onsubmit='return submitForm()'><p>
    	<label for="id_lEOSGR">Location_Easting_OSGR</label>
    	<input type="number" name="f_lEOSGR" id="id_lEOSGR" min="1"> 

    	<label for="id_lNOSGR">Location Northing OSGR</label>
    	<input type="number" name="f_lNOSGR" id="id_lNOSGR" min="1">

    	<label for="id_longitude">Longitude</label>
    	<input type="number" name="f_longitude" id="id_longitude">

    	<label for="id_latitude">Latitude</label>
    	<input type="number" name="f_latitude" id="id_latitude">

        <label for="id_severity">Accident Severity</label>
        <select name="f_severity" id="id_severity">
            <option value="" disabled selected>Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>

        <label for="id_vehicles">Number of Vehicles</label>
    	<input type="number" name="f_vehicles" id="id_vehicles" min="0">

        <label for="id_casualties">Number of Casualties</label>
    	<input type="number" name="f_casualties" id="id_casualties" min="0">

        <label for="id_date">Date of Accident</label>
    	<input type="date" name="f_date" id="id_date">

        <label for="id_time">Time of Accident</label>
    	<input type="time" name="f_time" id="id_time">

        <label for="id_first_road_class">First Road Class</label>
        <select name="f_first_road_class" id="id_first_road_class">
            <option value="" disabled selected>Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>

        <label for="id_first_road_number">First Road Number</label>
    	<input type="number" name="f_first_road_number" id="id_first_road_number">

        <label for="id_road_type">Road Type</label>
    	<select name="f_road_type" id="id_road_type">
            <option value="" disabled selected>Select</option>
            <option value="Single carriageway">Single Carriageway</option>
            <option value="Dual carriageway">Dual Carriageway</option>
            <option value="Roundabout">Roundabout</option>
            <option value="One way street">One Way Street</option>
            <option value="Slip road">Slip Road</option>
            <option value="Unknown">Unknown</option>
        </select>

        <label for="id_speed_limit">Speed Limit</label>
    	<input type="number" name="f_speed_limit" id="id_speed_limit" min="0">

        <label for="id_junction_detail">Junction Detail</label>
    	<input type="text" name="f_junction_detail" id="id_junction_detail" maxlength="40">

        <label for="id_junction_control">Junction Control</label>
    	<select name="f_junction_control" id="id_junction_control">
            <option value="">Unknown</option>
            <option value="Authorised person">Authorised Person</option>
            <option value="Automatic traffic signal">Automatic Traffic Signal</option>
            <option value="Giveway or uncontrolled">Giveway or Uncontrolled</option>
            <option value="Stop Sign">Stop Sign</option>
        </select>

        <label for="id_human_control">Pedestrian Crossing Human Control</label>
    	<select name="f_human_control" id="id_human_control">
            <option value="" disabled selected>Select</option>
            <option value="None within 50 metres">None within 50 metres</option>
            <option value="Control by school crossing patrol">Control by school crossing patrol</option>
            <option value="Control by other authorised person">Control by other authorised person</option>
        </select>

        <label for="id_crossing_facilities">Pedestrian Crossing Physical Facilities</label>
    	<select name="f_crossing_facilities" id="id_crossing_facilities">
            <option value="" disabled selected>Select</option>
            <option value="No physical crossing within 50 meters">No physical crossing within 50 meters</option>
            <option value="Pedestrian phase at traffic signal junction">Pedestrian phase at traffic signal junction</option>
            <option value="non-junction pedestrian crossing">Non-junction pedestrian crossing</option>
            <option value="Zebra crossing">Zebra crossing</option>
            <option value="Central refuge">Central refuge</option>
            <option value="Footbridge or subway">Footbridge or Subway</option>
        </select>

        <label for="id_second_road_class">Second Road Class</label>
    	<select name="f_second_road_class" id="id_second_road_class">
            <option value="" disabled selected>Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="-1">-1</option>
        </select>

        <label for="id_second_road_number">Second Road Number</label>
    	<input type="number" name="f_second_road_number" id="id_second_road_number">

        <label for="id_light_cond">Light Conditions</label>
    	<select name="f_light_cond" id="id_light_cond">
            <option value="" disabled selected>Select</option>
            <option value="Daylight: Street light present">Daylight: Street light present</option>
            <option value="Darkness: Street lights present and lit">Darkness: Street lights present and lit</option>
            <option value="Darkness: Street lights present but unlit">Darkness: Street lights present but unlit</option>
            <option value="Darkness: No street lighting">Darkness: No street lighting</option>
            <option value="Darkness: Street lighting unknown">Darkness: Street lighting unknown</option>
        </select>

        <label for="id_weather_cond">Weather Conditions</label>
    	<select name="f_weather_cond" id="id_weather_cond">
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

        <label for="id_rs_cond">Road Surface Conditions</label>
    	<select name="f_rs_cond" id="id_rs_cond">
            <option value="" disabled selected>Select</option>
            <option value="Dry">Dry</option>
            <option value="Wet/Damp">Wet/Damp</option>
            <option value="Snow">Snow</option>
            <option value="Frost/Ice">Frost/Ice</option>
            <option value="Flood (Over 3cm of water)">Flood (Over 3cm of water)</option>
        </select>

        <label for="id_spec_cond">Special Conditions at Site</label>
    	<select name="f_spec_cond" id="id_spec_cond">
            <option value="None">None</option>
            <option value="Roadworks">Roadworks</option>
            <option value="Mud">Mud</option>
            <option value="Ol or diesel">Ol or diesel</option>
            <option value="Road surface defective">Road surface defective</option>
            <option value="Auto traffic singal out">Auto traffic signal out</option>
            <option value="Permanent sign or marking defective or obscured">Permanent sign or marking defective or obscured</option>
            <option value="Auto traffic signal partly defective">Auto traffic signal partly defective</option>
        </select>

        <label for="id_carriageway_hazards">Carriageway Hazards</label>
    	<select name="f_carriageway_hazards" id="id_carriageway_hazards">
            <option value="None">None</option>
            <option value="1">Dislodged vehicle load in carriageway</option>
            <option value="2">Pedestrian in carriageway (not injured)</option>
            <option value="3">Any animal (except a ridden horse)</option>
            <option value="4">Involvement with previous accident</option>
            <option value="5">Other object in carriageway</option>
        </select>

        <label for="id_ur">Urban or Rural Area</label>
        <select name="f_ur" id="id_ur">
            <option value="" disabled selected>Select</option>
            <option value="1">Urban</option>
            <option value="2">Rural</option>
        </select>

        <label for="id_attend_scene">Did Police Attend Scene of Accident?</label>
    	<select name="f_attend_scene" id="id_attend_scene">
            <option value="Unknown">Unknown</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="id_LSOA">LSOA of Accident Location</label>
    	<input type="text" name="f_LSOA" id="id_LSOA" maxlength="15">
    	
    	<input type="submit" name="f_submit" value="Submit"></p>
    </form>
  </body>
</html>