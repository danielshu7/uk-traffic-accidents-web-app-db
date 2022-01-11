<?php
require_once("conn.php");

$query0 = "SELECT COUNT(*) AS count,
            AVG(accident_severity) AS avg_severity, 
            AVG(number_of_vehicles) AS avg_vehicles,
            AVG(number_of_casualties) AS avg_casualties
           FROM severity";

try
    {
      // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
      $prepared_stmt0 = $dbo->prepare($query0);
      $prepared_stmt0->execute();
      // Fetch all the values based on query and save that to variable $result
      $result0 = $prepared_stmt0->fetchAll();
      $var_count = $result0[0]["count"];
    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $query0 . "<br>" . $ex->getMessage(); // HTTP 500 - Internal Server Error
    }
?>

<?php
$attr_arr = Array('year_accident','day_of_week','junction_control','pedestrian_crossing_physical_facilities',
                  'light_conditions','weather_conditions','road_surface_conditions');
$result_arr = [];

foreach ($attr_arr as $attr) {
    $query = "CALL find_freq(:ph_attr)";

    try
        {
          // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
          $prepared_stmt = $dbo->prepare($query);
          $prepared_stmt->bindValue(':ph_attr', $attr, PDO::PARAM_STR);
          $prepared_stmt->execute();
          // Fetch all the values based on query and save that to variable $result
          array_push($result_arr, $prepared_stmt->fetchAll());
        }
        catch (PDOException $ex)
        { // Error in database processing.
          echo $query . "<br>" . $ex->getMessage(); // HTTP 500 - Internal Server Error
        }
    
} ?>

<html>
<!-- Any thing inside the HEAD tags are not visible on page.-->
  <head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
    <link rel="stylesheet" type="text/css" href="project.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head> 
<!-- Everything inside the BODY tags are visible on page.-->
  <body>
  <div class="header" id="myHeader">
			<div id="navbar">
				<ul class="absolute">
					<li><a href="index.html">Home</a></li>
					<li><a href="statistics.php">Summary Statistics</a></li>
					<li><a href="travelPlanner.php">Travel Planner</a></li>
					<li><a href="searchAccidents.php">Search Accidents</a></li>
					<li><a href="insertAccidents.php">Report an Accident</a></li>
					<li><a href="flagAccidents.php">Faulty Entry Report</a></li>
				</ul>
			</div>
		  </div>
    
    <h1> Statistics</h1>
    
    <h3>
         Total Number of Accident Records: <?php echo $var_count; ?>
    </h3>

    <p class="bold">
        Average Severity: <?php echo $result0[0]["avg_severity"]; ?> on scale of 1 to 3 <br>
        Average Number of Vehicles Involved: <?php echo $result0[0]["avg_vehicles"]; ?> <br>
        Average Number of Casualties: <?php echo $result0[0]["avg_casualties"]; ?> <br>
    </p>

    <div class="chart-container">
      <canvas id="id_year_chart"></canvas>
      <script>
      const colors = ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850", "#FFFF00", "#964B00", "#FFA500", "#00FFFF"]
      const tot_count = <?php echo json_encode($var_count); ?>;

      var data_labels = <?php echo json_encode(array_column($result_arr[0],"attribute")); ?>;
      var data_values = <?php echo json_encode(array_column($result_arr[0],"freq")); ?>;
      data_values = data_values.map(i => i / tot_count * 100);
      var DATA_COUNT = data_values.length;


      var data = {
              labels: data_labels,
              datasets: [{
                label: "% Accidents",
                backgroundColor: colors.slice(0,DATA_COUNT),
                data: data_values
              }]
            };

      var config = {
            type: 'pie',
            data: data,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Year (%)'
                    }
                  }
            }
        };

      new Chart(document.getElementById("id_year_chart"), config);
    </script>
    </div>

    <div class="chart-container">
      <canvas id="id_day_chart"></canvas>
      <script>

      var data_labels = <?php echo json_encode(array_column($result_arr[1],"attribute")); ?>;
      var label_map = {1:"Sunday",2:"Monday",3:"Tuesday",4:"Wednesday",5:"Thursday",6:"Friday",7:"Saturday"};
      data_labels = data_labels.map(i => label_map[i]);
      var data_values = <?php echo json_encode(array_column($result_arr[1],"freq")); ?>;
      data_values = data_values.map(i => i / tot_count * 100);
      var DATA_COUNT = data_values.length;


      var data = {
              labels: data_labels,
              datasets: [{
                label: "% Accidents",
                backgroundColor: colors.slice(0,DATA_COUNT),
                data: data_values
              }]
            };

      var config = {
            type: 'pie',
            data: data,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Day of Week (%)'
                    }
                  }
            }
        };

      new Chart(document.getElementById("id_day_chart"), config);
    </script>
    </div>

    <div class="chart-container">
      <canvas id="id_junc_ctl_chart"></canvas>
      <script>

      var data_labels = <?php echo json_encode(array_column($result_arr[2],"attribute")); ?>;
      data_labels[0] = "Unknown";
      var data_values = <?php echo json_encode(array_column($result_arr[2],"freq")); ?>;
      data_values = data_values.map(i => i / tot_count * 100);
      var DATA_COUNT = data_values.length;


      var data = {
              labels: data_labels,
              datasets: [{
                label: "% Accidents",
                backgroundColor: colors.slice(0,DATA_COUNT),
                data: data_values
              }]
            };

      var config = {
            type: 'pie',
            data: data,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Junction Control Type (%)'
                    }
                  }
            }
        };

      new Chart(document.getElementById("id_junc_ctl_chart"), config);
    </script>
    </div>

    <div class="chart-container">
      <canvas id="id_cross_facility_chart"></canvas>
      <script>

      var data_labels = <?php echo json_encode(array_column($result_arr[3],"attribute")); ?>;
      var data_values = <?php echo json_encode(array_column($result_arr[3],"freq")); ?>;
      data_values = data_values.map(i => i / tot_count * 100);
      var DATA_COUNT = data_values.length;


      var data = {
              labels: data_labels,
              datasets: [{
                label: "% Accidents",
                backgroundColor: colors.slice(0,DATA_COUNT),
                data: data_values
              }]
            };

      var config = {
            type: 'pie',
            data: data,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Pedestrian Crossing Physcial Facilities (%)'
                    }
                  }
            }
        };

      new Chart(document.getElementById("id_cross_facility_chart"), config);
    </script>
    </div>

    <div class="chart-container">
      <canvas id="id_light_cond_chart"></canvas>
      <script>

      var data_labels = <?php echo json_encode(array_column($result_arr[4],"attribute")); ?>;
      var data_values = <?php echo json_encode(array_column($result_arr[4],"freq")); ?>;
      data_values = data_values.map(i => i / tot_count * 100);
      var DATA_COUNT = data_values.length;


      var data = {
              labels: data_labels,
              datasets: [{
                label: "% Accidents",
                backgroundColor: colors.slice(0,DATA_COUNT),
                data: data_values
              }]
            };

      var config = {
            type: 'pie',
            data: data,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Light Conditions (%)'
                    }
                  }
            }
        };

      new Chart(document.getElementById("id_light_cond_chart"), config);
    </script>
    </div>

    <div class="chart-container">
      <canvas id="id_weather_cond_chart"></canvas>
      <script>

      var data_labels = <?php echo json_encode(array_column($result_arr[5],"attribute")); ?>;
      data_labels.push(data_labels.splice(3, 1)[0]);
      var data_values = <?php echo json_encode(array_column($result_arr[5],"freq")); ?>;
      data_values = data_values.map(i => i / tot_count * 100);
      data_values.push(data_values.splice(3, 1)[0]);
      var DATA_COUNT = data_values.length;


      var data = {
              labels: data_labels,
              datasets: [{
                label: "% Accidents",
                backgroundColor: colors.slice(0,DATA_COUNT),
                data: data_values
              }]
            };

      var config = {
            type: 'pie',
            data: data,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Weather Conditions (%)'
                    }
                  }
            }
        };

      new Chart(document.getElementById("id_weather_cond_chart"), config);
    </script>
    </div>

    <div class="chart-container">
      <canvas id="id_rs_cond_chart"></canvas>
      <script>

      var data_labels = <?php echo json_encode(array_column($result_arr[6],"attribute")); ?>;
      data_labels[0] = "Unknown";
      var data_values = <?php echo json_encode(array_column($result_arr[6],"freq")); ?>;
      data_values = data_values.map(i => i / tot_count * 100);
      var DATA_COUNT = data_values.length;


      var data = {
              labels: data_labels,
              datasets: [{
                label: "% Accidents",
                backgroundColor: colors.slice(0,DATA_COUNT),
                data: data_values
              }]
            };

      var config = {
            type: 'pie',
            data: data,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Road Surface Conditions (%)'
                    }
                  }
            }
        };

      new Chart(document.getElementById("id_rs_cond_chart"), config);
    </script>

    <footer></footer>
    </div>
  </body>
</html>






