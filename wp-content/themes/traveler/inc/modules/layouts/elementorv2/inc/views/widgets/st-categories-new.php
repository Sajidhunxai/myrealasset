<?php
$color = '#'.$array_merge[0];
$bg_rgba = st_hex2rgb_new($color , 0.06);
$text_rgba = st_hex2rgb_new($color , 1);
echo '<li><a href="'. $array_merge[1] .'" style="background: '. esc_attr($bg_rgba) .';color:'.esc_attr($text_rgba).'">'. esc_html($array_merge[2]) .'</a><span>'. esc_html($array_merge[3]) .'</span></li>';