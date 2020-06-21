<?php
$tags = wp_get_post_tags($post->ID);
if (is_single()) {
  $post_type = get_post_type();
  $page_name = str_replace('_', '', $post_type);
  $current_url = project_homeurl('/' . $page_name . '/');
} else {
  $object_id = get_queried_object_id();
  $current_url = get_permalink($object_id);
}
if ($tags) {
  foreach ($tags as $tag) {
    echo '<a class="btn btn-tag" href="' . $current_url . '?tag=' . $tag->slug . '" title="' . $tag->name . '"><span>#</span>' . $tag->name . '</a>';
  }
}
