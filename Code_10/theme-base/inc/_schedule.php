<?php
// user last login
function user_last_login($user_login, $user)
{
  $last_login_date = date_i18n('Y-m-d');
  update_user_meta($user->ID, 'last_login', $last_login_date);
}
add_action('wp_login', 'user_last_login', 10, 2);

// scheduled add interval
function scheduled_add_one_minute($schedules)
{
  $schedules['one_minute'] = array(
    'interval' => 60,
    'display' => __('One Minute')
  );
  return $schedules;
}
add_filter('cron_schedules', 'scheduled_add_one_minute');


// -------
// inactive user scheduled email
if (!wp_next_scheduled('inactive_user_scheduled_email')) {
  wp_schedule_event(time(), 'one_minute', 'inactive_user_scheduled_email');
}

// inactive user send email
function inactive_user_send_email()
{
  // inactive user search
  $today = date_i18n('Y-m-d');
  // $years_ago = date_i18n('Y-m-d', strtotime('-1 year'));
  $args_users = array(
    'role' => 'subscriber',
    'meta_key' => 'last_login',
    'meta_value' => $today,
    'meta_compare' => '<=',
  );
  $query_users = new WP_User_Query($args_users);
  $result_users = $query_users->get_results();

  if (!empty($result_users)) {
    foreach ($result_users as $result_user) {
      // user data
      $user_info = get_userdata($result_user->ID);
      $user_email = $user_info->user_email;
      $user_name = $user_info->display_name;
      // send email
      $admin_email = get_option('admin_email');
      $site_title = get_bloginfo('name');
      $to = $user_email;
      $subject = $_POST['email_subject'];
      $content = '<div style="background:#eee;padding:20px;line-height:1.5;"><h3 style="margin-bottom:20px">[내용]</h3><div style="font-size:14px;white-space:pre-line;">' . $user_name . '님의 계정이 한 달 후에 삭제될 예정입니다.</div></div>';
      $headers[] = 'From: ' . $site_title . ' <' . $admin_email . '>';
      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      wp_mail($to, $subject, $content, $headers);
    }
  }
}
add_action('inactive_user_scheduled_email', 'inactive_user_send_email');

// -------
// inactive user scheduled delete
if (!wp_next_scheduled('inactive_user_scheduled_delete')) {
  wp_schedule_event(time(), 'one_minute', 'inactive_user_scheduled_delete');
}

// inactive user handle account
function inactive_user_handle_account()
{
  // inactive user search
  $today = date_i18n('Y-m-d');
  // $years_ago = date_i18n('Y-m-d', strtotime('-13 month'));
  $args_users = array(
    'role' => 'subscriber',
    'meta_key' => 'last_login',
    'meta_value' => $today,
    'meta_compare' => '<=',
  );
  $query_users = new WP_User_Query($args_users);
  $result_users = $query_users->get_results();

  if (!empty($result_users)) {
    foreach ($result_users as $result_user) {
      // user data
      $user_info = get_userdata($result_user->ID);
      $user_id = $user_info->ID;

      // 1) disable account
      $user = new WP_User($user_id);
      $user->remove_role('subscriber');
      $user->add_role('None');

      // 2)delete account
      /* require_once(ABSPATH . 'wp-admin/includes/user.php');
      wp_delete_user($user_id); */
    }
  }
}
add_action('inactive_user_scheduled_delete', 'inactive_user_handle_account');

// 
function inactive_user_disable_account($user, $username)
{
  $user_id = get_userdata($user->ID);
  $user_role = $user_id->roles;
  if (empty($user_role)) {
    return new WP_Error('disabled_account', '휴면 계정으로 전환되었습니다.');
  } else {
    return $user;
  }
  return $user;
}
add_filter('authenticate', 'inactive_user_disable_account', 100, 2);
