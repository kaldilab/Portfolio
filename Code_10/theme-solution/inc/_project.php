<?php
// redirect
function project_redirect()
{
  if (is_page('static')) {
    wp_redirect(home_url('about'));
  } else if (is_page('boardadmin')) {
    wp_redirect(home_url('boardcommon'));
  } else if (is_page('apply')) {
    wp_redirect(home_url('request'));
  }
}
add_action('template_redirect', 'project_redirect');

// custom admin menu
function project_custom_admin_menu($menu_ord)
{
  // get theme
  $theme = wp_get_theme()->stylesheet;

  if ($theme == 'theme-origin') {
    $main_setting = $theme . '_settings';
  } else {
    $main_setting = $theme . '_main_settings';
  }

  if (!$menu_ord) return true;

  return array(
    'index.php',
    $main_setting,
    'about_settings',
    'history_settings',
    'people_settings',
    'location_settings',
    'business_settings',
    'favorite_settings',
    'etc_settings',
    'popup_settings',
    'seo_settings',
    // separator1 
    'separator1',
    'edit.php?post_type=board_common',
    'edit.php?post_type=board_card',
    'edit.php?post_type=board_blog',
    // separator2 
    'separator2',
    'edit.php?post_type=cpt_request',
    'edit.php?post_type=cpt_faq',
    'edit.php?post_type=cpt_rental',
    // separator-last
    'separator-last',
    'options-general.php',
    'nav-menus.php',
    'users.php',
    'upload.php',
    'themes.php',
    'edit.php?post_type=acf-field-group',
    'cpt_settings',
    'advanced_settings',
    'edit.php?post_type=page',
    'edit.php',
    'edit-comments.php',
    'plugins.php',
    'tools.php',
    'itsec',
  );
}
add_filter('custom_menu_order', 'project_custom_admin_menu', 10, 1);
add_filter('menu_order', 'project_custom_admin_menu', 10, 1);

// options page
if (function_exists('acf_add_options_page')) {
  // get theme
  $theme = wp_get_theme()->stylesheet;
  $user = wp_get_current_user()->user_login;
  $theme_name = str_replace('theme-', 'Theme', $theme);

  if (!($user == 'dev' || $user == 'slof' || $user == 'slofdev')) {
    $theme_check = '';
  } else {
    $theme_check = ' [' . $theme_name . ']';
  }

  if ($theme == 'theme-origin') {
    $page_title = 'DEV';
    $menu_title = 'DEV';
    $menu_slug = $theme . '_settings';
  } else {
    $page_title = '메인' . $theme_check;
    $menu_title = '메인' . $theme_check;
    $menu_slug = $theme . '_main_settings';
  }

  acf_add_options_page(array(
    'page_title'  => $page_title,
    'menu_title'  => $menu_title,
    'menu_slug'   => $menu_slug,
    'icon_url' => 'dashicons-admin-home',
  ));
  acf_add_options_page(array(
    'page_title'  => '기업및단체소개',
    'menu_title'  => '기업및단체소개',
    'menu_slug'   => 'about_settings',
    'icon_url' => 'dashicons-nametag',
  ));
  acf_add_options_page(array(
    'page_title'  => '연혁',
    'menu_title'  => '연혁',
    'menu_slug'   => 'history_settings',
    'icon_url' => 'dashicons-awards',
  ));
  acf_add_options_page(array(
    'page_title'  => '임직원',
    'menu_title'  => '임직원',
    'menu_slug'   => 'people_settings',
    'icon_url' => 'dashicons-groups',
  ));
  acf_add_options_page(array(
    'page_title'  => '오시는길',
    'menu_title'  => '오시는길',
    'menu_slug'   => 'location_settings',
    'icon_url' => 'dashicons-location-alt',
  ));
  acf_add_options_page(array(
    'page_title'  => '사업소개',
    'menu_title'  => '사업소개',
    'menu_slug'   => 'business_settings',
    'icon_url' => 'dashicons-products',
  ));
  acf_add_options_page(array(
    'page_title'  => '함께하는단체',
    'menu_title'  => '함께하는단체',
    'menu_slug'   => 'favorite_settings',
    'icon_url' => 'dashicons-building',
  ));
  acf_add_options_page(array(
    'page_title'  => '기타',
    'menu_title'  => '기타',
    'menu_slug'   => 'etc_settings',
    'icon_url' => 'dashicons-admin-generic',
  ));
  acf_add_options_page(array(
    'page_title'  => '팝업/탑배너',
    'menu_title'  => '팝업/탑배너',
    'menu_slug'   => 'popup_settings',
    'icon_url' => 'dashicons-slides',
  ));
  acf_add_options_page(array(
    'page_title'  => 'SEO',
    'menu_title'  => 'SEO',
    'menu_slug'   => 'seo_settings',
    'icon_url' => 'dashicons-code-standards',
  ));
  acf_add_options_page(array(
    'page_title'  => 'Custom PT',
    'menu_title'  => 'Custom PT',
    'menu_slug'   => 'cpt_settings',
    'icon_url' => 'dashicons-palmtree',
  ));
  acf_add_options_page(array(
    'page_title'  => 'Advanced',
    'menu_title'  => 'Advanced',
    'menu_slug'   => 'advanced_settings',
    'icon_url' => 'dashicons-layout',
  ));
}
