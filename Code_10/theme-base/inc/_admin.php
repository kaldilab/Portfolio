<?php
// remove welcome panel
remove_action('welcome_panel', 'wp_welcome_panel');

// admin add or remove
function project_admin_add_or_remove()
{
  // add custom css to editor
  add_editor_style('css/admin-editor.css');
  // 워드프레스 뉴스
  remove_meta_box('dashboard_primary', 'dashboard', 'normal');
  // 빠른 임시글
  remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
  // 사이트 현황
  // remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
  // 활동
  // remove_meta_box('dashboard_activity', 'dashboard', 'normal');
}
add_action('admin_init', 'project_admin_add_or_remove');

// remove admin menu
function project_remove_admin_menu()
{
  // remove_menu_page('edit.php');
}
add_action('admin_menu', 'project_remove_admin_menu');

// custom admin menu
function project_custom_admin_menu($menu_ord)
{
  if (!$menu_ord) return true;

  return array(
    'index.php',
    'main_settings',
    'about_settings',
    // separator1 
    'separator1',
    'edit.php?post_type=board_admin',
    'edit.php?post_type=board_user',
    'edit.php?post_type=board_approval',
    'edit.php?post_type=rent',
    'edit.php?post_type=program',
    'edit.php?post_type=campaign',
    'edit.php?post_type=calendar',
    'edit.php?post_type=request',
    'edit.php?post_type=kakaomap',
    'edit.php?post_type=cpt_recruit',
    'edit.php?post_type=privacy',
    'edit.php?post_type=terms',
    'edit.php?post_type=faq',
    // separator2 
    'separator2',
    'options-general.php',
    'themes.php',
    'plugins.php',
    'tools.php',
    'upload.php',
    'users.php',
    'edit.php?post_type=page',
    'edit.php',
    'edit-comments.php',
    // separator3
    'separator-last',
    'edit.php?post_type=acf-field-group',
    'ultimatemember',
    'theseoframework-settings',
    'itsec',
    'cptui_main_menu',
  );
}
add_filter('custom_menu_order', 'project_custom_admin_menu', 10, 1);
add_filter('menu_order', 'project_custom_admin_menu', 10, 1);

// remove user options
function project_remove_user_options()
{
  echo '<script>jQuery(document).ready(function($) {
$(\'form#your-profile > h2:first\').remove();
$(\'form#your-profile tr.user-rich-editing-wrap\').remove();
$(\'form#your-profile tr.user-admin-color-wrap\').remove();
$(\'form#your-profile tr.user-comment-shortcuts-wrap\').remove();
$(\'form#your-profile tr.user-admin-bar-front-wrap\').remove();
$(\'form#your-profile tr.user-language-wrap\').remove();
$(\'form#your-profile tr.user-first-name-wrap\').remove();
$(\'form#your-profile tr.user-last-name-wrap\').remove();
$(\'form#your-profile tr.user-syntax-highlighting-wrap\').remove();
$(\'table.form-table tr.user-url-wrap\').remove();
$(\'h2:contains("연락처 정보"), h2:contains("사용자 정보")\').remove();
$(\'h3:contains("얼티밋 멤버")\').remove();
$(\'label[for=um_set_verification]\').parents(".form-table").remove();
$(\'form#your-profile tr.user-description-wrap\').remove();
$(\'form#your-profile tr.user-profile-picture\').remove();
});</script>';
}
add_action('admin_head', 'project_remove_user_options');

// admin login logo
function project_admin_login_logo()
{
?>
  <style type="text/css">
    body.login div#login h1 a {
      background-image: url(<?php echo wp_get_upload_dir()['baseurl']; ?>/fbrfg/apple-touch-icon.png);
    }
  </style>
<?php
}
add_action('login_enqueue_scripts', 'project_admin_login_logo');
