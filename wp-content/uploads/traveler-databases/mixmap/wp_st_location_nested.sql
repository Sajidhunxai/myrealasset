INSERT IGNORE INTO `wp_st_location_nested` (`id`, `location_id`, `location_country`, `parent_id`, `left_key`, `right_key`, `name`, `fullname`, `language`, `status`) VALUES
(1, 0, NULL, 0, 1, 26, 'root', 'root', NULL, 'private_root'),
(2, 1957, 'US', 1, 2, 25, 'United States', 'United States', 'en', 'publish'),
(3, 275, 'US', 2, 3, 4, 'New York City', 'New York City, United States||10-14', 'en', 'publish'),
(4, 1944, 'US', 2, 5, 10, 'New Jersey', 'New Jersey, United States||900-961', 'en', 'publish'),
(5, 1947, 'US', 2, 11, 14, 'San Francisco', 'San Francisco, United States||899-899', 'en', 'publish'),
(6, 1952, 'US', 2, 15, 18, 'Virginia', 'Virginia, United States||220-246', 'en', 'publish'),
(7, 7965, 'US', 2, 19, 20, 'California', 'California, United States||900-961', 'en', 'publish'),
(8, 7967, 'US', 2, 21, 22, 'Los Angeles', 'Los Angeles, United States', 'en', 'publish'),
(9, 7970, 'US', 2, 23, 24, 'Nevada', 'Nevada, United States', 'en', 'publish'),
(10, 1945, 'US', 4, 6, 7, 'Philadelphia', 'Philadelphia, New Jersey, United States||90001–90068, 90070–90084, 90086–90089, 90091, 90093–90097, 90099', 'en', 'publish'),
(11, 1946, 'US', 4, 8, 9, 'Delaware', 'Delaware, New Jersey, United States||90001–90068, 90070–90084, 90086–90089, 90091, 90093–90097, 90099', 'en', 'publish'),
(12, 284, 'US', 5, 12, 13, 'Wilmington', 'Wilmington, San Francisco, United States', 'en', 'publish'),
(13, 282, 'US', 6, 16, 17, 'Virginia Beach', 'Virginia Beach, Virginia, United States', 'en', 'publish');
