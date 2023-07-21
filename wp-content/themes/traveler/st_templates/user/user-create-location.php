<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User create location
 *
 * Created by ShineTheme
 *
 */
?>
<div class="st-create">
    <h2><?php _e("Create Location",'traveler') ?></h2>
</div>
<div class="msg">
    <?php echo STUser_f::get_msg(); ?>
</div>
<form action="#" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('user_setting','st_insert_post_location'); ?>
    <div class="form-group form-group-icon-left">
        
        <label for="title"><?php _e("Title",'traveler') ?></label>
        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
        <input id="title" name="st_title" type="text" placeholder="<?php _e("Title",'traveler') ?>" class="form-control">
        <div class="st_msg console_msg_title"></div>
    </div>
    <div class="form-group form-group-icon-left">
        <label for="st_content"><?php _e("Content",'traveler') ?></label>
        <?php wp_editor('','st_content'); ?>
    </div>
    <div class="form-group form-group-icon-left">
        <label for="desc"><?php _e("Description",'traveler') ?></label>
        <textarea id="desc" name="st_desc" class="form-control"></textarea>
        <div class="st_msg console_msg_desc"></div>
    </div>
    <h4><?php _e("Location Detail",'traveler') ?></h4>
    <div class="row">
        <?php $list_location = TravelerObject::get_list_location();?>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                
                <label for="post_parent"><?php _e("Parent",'traveler') ?></label>
                <i class="fa fa-cogs input-icon input-icon-hightlight"></i>
                <select name="post_parent" id="post_parent" class="form-control">
                    <option value="0"><?php _e("-- Select --", 'traveler') ?></option>
                    <?php if(!empty($list_location) and is_array($list_location)): ?>
                        <?php foreach($list_location as $k=>$v): ?>
                            <option value="<?php echo esc_html($v['id']) ?>">
                                <?php echo esc_html($v['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                
                <label for="is_featured"><?php _e("Set as Featured",'traveler') ?></label>
                <i class="fa fa-cogs input-icon input-icon-hightlight"></i>
                <select name="is_featured" id="is_featured" class="form-control">
                    <option value="on"><?php _e("Yes", 'traveler') ?></option>
                    <option value="off"><?php _e("No", 'traveler') ?></option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                
                <label for="zipcode"><?php _e("Zip Code" ,  'traveler') ?></label>
                <i class="fa fa-cogs input-icon input-icon-hightlight"></i>
                <input id="zipcode" name="zipcode" type="text"  class="form-control">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                
                <label for="map_lat"><?php _e("Latitude" , 'traveler') ?></label>
                <i class="fa  fa-rocket input-icon input-icon-hightlight"></i>
                <input id="map_lat" name="map_lat" type="text"  class="form-control">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                
                <label for="map_lng"><?php _e("Longitude" , 'traveler') ?></label>
                <i class="fa  fa-rocket input-icon input-icon-hightlight"></i>
                <input id="map_lng" name="map_lng" type="text"  class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label for="logo"><?php _e("Logo",'traveler') ?></label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            <?php _e("Browse…",'traveler') ?> <input name="logo"  type="file" >
                        </span>
                    </span>
                    <input type="text" readonly="" value="" class="form-control data_lable">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label for="logo"><?php _e("Featured Image",'traveler') ?></label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            <?php _e("Browse…",'traveler') ?> <input name="featured-image"  type="file" >
                        </span>
                    </span>
                    <input type="text" readonly="" value="" class="form-control data_lable">
                </div>
            </div>
        </div>
    </div>

    <input  type="button" id="btn_check_insert_post_type_location"  class="btn btn-primary" value="<?php _e("Create",'traveler') ?>">
    <input name="btn_insert_post_type_location" id="btn_insert_post_type_location" type="submit"  class="btn btn-primary hidden" hidden="" value="SUBMIT">
</form>
