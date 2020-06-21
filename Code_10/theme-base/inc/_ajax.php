<?php
// add ajax
function project_add_ajax()
{
  wp_enqueue_script('ajax_object-script', get_template_directory_uri() . '/js/ajax-object.js', array('jquery'));
  $script_data = array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'ajax_nonce' => wp_create_nonce('load_board_user_nonce'),
  );
  wp_localize_script('ajax_object-script', 'ajax_object', $script_data);
}
add_action('wp_enqueue_scripts', 'project_add_ajax');

// 회원게시판 ('load_board_user')
function load_board_user_callback()
{
  check_ajax_referer('load_board_user_nonce', 'ajax_nonce');
  $args_board_user = array(
    'post_type' => 'board_user',
    'posts_per_page' => 5,
    'paged' => $_POST['page'],
  );
  $query_board_user = new WP_Query($args_board_user);
  if ($query_board_user->have_posts()) {
    while ($query_board_user->have_posts()) {
      $query_board_user->the_post();
      get_template_part('partials/post-board_user');
    }
  }
  wp_die();
}
add_action('wp_ajax_load_board_user', 'load_board_user_callback');
add_action('wp_ajax_nopriv_load_board_user', 'load_board_user_callback');
