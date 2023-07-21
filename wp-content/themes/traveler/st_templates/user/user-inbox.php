<div class="st-create">
    <h2><?php esc_html_e("Inbox",'traveler') ?></h2>
</div>
<?php
$message = STInput::request('message_id');

if(!empty($message)){
    $message_data = ST_Inbox_Admin::inst()->get_message($message);
    $class = 'col-lg-8 col-md-7';
    $class2 = '';
    if(!empty($message_data["post_id"])){
        $booking_type = st_get_booking_option_type($message_data["post_id"]);
        if($booking_type == 'enquire'){
            $class = 'col-md-12';
            $class2 = 'd-none';
        } else {
        }?>
    <div class="row">
        <div class="<?php echo esc_attr($class);?>">
            <?php
            ST_Inbox_Admin::inst()->masked_as_read($message);
            echo st()->load_template('user/inbox/live',false,array('message_id'=>$message));
            ?>
        </div>
        <?php 
            if($class2 != 'd-none'){ ?>
                <div class="col-lg-4 col-md-5">
                    <?php
                    ST_Inbox::inst()->getFormBook($message);
                    ?>
                </div>
            <?php }
        ?>
        
    </div>
    <?php }?>
    <?php
}else{
    echo st()->load_template('user/inbox/list');
}
?>