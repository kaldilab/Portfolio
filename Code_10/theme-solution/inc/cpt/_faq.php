<?php
// get field
$cpt_setup_faq = get_field('cpt_setup_faq', 'option');
$cpt_setup_faq_set = $cpt_setup_faq['set'];

if ($cpt_setup_faq_set) {
  // Post Type: 자주묻는질문
  function project_register_cpt_faq()
  {
    global $cpt_setup_faq;
    $labels = [
      "name" => __($cpt_setup_faq['name']),
      "singular_name" => __($cpt_setup_faq['name']),
      "all_items" => __($cpt_setup_faq['name'] . " 목록"),
    ];
    $args = [
      "label" => __($cpt_setup_faq['name']),
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
      "rewrite" => ["slug" => $cpt_setup_faq['slug'], "with_front" => true],
      "query_var" => true,
      "menu_icon" => "dashicons-format-chat",
      "supports" => ["title", "editor"],
      'cptp_permalink_structure' => '%post_id%',
    ];
    register_post_type($cpt_setup_faq['slug'], $args);
  }
  add_action('init', 'project_register_cpt_faq');

  // Taxonomy: 자주묻는질문 카테고리
  function project_register_tax_faq()
  {
    global $cpt_setup_faq;
    $tax_setup_faq = str_replace('cpt_', '', $cpt_setup_faq['slug']);
    $labels = [
      "name" => __($cpt_setup_faq['name'] . " 카테고리"),
      "singular_name" => __($cpt_setup_faq['name'] . " 카테고리"),
    ];
    $args = [
      "label" => __($cpt_setup_faq['name'] . " 카테고리"),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => true,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => ['slug' => 'tax_' . $tax_setup_faq, 'with_front' => true,],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "tax_" . $tax_setup_faq,
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
    ];
    register_taxonomy("tax_" . $tax_setup_faq, [$cpt_setup_faq['slug']], $args);
  }
  add_action('init', 'project_register_tax_faq');
}
