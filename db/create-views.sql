# Create views

USE collisions;

# Groups attributes related to accident severity:
# Accident severity on a scale of 1 to 3, count of involved vehicles,
# count of casualties 

CREATE OR REPLACE VIEW severity AS
SELECT accident_severity, number_of_vehicles, number_of_casualties
FROM misc_info;

# Groups attributes related to accident conditions: environmental
# and circumstancial factors, time/date/year, etc.

CREATE OR REPLACE VIEW conditions AS 
SELECT time_accident, 
		day_of_week, 
        year_accident, 
        junction_control, 
        pedestrian_crossing_physical_facilities, 
        light_conditions,
        weather_conditions,
        road_surface_conditions
FROM misc_info
        JOIN day_info USING(date_accident)
ORDER BY year_accident;
