<?php
// options page
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
    'page_title'  => '메인관리',
    'menu_title'  => '메인관리',
    'menu_slug'   => 'main_settings',
  ));
  acf_add_options_page(array(
    'page_title'  => '고정페이지관리',
    'menu_title'  => '고정페이지관리',
    'menu_slug'   => 'about_settings',
  ));
}

// thumbnail image
function project_thumbnail_image($default)
{
  $thumbnail_image = get_the_post_thumbnail_url();
  if ($thumbnail_image) {
    return '<img class="img-thumbnail" src="' . $thumbnail_image . '" alt="' . get_the_title() . '">';
  } else {
    return '<img class="img-thumbnail" src="' . project_image_uri($default) . '" alt="' . get_the_title() . '">';
  }
}

// card image
function project_card_image($default)
{
  $card_image = get_the_post_thumbnail_url();
  if ($card_image) {
    return '<img class="card-img-top" src="' . $card_image . '" alt="' . get_the_title() . '">';
  } else {
    return '<img class="card-img-top" src="' . project_image_uri($default) . '" alt="' . get_the_title() . '">';
  }
}

// redirect
function project_redirect()
{
  if (is_page('static')) {
    wp_redirect(home_url('about'));
  } else if (is_page('boardadmin')) {
    wp_redirect(home_url('board_admin_general'));
  } else if (is_page('boarduser')) {
    wp_redirect(home_url('board_user_general'));
  } else if (is_page('boardapproval')) {
    wp_redirect(home_url('board_approval_general'));
  } else if (is_page('cat')) {
    wp_redirect(home_url('category/general'));
  } else if (is_page('apply')) {
    wp_redirect(home_url('rent'));
  } else if (is_page('advanced')) {
    wp_redirect(home_url('kakaomap'));
  } else if (is_page('mypage')) {
    wp_redirect(home_url('login'));
  }
}
add_action('template_redirect', 'project_redirect');

// search only title or content
function project_search_only($search, $wp_query)
{
  if (!empty($search) && !empty($wp_query->query_vars['search_terms'])) {
    global $wpdb;
    $q = $wp_query->query_vars;
    $n = !empty($q['exact']) ? '' : '%';
    $search = array();
    foreach ((array) $q['search_terms'] as $term) {
      // only title
      $search[] = $wpdb->prepare("$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like($term) . $n);
      // only content
      // $search[] = $wpdb->prepare("$wpdb->posts.post_content LIKE %s", $n . $wpdb->esc_like($term) . $n);
    }
    if (!is_user_logged_in()) {
      $search[] = "$wpdb->posts.post_password = ''";
    }
    $search = ' AND ' . implode(' AND ', $search);
  }
  return $search;
}
add_filter('posts_search', 'project_search_only', 10, 2);

// tag & category pagenavi
function project_pre_get_posts($query)
{
  if ($query->is_main_query() && !is_admin()) {
    $post_types = get_post_types();
    $query->set('post_type', $post_types);
    $query->set('posts_per_page', -1);
  }
  return $query;
}
add_action('pre_get_posts', 'project_pre_get_posts');
