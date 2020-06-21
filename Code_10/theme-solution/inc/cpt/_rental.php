<?php
// get field
$cpt_setup_rental = get_field('cpt_setup_rental', 'option');
$cpt_setup_rental_set = $cpt_setup_rental['set'];

if ($cpt_setup_rental_set) {
  // Post Type: 대관
  function project_register_cpt_rental()
  {
    global $cpt_setup_rental;
    $labels = [
      "name" => __($cpt_setup_rental['name']),
      "singular_name" => __($cpt_setup_rental['name']),
      "all_items" => __($cpt_setup_rental['name'] . " 목록"),
    ];
    $args = [
      "label" => __($cpt_setup_rental['name']),
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
      "rewrite" => ["slug" => $cpt_setup_rental['slug'], "with_front" => true],
      "query_var" => true,
      "menu_icon" => "dashicons-store",
      "supports" => ["title"],
      'cptp_permalink_structure' => '%post_id%',
    ];
    register_post_type($cpt_setup_rental['slug'], $args);
  }
  add_action('init', 'project_register_cpt_rental');

  // Taxonomy: 대관 카테고리
  function project_register_tax_rental()
  {
    global $cpt_setup_rental;
    $tax_setup_rental = str_replace('cpt_', '', $cpt_setup_rental['slug']);
    $labels = [
      "name" => __($cpt_setup_rental['name'] . " 카테고리"),
      "singular_name" => __($cpt_setup_rental['name'] . " 카테고리"),
    ];
    $args = [
      "label" => __($cpt_setup_rental['name'] . " 카테고리"),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => true,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => ['slug' => 'tax_' . $tax_setup_rental, 'with_front' => true,],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "tax_" . $tax_setup_rental,
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
    ];
    register_taxonomy("tax_" . $tax_setup_rental, [$cpt_setup_rental['slug']], $args);
  }
  add_action('init', 'project_register_tax_rental');
}
