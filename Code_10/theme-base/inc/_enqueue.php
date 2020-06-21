<?php
// add scripts
function project_add_scripts()
{
  // script
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-effects-core');
  wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.min.js', array('jquery'), null, true);
  wp_enqueue_script('fc_core-script', get_template_directory_uri() . '/node_modules/@fullcalendar/core/main.min.js', array('jquery'), null, true);
  wp_enqueue_script('fc_daygrid-script', get_template_directory_uri() . '/node_modules/@fullcalendar/daygrid/main.min.js', array('jquery'), null, true);
  wp_enqueue_script('fc_google-script', get_template_directory_uri() . '/node_modules/@fullcalendar/google-calendar/main.min.js', array('jquery'), null, true);
  wp_enqueue_script('fc_moment-script', get_template_directory_uri() . '/node_modules/@fullcalendar/moment/main.min.js', array('jquery'), null, true);
  wp_enqueue_script('fc_local-script', get_template_directory_uri() . '/node_modules/@fullcalendar/core/locales/ko.js', array('jquery'), null, true);
  wp_enqueue_script('vd_core-script', get_template_directory_uri() . '/node_modules/jquery-validation/dist/jquery.validate.min.js', array('jquery'), null, true);
  wp_enqueue_script('vd_add-script', get_template_directory_uri() . '/node_modules/jquery-validation/dist/additional-methods.min.js', array('jquery'), null, true);
  wp_enqueue_script('vd_local-script', get_template_directory_uri() . '/node_modules/jquery-validation/dist/localization/messages_ko.min.js', array('jquery'), null, true);
  wp_enqueue_script('swiper-script', get_template_directory_uri() . '/node_modules/swiper/js/swiper.min.js', array('jquery'), null, true);
  wp_enqueue_script('magnific-script', get_template_directory_uri() . '/node_modules/magnific-popup/dist/jquery.magnific-popup.min.js', array('jquery'), null, true);
  wp_enqueue_script('popup_cookie-script', get_template_directory_uri() . '/js/popup-cookie.js', array('jquery'), null, true);
  wp_enqueue_script('ajax_call-script', get_template_directory_uri() . '/js/ajax-call.js', array('jquery'), null, true);
  wp_enqueue_script('project-script', get_template_directory_uri() . '/js/project.js', array('jquery'), null, true);

  // style
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.min.css');
  wp_enqueue_style('fc_core', get_template_directory_uri() . '/node_modules/@fullcalendar/core/main.min.css');
  wp_enqueue_style('fc_daygrid', get_template_directory_uri() . '/node_modules/@fullcalendar/daygrid/main.min.css');
  wp_enqueue_style('swiper', get_template_directory_uri() . '/node_modules/swiper/css/swiper.min.css');
  wp_enqueue_style('magnific', get_template_directory_uri() . '/node_modules/magnific-popup/dist/magnific-popup.css');
  wp_enqueue_style('animate', get_template_directory_uri() . '/node_modules/animate.css/animate.min.css');
  wp_enqueue_style('project', get_template_directory_uri() . '/css/project.css');
}
add_action('wp_enqueue_scripts', 'project_add_scripts');
