<?php
// setup
function project_setup()
{
  // Menu
  register_nav_menu('main-menu', 'Main Menu');
  // register_nav_menu('sub-menu', 'Sub Menu');

  // support
  add_theme_support('title-tag');
  add_theme_support('html5');
  add_theme_support('post-thumbnails');
  add_theme_support('automatic-feed-links');

  // hide admin bar
  show_admin_bar(false);
}
add_action('after_setup_theme', 'project_setup');

// footer scripts
function project_footer_scripts()
{
?>
  <script>
    jQuery(document).ready(function($) {
      var deviceAgent = navigator.userAgent.toLowerCase();
      if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
        $("html").addClass("ios");
        $("html").addClass("mobile");
      }
      if (navigator.userAgent.search("MSIE") >= 0) {
        $("html").addClass("ie");
      } else if (navigator.userAgent.search("Chrome") >= 0) {
        $("html").addClass("chrome");
      } else if (navigator.userAgent.search("Firefox") >= 0) {
        $("html").addClass("firefox");
      } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
        $("html").addClass("safari");
      } else if (navigator.userAgent.search("Opera") >= 0) {
        $("html").addClass("opera");
      }
    });
  </script>
<?php
}
add_action('wp_footer', 'project_footer_scripts');

// add body class
function project_add_body_class($classes)
{
  if (is_singular('page')) {
    global $post;
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}
add_filter('body_class', 'project_add_body_class');

// disable the emoji's
function project_disable_emojis()
{
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'project_disable_emojis');
function disable_emojis_tinymce($plugins)
{
  if (is_array($plugins)) {
    return array_diff($plugins, array('wpemoji'));
  } else {
    return array();
  }
}

// mime type
// wp-config.php : define('ALLOW_UNFILTERED_UPLOADS', true);
function project_add_custom_mime_types($mimes)
{
  $mimes['hwp'] = 'application/hangul';
  return $mimes;
}
add_filter('upload_mimes', 'project_add_custom_mime_types');

// single page menu highlight
function project_single_page_current_class($classes, $item)
{
  global $post;
  if (is_single()) {
    $current_post_type = get_post_type_object(get_post_type($post->ID));
    $current_post_type_name = $current_post_type->name;
    if ($current_post_type_name == 'post') {
      $category = get_the_category();
      $category_slug = $category[0]->slug;
      $current_post_type_slug = 'category/' . $category_slug;
    } else {
      $current_post_type_slug = str_replace('_', '', $current_post_type_name);
    }
    $menu_slug = strtolower(trim($item->url));
    if (strpos($menu_slug, $current_post_type_slug) !== false) {
      $classes[] = 'current-menu-item';
    }
  }
  return $classes;
}
add_action('nav_menu_css_class', 'project_single_page_current_class', 10, 2);

// site title
function project_title_separator($sep)
{
  $sep = "|";
  return $sep;
}
add_filter('document_title_separator', 'project_title_separator');
