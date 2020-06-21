<?php
if (is_page() || is_single() || is_category()) {
  // is_page
  $depth_parent = $post->post_parent;
  $depth1_title = get_the_title($post->post_parent);
  $depth2_title = $post->post_title;

  // is_category
  $category_object = get_queried_object();
  $category_title = $category_object->name;

  // is_single
  $post_type = get_post_type();
  $post_type_object = get_post_type_object($post_type);
  $post_type_title = $post_type_object->label;
  if ($post_type == 'post') {
    $post_category = get_the_category();
    $post_category_title = $post_category[0]->name;
  }

  // menu title
  $menu_items = wp_get_nav_menu_items('nav-menu');
  $menu_id = false;
  foreach ($menu_items as $menu_item) {
    $this_title = $menu_item->title;
    $this_parent_id = $menu_item->menu_item_parent;
    if ($post_type_title == $this_title) {
      $menu_id = $this_parent_id;
    }
  }
  if ($menu_id) {
    foreach ($menu_items as $menu_item) {
      $this_id = $menu_item->ID;
      $this_title = $menu_item->title;
      if ($menu_id == $this_id) {
        $menu_title = $this_title;
      }
    }
  }
}
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <?php
    // depth1
    if (is_search()) {
      echo '<li class="breadcrumb-item">검색</li>';
    } else if (is_tag()) {
      echo '<li class="breadcrumb-item">태그</li>';
    } else if (is_category()) {
      echo '<li class="breadcrumb-item">카테고리게시판</li>';
    } else if (is_single()) {
      if ($post_type == 'post') {
        echo '<li class="breadcrumb-item">카테고리게시판</li>';
      } else {
        echo '<li class="breadcrumb-item">' . (($menu_id) ? $menu_title : $post_type_title) . '</li>';
      }
    } else {
      echo '<li class="breadcrumb-item">' . $depth1_title . '</li>';
    }

    // depth2
    if (is_search()) {
      echo '';
    } else if (is_tag()) {
      echo '';
    } else if (is_category()) {
      echo '<li class="breadcrumb-item">' . $category_title . '타입</li>';
    } else if (is_single()) {
      if ($post_type == 'post') {
        echo '<li class="breadcrumb-item">' . $post_category_title . '타입</li>';
      } else {
        echo '<li class="breadcrumb-item">' . $post_type_title . '</li>';
      }
    } else {
      echo '<li class="breadcrumb-item">' . $depth2_title . '</li>';
    }
    ?>
  </ol>
</nav>