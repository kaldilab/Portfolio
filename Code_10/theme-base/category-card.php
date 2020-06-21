<?php get_header(); ?>

<h1><?php single_cat_title(); ?>타입</h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php
$category = get_queried_object();
$category_id = $category->term_id;
?>

<?php
// 전체글
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_category = array(
  'cat' => $category_id,
  'posts_per_page' => 4,
  'paged' => $paged,
  'meta_key' => 'category_pin',
  'meta_value' => '0',
);
if (!empty($_GET['q'])) {
  $q = $_GET['q'];
  $args_category['s'] = $q;
} else {
  $q = null;
}
$query_category = new WP_Query($args_category);
?>

<!-- 리스트 -->
<div class="card-group">
  <?php
  if ($query_category->have_posts()) {
    while ($query_category->have_posts()) {
      $query_category->the_post();
      echo '<div class="card">';
      echo project_card_image('default.jpg');
      echo '<div class="card-body">';
      echo '<div class="card-title"><a href="' . project_permalink() . '">' . get_the_title() . '</a></div>';
      echo '<div class="card-text"><p class="text-truncate">' . get_the_excerpt() . '</p></div>';
      echo '</div>';
      echo '<div class="card-footer">' . get_the_date() . ' ' . get_the_time() . '</div>';
      echo '</div>';
    }
  } else {
    echo '<div class="card">';
    echo '<p class="none">게시글이 없습니다.</p>';
    echo '</div>';
  }
  wp_reset_postdata();
  ?>
</div>
<!-- //리스트 -->

<!-- 페이지네비 -->
<div>
  <?php
  $pagenavi = array(
    'total' => $query_category->max_num_pages,
    'prev_text' => '이전',
    'next_text' => '다음',
  );
  echo paginate_links($pagenavi);
  ?>
</div>
<!-- //페이지네비 -->

<!-- 게시판 검색 -->
<div>
  <form role="search" action=<?php echo project_permalink(); ?>>
    <input type=" search" placeholder="<?php echo esc_attr_x('검색어를 입력하세요', 'placeholder'); ?>" value="<?php echo $q; ?>" name="q" title="<?php echo esc_attr_x('검색어 입력', 'label'); ?>">
    <input type="submit" value="<?php echo esc_attr_x('검색', 'submit button'); ?>">
  </form>
</div>
<!-- //게시판 검색 -->

<?php get_footer(); ?>