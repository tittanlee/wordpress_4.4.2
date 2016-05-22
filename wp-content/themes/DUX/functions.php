<?php
// Require theme functions
require get_stylesheet_directory() . '/inc/fn.php';

#為摘要添加繼續閱讀
function junzibuqi_com_more_link($output) {
    if (!is_attachment()) {
        if (!has_excerpt()) {
            $output = mb_strimwidth($output, 0, 300);
        }
        $output .= '</p><a href="' . esc_url(get_permalink()) . '" class="gengduo">' . ' &rarr;[ 閱讀全文 ] &larr; </a>';
    }
    return $output;
}
add_filter('get_the_excerpt', 'junzibuqi_com_more_link');
// Customize your functions
