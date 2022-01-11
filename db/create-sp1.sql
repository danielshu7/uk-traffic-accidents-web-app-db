# Create transaction

# Determine accident propensity index of a given road junction (first and second road)

DROP PROCEDURE IF EXISTS propensity_index;

DELIMITER $$

CREATE PROCEDURE propensity_index(IN first_road INT, IN second_road INT)
BEGIN

	# Accident propensity is calculated by the sum of the severities in that area divided by 100

	DECLARE first_road_requested INT;
	DECLARE second_road_requested INT;

	SET first_road_requested = first_road;
	SET second_road_requested = second_road;

	SELECT SUM(accident_severity) / 100 AS propensity_index
	FROM misc_info
	WHERE first_road_number = first_road_requested AND second_road_number = second_road_requested;

END $$

DELIMITER ;

# Sample call: low propensity (safe)
-- CALL propensity_index(310,0);

# Sample call: medium propensity (risky)
-- CALL propensity_index(500,0);

# Sample call: high propensity (highly dangerous)
-- CALL propensity_index(104,0);

# Determine accident propensity index of given travel date

DROP PROCEDURE IF EXISTS date_safety;

DELIMITER $$

CREATE PROCEDURE date_safety(IN anticipated_date_travel VARCHAR(10), IN anticipated_weather VARCHAR(50))
BEGIN

	DECLARE planned_date VARCHAR(7);
	DECLARE weather VARCHAR(50);
    DECLARE expected_avg_severity DOUBLE;
    DECLARE expected_avg_count INT UNSIGNED;
    DECLARE historical_avg_severity DOUBLE;
    DECLARE historical_count INT UNSIGNED;

	SET planned_date = SUBSTRING(DATE_FORMAT(anticipated_date_travel,'%d/%m/%Y'),1,5);
	SET weather = anticipated_weather;
    
    -- find average severity given weather conditions
    SELECT AVG(accident_severity)
    INTO expected_avg_severity
	FROM collisions.misc_info
	WHERE weather_conditions = weather;
    
    -- find average number of accidents in one day given weather conditions
	SELECT COUNT(*) / 365
    INTO expected_avg_count
	FROM collisions.misc_info
	WHERE weather_conditions = weather;
                          
	-- find our actual average severity and number of accidents on the planned date
    SELECT AVG(accident_severity), COUNT(*)
    INTO historical_avg_severity, historical_count
	FROM misc_info
	WHERE SUBSTRING(date_accident,1,5) = planned_date AND weather_conditions = weather;
	
    -- determine whether it will be safe or not (if either historical value is more than expected)
	IF (historical_avg_severity > expected_avg_severity OR historical_count > expected_avg_count)
	THEN 
		SELECT 'Historically dangerous. Choose another date';
	ELSE
		SELECT 'Historically safe. Good to go.';
	END IF;

END $$

DELIMITER ;

# Sample call
-- CALL date_safety('2021/01/01', 'Fine without high winds');
-- CALL date_safety('2021/02/01', 'Fine without high winds');


# helps collect frequency summary statistics of selected condition attribute
DROP PROCEDURE IF EXISTS find_freq;

DELIMITER //

CREATE PROCEDURE find_freq(attribute VARCHAR(45))
BEGIN
	SET @query = CONCAT('SELECT ', attribute, ' AS attribute, COUNT(*) AS freq FROM conditions ',
						'GROUP BY ', attribute, ' ORDER BY ', attribute);
	PREPARE stmt FROM @query;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

# Sample calls
-- CALL find_freq("year_accident");
-- CALL find_freq("day_of_week");
-- CALL find_freq("weather_conditions");



