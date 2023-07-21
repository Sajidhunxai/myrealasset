<div class="helios-room-info style-1">

    <div class="title">

        <?php the_title() ?>

    </div>

    <div class="info">

        <?php

        if ( get_post_meta( get_the_ID(), 'price_by_per_person', true ) == 'on' ) : ?>

            <p><?php esc_html_e("Adult Price",'traveler') ?></p>

            <div class="price">

                <?php

                $adult_price = get_post_meta(get_the_ID(),'adult_price',true);

                echo TravelHelper::format_money($adult_price); ?><span class="small"><?php esc_html_e("/person/night", 'traveler') ?></span>

            </div>

            <p><?php esc_html_e("Child Price",'traveler') ?></p>

            <div class="price">

                <?php

                $child_price = get_post_meta(get_the_ID(),'child_price',true);

                echo TravelHelper::format_money($child_price); ?><span class="small"><?php esc_html_e("/person/night", 'traveler') ?></span>

            </div>

            <?php

        else: ?>

            <p><?php esc_html_e("Price",'traveler') ?></p>

            <div class="price">

                <?php $price = get_post_meta(get_the_ID(),'price',true);echo TravelHelper::format_money($price); ?><span class="small"><?php esc_html_e("/night", 'traveler') ?></span>

            </div>

            <?php

        endif; ?>

    </div>

    <div class="info">

        <div class="guest">

            <?php

            $number_adult = get_post_meta(get_the_ID(), 'adult_number', true);

            if (!empty($number_adult)) {

                ?>

                <p><?php esc_html_e("ADULT",'traveler') ?></p>

                <?php echo esc_attr( sprintf("%02d", $number_adult) ); ?>

            <?php } ?>

        </div>

        <div class="guest">

            <?php

            $number_child = get_post_meta(get_the_ID(), 'children_number', true);

            if (!empty($number_child)) {

                ?>

                <p><?php esc_html_e("CHILDREN",'traveler') ?></p>

                <?php echo esc_attr( sprintf("%02d", $number_child) ); ?>

            <?php } ?>

        </div>

        <div class="bed">

            <?php

            $bed_rooms = get_post_meta(get_the_ID(),'bed_number',true);

            if(!empty($bed_rooms)){

                ?>

                <p><?php esc_html_e("BEDS",'traveler') ?></p>

                <?php echo esc_attr( sprintf("%02d", $bed_rooms) ); ?>

            <?php } ?>

        </div>

        <div class="size">

            <p><?php esc_html_e("SIZE",'traveler') ?></p>

            <?php

            $room_size = get_post_meta(get_the_ID(),'room_footage',true);

            if(!empty($room_size)) {

                echo esc_attr( sprintf("%02d", $room_size) );

                echo '<span>';

                echo ' m<sup>2</sup>';

                echo '</span>';

            }

            ?>

        </div>

    </div>

</div>

