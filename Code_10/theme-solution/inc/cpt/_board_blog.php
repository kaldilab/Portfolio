<?php
// get field
$cpt_setup_board_blog = get_field('cpt_setup_board_blog', 'option');

if ($cpt_setup_board_blog) {
  // Post Type: 블로그게시판
  function project_register_cpt_board_blog()
  {
    global $cpt_setup_board_blog;
    if ($cpt_setup_board_blog) {
      foreach ($cpt_setup_board_blog as $row) {
        $name = $row['name'];
        $slug = $row['slug'];
        $labels = [
          "name" => __($name),
          "singular_name" => __($name),
          "all_items" => __($name . " 목록"),
        ];
        $args = [
          "label" => __($name),
          "labels" => $labels,
          "description" => "blog",
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
          "rewrite" => ["slug" => $slug, "with_front" => true],
          "query_var" => true,
          "menu_icon" => "dashicons-excerpt-view",
          "supports" => ["title", "editor", "thumbnail"],
          "taxonomies" => ["post_tag"],
          'cptp_permalink_structure' => '%post_id%',
        ];
        register_post_type($slug, $args);
      }
    }
  }
  add_action('init', 'project_register_cpt_board_blog');

  // Taxonomy: 블로그게시판 카테고리
  function project_register_tax_board_blog()
  {
    global $cpt_setup_board_blog;
    if ($cpt_setup_board_blog) {
      foreach ($cpt_setup_board_blog as $row) {
        $name = $row['name'];
        $slug = $row['slug'];
        $labels = [
          "name" => __($name . " 카테고리"),
          "singular_name" => __($name . " 카테고리"),
        ];
        $args = [
          "label" => __($name . " 카테고리"),
          "labels" => $labels,
          "public" => true,
          "publicly_queryable" => true,
          "hierarchical" => true,
          "show_ui" => true,
          "show_in_menu" => true,
          "show_in_nav_menus" => true,
          "query_var" => true,
          "rewrite" => ['slug' => 'tax_' . $slug, 'with_front' => true,],
          "show_admin_column" => false,
          "show_in_rest" => true,
          "rest_base" => "tax_" . $slug,
          "rest_controller_class" => "WP_REST_Terms_Controller",
          "show_in_quick_edit" => false,
        ];
        register_taxonomy("tax_" . $slug, [$slug], $args);
      }
    }
  }
  add_action('init', 'project_register_tax_board_blog');
}
