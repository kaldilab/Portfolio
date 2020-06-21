<?php get_header(); ?>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php
$tag = get_query_var('tag');
if (strpos($tag, '+') !== false) {
  $tag_list = explode('+', $tag);
  foreach ($tag_list as $item) {
    $item = get_term_by('slug', $item, 'post_tag');
    $item_name = $item->name;
    $tag_name_list[] = $item_name;
  }
  $tag_name = implode("+", $tag_name_list);
} else if (strpos($tag, ',') !== false) {
  $tag_list = explode(',', $tag);
  foreach ($tag_list as $item) {
    $item = get_term_by('slug', $item, 'post_tag');
    $item_name = $item->name;
    $tag_name_list[] = $item_name;
  }
  $tag_name = implode(",", $tag_name_list);
} else {
  $item = get_queried_object();
  $tag_name = $item->name;
}
?>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_tags = array(
  'post_type' => array(
    'board_admin',
    'board_user',
    'board_approval',
    'post',
  ),
  'posts_per_page' => 5,
  'paged' => $paged,
  'tag' => $tag,
);
$query_tags = new WP_Query($args_tags);
$count_tags = $query_tags->found_posts;
?>

<h1><?php echo $tag_name . '(' . $count_tags . ')'; ?></h1>

<!-- 리스트 -->
<ul class="list-group">
  <?php
  if ($query_tags->have_posts()) {
    while ($query_tags->have_posts()) {
      $query_tags->the_post();
      echo '<li class="list-group-item">';
      echo '<figure>' . project_featured_image('default.jpg') . '</figure>';
      echo '<a href="' . project_permalink() . '"><span>' . get_the_title() . '</span></a>';
      echo '<span>' . get_the_excerpt() . '</span>';
      echo '<span>' . get_the_date() . '</span>';
      echo '</li>';
    }
  } else {
    echo '<li class="list-group-item">';
    echo '<p class="none">게시글이 없습니다.</p>';
    echo '</li>';
  }
  wp_reset_postdata();
  ?>
</ul>
<!-- 리스트 -->

<!-- 페이지네비 -->
<div>
  <?php
  $pagenavi = array(
    'total' => $query_tags->max_num_pages,
    'prev_text' => '이전',
    'next_text' => '다음',
  );
  echo paginate_links($pagenavi);
  ?>
</div>
<!-- //페이지네비 -->

<?php get_footer(); ?>