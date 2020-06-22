<?php
// admin add or remove
function project_admin_add_or_remove()
{
  // add custom css to editor
  add_editor_style('css/admin-editor.css');

  // remove options page
  $current_user = wp_get_current_user()->user_login;
  if (!($current_user == 'dev' || $current_user == 'test' || $current_user == 'testdev')) {
    remove_menu_page('cpt_settings');
    remove_menu_page('advanced_settings');
  }
}
add_action('admin_init', 'project_admin_add_or_remove');

// remove admin menu
function project_remove_admin_menu()
{
  $current_user = wp_get_current_user()->user_login;
  if (!($current_user == 'dev' || $current_user == 'test' || $current_user == 'testdev')) {
    add_menu_page(
      '메뉴',
      '메뉴',
      'edit_theme_options',
      'nav-menus.php',
      '',
      'dashicons-menu-alt',
    );
    remove_menu_page('themes.php');
    remove_menu_page('edit.php?post_type=acf-field-group');
    remove_menu_page('edit.php?post_type=page');
    remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');
    remove_menu_page('plugins.php');
    remove_menu_page('tools.php');
    remove_menu_page('itsec');
    remove_submenu_page('index.php', 'update-core.php');
  }
}
add_action('admin_menu', 'project_remove_admin_menu');

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

// remove help tabs
function project_remove_help_tabs()
{
  get_current_screen()->remove_help_tabs();
}
add_action('admin_head', 'project_remove_help_tabs');

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

// admin bar
function project_admin_bar()
{
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
  $wp_admin_bar->remove_menu('comments');
  $wp_admin_bar->remove_menu('new-content');
  $wp_admin_bar->remove_menu('archive');
}
add_action('wp_before_admin_bar_render', 'project_admin_bar', 0);

// project admin footer
function project_change_footer_text()
{
  echo '<span id="footer-thankyou">홈페이지를 이용해주셔서 감사합니다.</span>';
}
add_filter('admin_footer_text', 'project_change_footer_text');
add_filter('update_footer',     '__return_empty_string', 11);

// admin footer
function project_admin_footer()
{
  global $pagenow;
  // menu page
  if ($pagenow === 'nav-menus.php') {
  ?>
    <style type="text/css">
      #side-sortables .control-section,
      .nav-tab-wrapper,
      .manage-menus {
        display: none;
      }

      #side-sortables .control-section.add-post-type-page {
        display: block;
      }
    </style>
  <?php
  }
  // request page
  if (($pagenow === 'post.php') && (isset($_GET['post'])) && (get_post_type($_GET['post']) === 'cpt_request')) {
  ?>
    <script>
      jQuery('.acf-field').each(function() {
        jQuery(this).find('input[type=text], input[type=email], input[type=checkbox], textarea').attr('readonly', 'readonly');
        jQuery(this).find('input[type=checkbox]').attr('onclick', 'return false;');
      });
    </script>
  <?php
  }
  // all page
  ?>
  <style type="text/css">
    #wp-admin-bar-itsec_admin_bar_menu {
      display: none;
    }
  </style>
  <?php
  // user check
  $current_user = wp_get_current_user()->user_login;
  if (!($current_user == 'dev' || $current_user == 'test' || $current_user == 'testdev')) {
  ?>
    <style type="text/css">
      .acf-postbox>.hndle .acf-hndle-cog {
        display: none !important;
      }
    </style>
<?php
  }
}
add_action('admin_footer', 'project_admin_footer');
