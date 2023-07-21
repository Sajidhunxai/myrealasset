
<div class="st-field-<?php echo esc_attr($data['type']); ?>">
    <?php
        if(!empty($data['label'])){
            echo '<p class="st-group-heading">'. esc_html($data['label']) .'</p>';
        }

        if(!empty($data['fields'])){
            echo '<div class="row">';
            foreach ($data['fields'] as $k => $v){
                if(isset($v['type']) && !empty($v['type'])){
                    $class_col = 'col-lg-12';
                    if(!empty($v['col']))
                        $class_col = 'col-lg-' . $v['col'];
                    ?>
                    <div class="<?php echo esc_attr($class_col); ?> st-partner-field-item">
                        <?php echo st()->load_template('fields/' . esc_html($v['type']), '', array('data' => $v, 'post_id' => $post_id)); ?>
                    </div>
                    <?php
                }
                
            }
            echo '</div>';
        }
    ?>

</div>


