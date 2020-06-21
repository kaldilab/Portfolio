<?php
// update featured image
function acf_update_featured_image($value, $post_id)
{
  update_post_meta($post_id, '_thumbnail_id', $value);
  return $value;
}
add_filter('acf/update_value/name=board_user_image', 'acf_update_featured_image', 10, 3);
add_filter('acf/update_value/name=board_approval_image', 'acf_update_featured_image', 10, 3);

// change title field label
function acf_change_field_label_title($field)
{
  $field['label'] = "제목";
  return $field;
}
add_filter('acf/prepare_field/name=_post_title', 'acf_change_field_label_title');
function acf_change_field_label_content($field)
{
  $field['label'] = "내용";
  return $field;
}
add_filter('acf/prepare_field/name=_post_content', 'acf_change_field_label_content');

// change validate value
function acf_change_validate_value($valid, $value, $field)
{
  if (empty($value) && $field['required']) {
    $valid = '필수 항목입니다.';
  }
  return $valid;
}
add_filter('acf/validate_value', 'acf_change_validate_value', 10, 4);
// add_filter('acf/validate_value/name=_post_title', 'acf_change_validate_value', 10, 4);
// add_filter('acf/validate_value/name=_post_content', 'acf_change_validate_value', 10, 4);

// change validate message
function acf_change_validate_message()
{
  if (!is_admin()) {
    acf_localize_text(array(
      'Validation successful' => __('검증 성공!', 'acf'),
      'Validation failed' => __('검증 실패', 'acf'),
      '1 field requires attention' => __('필수 항목 1개가 누락되었습니다.', 'acf'),
      '%d fields require attention' => __('필수 항목 %d개가 누락되었습니다.', 'acf'),
    ));
  }
}
add_action('acf/enqueue_scripts', 'acf_change_validate_message', 10, 0);

// ==============================
// admin page block user
function project_admin_page_block_user()
{
  if (is_admin() && is_user_logged_in() && !current_user_can('administrator')) {
    wp_redirect(home_url());
    exit;
  }
}
add_action('init', 'project_admin_page_block_user');

// edit user role
function project_user_role()
{
  $role_subscriber = get_role('subscriber');
  $role_subscriber->add_cap('edit_posts');
  $role_subscriber->add_cap('delete_posts');
  $role_subscriber->add_cap('edit_published_posts');
  $role_subscriber->add_cap('delete_published_posts');
  $role_subscriber->add_cap('delete_users');
}
add_action('admin_init', 'project_user_role');

// board add post
function project_add_post($page)
{
  global $post;
  if (current_user_can('subscriber') || current_user_can('administrator')) {
    return '<a class="btn btn-dark" href="' . home_url($page) . '?return=' . $post->post_name . '">작성하기</a>';
  }
}

// modify post
function project_modify_post()
{
  global $id, $post_type, $post, $user_id;
  $user_id = get_current_user_id();
  if ($user_id == $post->post_author || current_user_can('administrator')) {
    return '<a class="btn btn-dark" href="' . home_url('/') . $post_type . '-add?id=' . $id . '">수정하기</a>';
  }
}

// delete & redirect post
function project_delete_post()
{
  global $post, $user_id;
  $user_id = get_current_user_id();
  $delete_post_link = add_query_arg('trashed', 'true', get_delete_post_link(get_the_ID()));
  if ($user_id == $post->post_author || current_user_can('administrator')) {
    return '<a class="btn btn-danger" onclick="return confirm(\'게시물을 정말로 삭제하시겠습니까?\')" href="' . $delete_post_link . '">삭제하기</a>';
  }
}
function project_redirect_after_delete_post()
{
  if (isset($_GET['trashed'])) {
    $post_type = get_post_type(get_the_ID());
    wp_redirect(home_url('/' . $post_type));
    exit;
  }
}
add_action('trashed_post', 'project_redirect_after_delete_post');

// approval message
function project_approval_message()
{
  return (!empty($_GET['updated'])) ? '<script>alert("관리자 승인을 기다려주세요.");</script>' : '';
}

// apply message
function project_apply_message()
{
  return (!empty($_GET['updated'])) ? '<script>alert("신청이 접수되었습니다.");</script>' : '';
}

// send message
function project_send_message()
{
  return (!empty($_GET['updated'])) ? '<script>alert("문의 메일이 접수되었습니다.");</script>' : '';
}

// modify message
function project_modify_message()
{
  return (!empty($_GET['updated'])) ? '<script>alert("수정이 완료되었습니다.");</script>' : '';
}

// add page menu highlight
function project_add_page_current_class($classes, $item)
{
  $menu_slug = strtolower(trim($item->url));
  if (is_page('rent-add')) {
    if (strpos($menu_slug, 'rent') !== false) {
      $classes[] = 'current-menu-item';
    }
  } else if (is_page('program-add')) {
    if (strpos($menu_slug, 'program') !== false) {
      $classes[] = 'current-menu-item';
    }
  }
  return $classes;
}
add_action('nav_menu_css_class', 'project_add_page_current_class', 10, 2);

// post updated send email
function project_post_updated_send_email($post_id, $post_after, $post_before)
{
  $post_type = get_post_type($post_id);
  $post_before_status = $post_before->post_status;
  $post_after_status  = $post_after->post_status;
  if ($post_before_status == 'private' &&  $post_after_status  == 'publish') {
    // 대관
    if ($post_type == 'rent') {
      $post_title = get_the_title($post_id);
      $post_url = get_permalink($post_id);
      $email = get_field('rent_email', $post_id);
      $to = $email;
      $subject = '대관 신청이 승인되었습니다.' . ' (' . date_i18n('Y-m-d') . ')';
      $content = '<div style="background:#eee;padding:20px;line-height:1.5;">
      <h3 style="margin-bottom:20px;">[제목]: ' . $post_title . '</h3>
      <h3 style="margin-bottom:20px;">[내용]</h3>
      <div style="font-size:14px;white-space:pre-line;">대관 신청이 승인되었습니다. <a href="' . $post_url . '" target="_blank">승인글 보기</a></div>
      </div>';
      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      wp_mail($to, $subject, $content, $headers);
      add_filter('redirect_post_location', 'project_notice_send_email_filter');
    }
  }
}
add_action('post_updated', 'project_post_updated_send_email', 10, 3);

// notice send email message
function project_notice_send_email_filter($location)
{
  $location = add_query_arg(array('email' => 'message'), $location);
  return $location;
}
function project_notice_send_email_message()
{
  if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) {
    return;
  }
  $email = trim($_REQUEST['email']);
  $message = array(
    'message' => __('신청 접수 완료 메일이 전송되었습니다.')
  );
  if (!isset($message[$email])) {
    return;
  }
  echo '<div class="notice notice-info"><p>' . $message[$email] . '</p></div>';
}
add_action('admin_notices', 'project_notice_send_email_message');
