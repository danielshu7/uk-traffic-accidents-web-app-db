-- Michelle Zhu and Daniel Shu

DROP DATABASE IF EXISTS collisions;
CREATE DATABASE IF NOT EXISTS collisions;
USE collisions;

# Data Source: accidents_2012_to_2014.csv from 
# https://www.kaggle.com/daveianhickey/2000-16-traffic-flow-england-scotland-wales?select=accidents_2012_to_2014.csv

DROP TABLE IF EXISTS collision_data;
CREATE TABLE IF NOT EXISTS collision_data (
accident_index VARCHAR(17),
location_easting_osgr INT,
location_northing_osgr INT,
longitude FLOAT,
latitude FLOAT,
police_force INT UNSIGNED,
accident_severity TINYINT(1) UNSIGNED,
number_of_vehicles SMALLINT(4) UNSIGNED,
number_of_casualties SMALLINT(4) UNSIGNED,
date_accident VARCHAR(12),
day_of_week TINYINT(1) UNSIGNED,
time_accident VARCHAR(6),
local_authority_district SMALLINT UNSIGNED,
local_authority_highway VARCHAR(17),
first_road_class TINYINT UNSIGNED,
first_road_number INT UNSIGNED,
road_type VARCHAR(70),
speed_limit TINYINT(3) UNSIGNED,
junction_detail VARCHAR(40),
junction_control VARCHAR(60),
second_road_class TINYINT,
second_road_number INT,
pedestrian_crossing_human_control VARCHAR(70),
pedestrian_crossing_physical_facilities VARCHAR(70),
light_conditions VARCHAR(60),
weather_conditions VARCHAR(70),
road_surface_conditions VARCHAR(40),
special_conditions_at_site VARCHAR(70),
carriageway_hazards VARCHAR(80),
urban_or_rural_area TINYINT(2) UNSIGNED,
did_police_officer_attend_scene_of_accident VARCHAR(10),
lsoa_of_accident_location VARCHAR(15),
year_accident INT UNSIGNED
);

LOAD DATA INFILE 'accidents_2012_to_2014.csv'
INTO TABLE collision_data
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
-- Ignore header row
IGNORE 1 LINES;

-- Add additional autoincrement index (data broken in original dataset)

ALTER TABLE collision_data
ADD collision_code INT AUTO_INCREMENT FIRST,
ADD PRIMARY KEY(collision_code);

-- CREATE and INSERT table 1: misc_info

DROP TABLE IF EXISTS misc_info;
CREATE TABLE IF NOT EXISTS misc_info (
collision_code INT AUTO_INCREMENT,
accident_index VARCHAR(17),
location_easting_osgr INT,
location_northing_osgr INT,
longitude FLOAT,
latitude FLOAT,
accident_severity TINYINT(1) UNSIGNED,
number_of_vehicles SMALLINT(4) UNSIGNED,
number_of_casualties SMALLINT(4) UNSIGNED,
date_accident VARCHAR(12),
time_accident VARCHAR(6),
first_road_class TINYINT UNSIGNED,
first_road_number INT UNSIGNED,
road_type VARCHAR(70),
speed_limit TINYINT(3) UNSIGNED,
junction_detail VARCHAR(40),
junction_control VARCHAR(60),
pedestrian_crossing_human_control VARCHAR(70),
pedestrian_crossing_physical_facilities VARCHAR(70),
second_road_class TINYINT,
second_road_number INT,
light_conditions VARCHAR(60),
weather_conditions VARCHAR(70),
road_surface_conditions VARCHAR(40),
special_conditions_at_site VARCHAR(70),
carriageway_hazards VARCHAR(80),
urban_or_rural_area TINYINT(2) UNSIGNED,
did_police_officer_attend_scene_of_accident VARCHAR(10),
lsoa_of_accident_location VARCHAR(15),
review_flag BIT(1),
PRIMARY KEY(collision_code)
);

INSERT INTO misc_info
SELECT collision_code,
accident_index,
location_easting_osgr,
location_northing_osgr,
longitude,
latitude,
accident_severity,
number_of_vehicles,
number_of_casualties,
date_accident,
time_accident,
first_road_class,
first_road_number,
road_type,
speed_limit,
junction_detail,
junction_control,
pedestrian_crossing_human_control,
pedestrian_crossing_physical_facilities,
second_road_class,
second_road_number,
light_conditions,
weather_conditions,
road_surface_conditions,
special_conditions_at_site,
carriageway_hazards,
urban_or_rural_area,
did_police_officer_attend_scene_of_accident,
lsoa_of_accident_location,
0
FROM collision_data;

-- CREATE and INSERT table 2: day_info

DROP TABLE IF EXISTS day_info;
CREATE TABLE IF NOT EXISTS day_info (
date_accident VARCHAR(12),
day_of_week TINYINT(1) UNSIGNED,  -- note that day 1 of week is Sunday
year_accident INT UNSIGNED,
PRIMARY KEY(date_accident)
);

INSERT INTO day_info
SELECT DISTINCT date_accident, day_of_week,year_accident
FROM collision_data;

-- CREATE and INSERT table 3: local_info 

DROP TABLE IF EXISTS local_info;
CREATE TABLE IF NOT EXISTS local_info (
location_easting_osgr FLOAT,
location_northing_osgr FLOAT,
date_accident VARCHAR(12),
police_force INT UNSIGNED,
PRIMARY KEY(location_easting_osgr,location_northing_osgr, date_accident)
);

INSERT INTO local_info
SELECT DISTINCT location_easting_osgr, location_northing_osgr, date_accident, police_force
FROM collision_data;

-- CREATE and INSERT table 4: local_authority_info 

DROP TABLE IF EXISTS local_authority_info;
CREATE TABLE IF NOT EXISTS local_authority_info (
longitude FLOAT,
latitude FLOAT,
date_accident VARCHAR(12),
local_authority_highway VARCHAR(17),
local_authority_district SMALLINT UNSIGNED,
PRIMARY KEY(longitude,latitude, date_accident)
);

INSERT INTO local_authority_info
SELECT DISTINCT longitude, latitude, date_accident, local_authority_highway,local_authority_district
FROM collision_data;





