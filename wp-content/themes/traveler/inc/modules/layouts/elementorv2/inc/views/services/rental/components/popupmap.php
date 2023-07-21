<div class="map-view-popup style-2">
    <div class="close"><span class="stt-icon stt-icon-close"></span></div>
    <div class="search-move-map">
        <div class="st-icheck-item">
            <label for="st-move-map" class="c-grey">
                <input type="checkbox" name="movemap" id="st-move-map" value="1">
                <?php echo esc_html__('Search as I move the map', 'traveler'); ?>
                <span class="checkmark fcheckbox"></span>
            </label>
        </div>
        <input type="hidden" name="st-map-coordinate" value="" id="st-map-coordinate"/>
    </div>
    <div id="map-search-form" class="map-full-height" data-disablecontrol="true" data-showcustomcontrol="true" data-zoom="13"></div>
</div>