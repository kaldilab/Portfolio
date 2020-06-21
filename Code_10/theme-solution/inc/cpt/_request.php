<?php
// get field
$cpt_setup_request = get_field('cpt_setup_request', 'option');
$cpt_setup_request_set = $cpt_setup_request['set'];

if ($cpt_setup_request_set) {
  // Post Type: 문의하기
  function project_register_cpt_request()
  {
    global $cpt_setup_request;
    $labels = [
      "name" => __($cpt_setup_request['name']),
      "singular_name" => __($cpt_setup_request['name']),
      "all_items" => __($cpt_setup_request['name'] . " 목록"),
    ];
    $args = [
      "label" => __($cpt_setup_request['name']),
      "labels" => $labels,
      "description" => "",
      "public" => true,
      "publicly_queryable" => true,
      "show_ui" => true,
      "show_in_rest" => true,
      "rest_base" => "",
      "rest_controller_class" => "WP_REST_Posts_Controller",
      "has_archive" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "delete_with_user" => false,
      "exclude_from_search" => false,
      "capability_type" => "post",
      "map_meta_cap" => true,
      "hierarchical" => false,
      "rewrite" => ["slug" => $cpt_setup_request['slug'], "with_front" => true],
      "query_var" => true,
      "menu_icon" => "dashicons-format-status",
      "supports" => ["title"],
      'cptp_permalink_structure' => '%post_id%',
    ];
    register_post_type($cpt_setup_request['slug'], $args);
  }
  add_action('init', 'project_register_cpt_request');
}
