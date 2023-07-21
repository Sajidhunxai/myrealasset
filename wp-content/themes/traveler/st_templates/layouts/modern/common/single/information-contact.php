<?php 
    $metakey_email = 'email';
    $metakey_website = 'website';
    $metakey_phone = 'phone';
    $metakey_efax = 'fax';
    $get_post_type = get_post_type(get_the_ID());
    switch ($get_post_type){
        case 'st_hotel':
            $metakey_email = 'email';
            $metakey_website = 'website';
            $metakey_phone = 'phone';
            $metakey_efax = 'fax';
            $information_contact = st()->get_option('hotel_information_contact','on');
            break;
        case 'st_tours':
            $metakey_email = 'contact_email';
            $metakey_website = 'website';
            $metakey_phone = 'phone';
            $metakey_efax = 'fax';
            $information_contact = st()->get_option('tour_information_contact','on');
            break;
        case 'st_activity':
            $metakey_email = 'contact_email';
            $metakey_website = 'contact_web';
            $metakey_phone = 'contact_phone';
            $metakey_efax = 'contact_fax';
            $information_contact = st()->get_option('activity_information_contact','on');
            break;
        case 'st_rental':
            $metakey_email = 'agent_email';
            $metakey_website = 'agent_website';
            $metakey_phone = 'agent_phone';
            $metakey_efax = 'st_fax';
            $information_contact = st()->get_option('rental_information_contact','on');
            break;
        case 'st_cars':
            $metakey_email = 'cars_email';
            $metakey_website = 'cars_website';
            $metakey_phone = 'cars_phone';
            $metakey_efax = 'cars_fax';
            $information_contact = st()->get_option('car_information_contact','on');
            break;
    }
    if($information_contact == 'on'){
        $email_infor = get_post_meta(get_the_ID(),$metakey_email,true);
        $website_infor = get_post_meta(get_the_ID(),$metakey_website,true);
        $phone_infor = get_post_meta(get_the_ID(),$metakey_phone,true);
        $fax_infor = get_post_meta(get_the_ID(),$metakey_efax,true);
        if(!empty($email_infor) || !empty($website_infor) || !empty($fax_infor) || !empty($phone_infor)){

        ?>
            <div class="d-none d-sm-block widget-box st-information-contact st-border-radius">
                <h4 class="heading"><?php echo __('Information Contact', 'traveler') ?></h4>
                <div class="media">
                    <?php 
                        if(!empty($email_infor)){ ?>
                            <h5 class="infor-heading">
                                <?php echo esc_html__('Email','traveler');?>
                            </h5>
                            <p>
                                <?php echo esc_html($email_infor);?>
                            </p>
                        <?php }
                    ?>
                    <?php 
                        if(!empty($website_infor)){ ?>
                            <h5 class="infor-heading">
                                <?php echo esc_html__('Website','traveler');?>
                            </h5>
                            <p>
                                <?php echo esc_html($website_infor);?>
                            </p>
                        <?php }
                    ?>
                    <?php 
                        if(!empty($phone_infor)){ ?>
                            <h5 class="infor-heading">
                                <?php echo esc_html__('Phone','traveler');?>
                            </h5>
                            <p>
                                <?php echo esc_html($phone_infor);?>
                            </p>
                        <?php }
                    ?>
                    <?php 
                        if(!empty($fax_infor)){ ?>
                            <h5 class="infor-heading">
                                <?php echo esc_html__('Fax','traveler');?>
                            </h5>
                            <p>
                                <?php echo esc_html($fax_infor);?>
                            </p>
                        <?php }
                    ?>
                </div>
            </div>
        <?php }
    }