<?php
// get field
$cpt_request = get_field('cpt_request', 'option');

// include
require get_template_directory() . '/inc/_admin.php';
require get_template_directory() . '/inc/_dashboard.php';
require get_template_directory() . '/inc/_enqueue.php';
require get_template_directory() . '/inc/_init.php';
require get_template_directory() . '/inc/_project.php';
require get_template_directory() . '/inc/_user.php';
require get_template_directory() . '/inc/_utility.php';
require get_template_directory() . '/inc/cpt/_board_common.php';
require get_template_directory() . '/inc/cpt/_board_card.php';
require get_template_directory() . '/inc/cpt/_board_blog.php';
require get_template_directory() . '/inc/cpt/_request.php';
require get_template_directory() . '/inc/cpt/_faq.php';
require get_template_directory() . '/inc/cpt/_rental.php';
