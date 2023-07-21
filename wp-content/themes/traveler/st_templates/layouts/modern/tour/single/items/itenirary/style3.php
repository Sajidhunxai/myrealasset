<?php
$tour_programs = get_post_meta(get_the_ID(), 'tours_program', true);
if (!empty($tour_programs)) {
    foreach ($tour_programs as $k => $v) {
        ?>
        <div class="item active">
            <?php
                if(!empty($v['image'])){
                    echo '<div class="icon">';
                    echo '<img src="'. esc_url($v['image']) .'" alt="' . __('Itenirary', 'traveler') .'" />';
                    echo '</div>';
                }
            ?>
            <h5><?php echo balanceTags($v['title']); ?></h5>
            <div class="body">
                <?php echo balanceTags(nl2br($v['desc'])); ?>
            </div>
        </div>
        <?php
    }
}