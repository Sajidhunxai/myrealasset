<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 4/9/2019
 * Time: 3:05 PM
 */
$sc = STInput::get('sc');
?>
<div id="availablility_tab" class="partner-availability">
    <?php
    switch ($sc){
        case 'edit-tours':
            ?>
            <div class="row">
                <div class="col-md-12">
                    <?php echo st()->load_template('availability/form-tour'); ?>
                </div>
            </div>
            <?php
            break;
        case 'edit-activity':
            ?>
            <div class="row">
                <div class="col-md-12">
                    <?php echo st()->load_template('availability/form-activity'); ?>
                </div>
            </div>
            <?php
            break;
        case 'edit-rental':
            ?>
            <div class="row">
                <div class="col-md-12">
                    <?php echo st()->load_template('availability/form-rental'); ?>
                </div>
            </div>
            <?php
            break;
        case 'edit-flight':
            echo st()->load_template('availability/form-flight');
            break;
        default:
            ?>
            <div class="row">
                <?php if($sc != 'edit-rental'){
                    $post_id = STInput::get('id');
                    $std_value = get_post_meta($post_id, 'default_state', true);
                    ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3">
                            <div class="form-group">
                                <label for="default_state"><?php echo __('Default state','traveler') ?></label>
                                <select name="default_state" id="default_state" class="form-control">
                                    <option value="available" <?php echo selected($std_value, 'available'); ?>><?php echo __('Available', 'traveler') ?></option>
                                    <option value="not_available" <?php echo selected($std_value, 'not_available'); ?>><?php echo __('Not available', 'traveler') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-12">
                    <?php echo st()->load_template('availability/form'); ?>
                </div>
            </div>
            <?php
            break;
    }
    ?>
</div>
