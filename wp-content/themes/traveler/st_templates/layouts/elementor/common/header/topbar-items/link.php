<?php $topbar_custom_class = isset( $val[ 'topbar_custom_class' ] ) ? $val[ 'topbar_custom_class' ] : '';?>
<li class="topbar-item link-item <?php echo esc_attr($topbar_custom_class);?>">
    <a href="<?php echo esc_url($val['topbar_custom_link']); ?>" class="login" data-bs-toggle="modal"
       data-target="#st-login-form"><?php echo esc_attr($val[ 'topbar_custom_link_title' ]); ?></a>
</li>
