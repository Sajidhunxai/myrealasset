<?php $check_enable_map_google = st()->get_option('st_googlemap_enabled');
$st_token_mapbox = st()->get_option('st_token_mapbox');
if ($check_enable_map_google === 'on') { ?>
    <div id="contact-map-new-agency" class="st-map-agency" data-lat="<?php echo trim($lat) ?>" data-lng="<?php echo trim($lng) ?>" data-icon="<?php echo esc_url($marker_icon['url']); ?>" data-disablecontrol="true" data-showcustomcontrol="true" data-style="<?php echo $style_map ?>">
        <?php if (!empty($pop_content_map)) { ?>
            <div class="box-content-map">
                <?php echo $pop_content_map; ?>
            </div>
        <?php } ?>
    </div>
<?php
} else { ?>
    <div id="contact-mapbox-new-agency" class="st-mapbox-agency" data-lat="<?php echo trim($lat) ?>" data-lng="<?php echo trim($lng) ?>" data-token="<?php echo $st_token_mapbox ?>" data-icon="<?php echo esc_url($marker_icon['url']); ?>" data-disablecontrol="true" data-showcustomcontrol="true" data-style="<?php echo $style_map ?>">
        <?php if (!empty($pop_content_map)) { ?>
            <div class="box-content-map">
                <?php echo $pop_content_map; ?>
            </div>
        <?php } ?>
    </div>
<?php }
?>