INSERT IGNORE INTO `wp_st_location_nested` (`id`, `location_id`, `location_country`, `parent_id`, `left_key`, `right_key`, `name`, `fullname`, `language`, `status`) VALUES
(1, 0, NULL, 0, 1, 26, 'root', 'root', NULL, 'private_root'),
(2, 54, 'US', 1, 2, 25, 'United States', 'United States', 'en', 'publish'),
(3, 55, 'US', 2, 3, 4, 'California', 'California, United States', 'en', 'publish'),
(4, 56, 'US', 2, 5, 6, 'Los Angeles', 'Los Angeles, United States', 'en', 'publish'),
(5, 57, 'US', 2, 7, 8, 'Nevada', 'Nevada, United States', 'en', 'publish'),
(6, 58, 'US', 2, 9, 14, 'New Jersey', 'New Jersey, United States', 'en', 'publish'),
(7, 61, 'US', 2, 15, 16, 'New York City', 'New York City, United States', 'en', 'publish'),
(8, 62, 'US', 2, 17, 20, 'San Francisco', 'San Francisco, United States', 'en', 'publish'),
(9, 64, 'US', 2, 21, 24, 'Virginia', 'Virginia, United States', 'en', 'publish'),
(10, 59, 'US', 6, 10, 11, 'Delaware', 'Delaware, New Jersey, United States', 'en', 'publish'),
(11, 60, 'US', 6, 12, 13, 'Philadelphia', 'Philadelphia, New Jersey, United States', 'en', 'publish'),
(12, 63, 'US', 8, 18, 19, 'Wilmington', 'Wilmington, San Francisco, United States', 'en', 'publish'),
(13, 65, 'US', 9, 22, 23, 'Virginia Beach', 'Virginia Beach, Virginia, United States', 'en', 'publish');