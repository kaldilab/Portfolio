<?php
// add scripts
function project_add_scripts()
{
  // get theme
  $theme = wp_get_theme()->stylesheet;

  // script
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-effects-core');
  wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.min.js', array('jquery'), null, true);
  wp_enqueue_script('vd_core-script', get_template_directory_uri() . '/node_modules/jquery-validation/dist/jquery.validate.min.js', array('jquery'), null, true);
  wp_enqueue_script('vd_add-script', get_template_directory_uri() . '/node_modules/jquery-validation/dist/additional-methods.min.js', array('jquery'), null, true);
  wp_enqueue_script('vd_local-script', get_template_directory_uri() . '/node_modules/jquery-validation/dist/localization/messages_ko.min.js', array('jquery'), null, true);
  wp_enqueue_script('swiper-script', get_template_directory_uri() . '/node_modules/swiper/js/swiper.min.js', array('jquery'), null, true);
  if (in_array('cpt_rental', get_post_types())) {
    wp_enqueue_script('fc_core-script', get_template_directory_uri() . '/node_modules/@fullcalendar/core/main.min.js', array('jquery'), null, true);
    wp_enqueue_script('fc_daygrid-script', get_template_directory_uri() . '/node_modules/@fullcalendar/daygrid/main.min.js', array('jquery'), null, true);
    wp_enqueue_script('fc_moment-script', get_template_directory_uri() . '/node_modules/@fullcalendar/moment/main.min.js', array('jquery'), null, true);
    wp_enqueue_script('fc_local-script', get_template_directory_uri() . '/node_modules/@fullcalendar/core/locales/ko.js', array('jquery'), null, true);
  }
  wp_enqueue_script('popup_cookie-script', get_template_directory_uri() . '/js/popup-cookie.js', array('jquery'), null, true);
  wp_enqueue_script('project-script', get_template_directory_uri() . '/js/project.js', array('jquery'), null, true);
  if ($theme == 'theme-origin') {
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/js/' . get_field('dev_theme', 'option') . '.js', array('jquery'), null, true);
  } else {
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/js/' . $theme . '.js', array('jquery'), null, true);
  }

  // style
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.min.css');
  wp_enqueue_style('swiper', get_template_directory_uri() . '/node_modules/swiper/css/swiper.min.css');
  wp_enqueue_style('animate', get_template_directory_uri() . '/node_modules/animate.css/animate.min.css');
  wp_enqueue_style('xeicon', get_template_directory_uri() . '/node_modules/xeicon/xeicon.min.css');
  if (in_array('cpt_rental', get_post_types())) {
    wp_enqueue_style('fc_core', get_template_directory_uri() . '/node_modules/@fullcalendar/core/main.min.css');
    wp_enqueue_style('fc_daygrid', get_template_directory_uri() . '/node_modules/@fullcalendar/daygrid/main.min.css');
  }
  if ($theme == 'theme-origin') {
    wp_enqueue_style('theme', get_template_directory_uri() . '/css/' . get_field('dev_theme', 'option') . '.css');
  } else {
    wp_enqueue_style('theme', get_template_directory_uri() . '/css/' . $theme . '.css');
  }
}
add_action('wp_enqueue_scripts', 'project_add_scripts');
