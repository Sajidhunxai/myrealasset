<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Submit form
 *
 * Created by ShineTheme
 *
 */
$des = st()->get_option('submit_form_desc', 'off');
if ($des) {
    ?>
    <div class="pm-info">
        <div class="row">
            <div class="col-sm-6">
                <div class="col-card-info">
                    <?php echo balanceTags($des); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>