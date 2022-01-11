# Create triggers

USE collisions;

DROP TABLE IF EXISTS inserts_review;
CREATE TABLE IF NOT EXISTS inserts_review(
	review_id INT UNSIGNED AUTO_INCREMENT,
    collision_code INT,
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
    date_inserted DATETIME,
    PRIMARY KEY(review_id)
);

DROP TABLE IF EXISTS deletes_review;
CREATE TABLE IF NOT EXISTS deletes_review(
	deletes_id INT UNSIGNED AUTO_INCREMENT,
    collision_code INT,
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
    date_deleted DATETIME,
    PRIMARY KEY(deletes_id)
);

# Inserted data inserted into new table too

DROP TRIGGER IF EXISTS misc_info_after_insert;

DELIMITER //

CREATE TRIGGER misc_info_after_insert
AFTER INSERT
ON misc_info
FOR EACH ROW
BEGIN
    INSERT INTO inserts_review
    VALUES(DEFAULT,
			NEW.collision_code,
			NEW.location_easting_osgr,
			NEW.location_northing_osgr,
			NEW.longitude,
			NEW.latitude,
			NEW.accident_severity,
			NEW.number_of_vehicles,
			NEW.number_of_casualties,
			NEW.date_accident,
			NEW.time_accident,
			NEW.first_road_class,
			NEW.first_road_number,
			NEW.road_type,
			NEW.speed_limit,
			NEW.junction_detail,
			NEW.junction_control,
			NEW.pedestrian_crossing_human_control,
			NEW.pedestrian_crossing_physical_facilities,
			NEW.second_road_class,
			NEW.second_road_number,
			NEW.light_conditions,
			NEW.weather_conditions,
			NEW.road_surface_conditions,
			NEW.special_conditions_at_site,
			NEW.carriageway_hazards,
			NEW.urban_or_rural_area,
			NEW.did_police_officer_attend_scene_of_accident,
			NEW.lsoa_of_accident_location,
            NOW());
END //

DELIMITER ;

# Deleted data gets inserted into new table too

DROP TRIGGER IF EXISTS misc_info_after_delete;

DELIMITER //

CREATE TRIGGER misc_info_after_delete
AFTER DELETE
ON misc_info
FOR EACH ROW
BEGIN
    INSERT INTO deletes_review
    VALUES(DEFAULT,
			OLD.collision_code,
			OLD.location_easting_osgr,
			OLD.location_northing_osgr,
			OLD.longitude,
			OLD.latitude,
			OLD.accident_severity,
			OLD.number_of_vehicles,
			OLD.number_of_casualties,
			OLD.date_accident,
			OLD.time_accident,
			OLD.first_road_class,
			OLD.first_road_number,
			OLD.road_type,
			OLD.speed_limit,
			OLD.junction_detail,
			OLD.junction_control,
			OLD.pedestrian_crossing_human_control,
			OLD.pedestrian_crossing_physical_facilities,
			OLD.second_road_class,
			OLD.second_road_number,
			OLD.light_conditions,
			OLD.weather_conditions,
			OLD.road_surface_conditions,
			OLD.special_conditions_at_site,
			OLD.carriageway_hazards,
			OLD.urban_or_rural_area,
			OLD.did_police_officer_attend_scene_of_accident,
			OLD.lsoa_of_accident_location,
            NOW());
END //

DELIMITER ;