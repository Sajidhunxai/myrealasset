<?php 
if (check_using_elementor()){ 
    echo st()->load_template('layouts/elementor/common/header-member');
    
} else {
    echo st()->load_template('layouts/modern/common/header-member');
}