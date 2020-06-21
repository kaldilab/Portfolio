<?php
$post_type = get_post_type();
$args_posts = array(
  'post_type' => $post_type,
  'posts_per_page' => -1,
);
if ($post_type == 'post') {
  $category = get_the_category();
  $category_id = $category[0]->term_id;
  $args_posts['cat'] = $category_id;
}
$all_posts = get_posts($args_posts);
$post_id = array();
foreach ($all_posts as $the_post) {
  $post_id[] = $the_post->ID;
}
$post_count = count($post_id);
$this_index = array_search($post->ID, $post_id);
$prev_index = $this_index + 1;
$next_index = $this_index - 1;
$prev_id = ($prev_index >= 0 && $prev_index < $post_count) ? $post_id[$prev_index] : '';
$next_id = ($next_index >= 0 && $next_index < $post_count) ? $post_id[$next_index] : '';
$date_format = get_option('date_format');
$time_format = get_option('time_format');
?>

<ul class="list-group">
  <li class="list-group-item">
    <span>이전글 : </span>
    <?php if (!empty($prev_id)) : ?>
      <span><a href="<?php the_permalink($prev_id); ?>"><?php echo get_the_title($prev_id); ?></a> <time><?php echo get_the_date($date_format, $prev_id); ?> <?php echo get_the_time($time_format, $prev_id); ?></time></span>
    <?php else : ?>
      <span>이전글이 없습니다</span>
    <?php endif; ?>
  </li>
  <li class="list-group-item">
    <span>다음글 :</span>
    <?php if (!empty($next_id)) : ?>
      <span><a href="<?php the_permalink($next_id); ?>"><?php echo get_the_title($next_id); ?></a> <time><?php echo get_the_date($date_format, $next_id); ?> <?php echo get_the_time($time_format, $next_id); ?></time></span>
    <?php else : ?>
      <span>다음글이 없습니다</span>
    <?php endif; ?>
  </li>
</ul>