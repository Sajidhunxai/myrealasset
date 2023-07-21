<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/7/2019
 * Time: 11:41 AM
 */
$number_bed = get_post_meta(get_the_ID(), 'bed_number', true);
$number_bath = get_post_meta(get_the_ID(), 'bath_number', true);
$room_footage = get_post_meta(get_the_ID(), 'room_footage', true);
?>
<div class="facility">
    <ul>
        <?php if(!empty($number_bed)){ ?>
            <li>
                <?php echo TravelHelper::getNewIcon('ico_bed_1', '#333', '35px', '35px', true) ?>
                <?php
                $number_bed = esc_attr($number_bed);
                if($number_bed == 0)
                    echo __('No beds', 'traveler');
                elseif ($number_bed == 1)
                    echo sprintf(__('%d bed', 'traveler'), $number_bed);
                elseif ($number_bed > 1)
                    echo sprintf(__('%d beds', 'traveler'), $number_bed);
                ?>
            </li>
        <?php } ?>
        <?php if(!empty($room_footage)){ ?>
            <li>
                <?php echo TravelHelper::getNewIcon('ico_square_1', '#333', '35px', '35px', true) ?>
                <?php
                $room_footage = esc_attr($room_footage);
                echo esc_html($room_footage) .' '.__('m', 'traveler').'<sup>2</sup>';
                ?>
            </li>
        <?php } ?>
        <?php if(!empty($number_bath)){ ?>
            <li>
                <?php echo TravelHelper::getNewIcon('ico_bathroom_1', '#333', '35px', '35px', true) ?>
                <?php
                $number_bath = esc_attr($number_bath);
                if ($number_bath == 1)
                    echo sprintf(__('%d bathroom', 'traveler'), $number_bath);
                elseif ($number_bath > 1)
                    echo sprintf(__('%d bathrooms', 'traveler'), $number_bath);
                ?>
            </li>
        <?php } ?>
    </ul>
</div>

