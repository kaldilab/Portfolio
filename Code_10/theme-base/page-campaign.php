<?php get_header(); ?>

<?php echo project_apply_message(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php
// post campaign
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_campaign = array(
  'post_type' => 'campaign',
  'posts_per_page' => -1,
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key' => 'campaign_status',
      'value' => '0',
    ),
    array(
      'key' => 'campaign_date_end',
      'value' => date_i18n('Y-m-d'),
      'compare' => '>=',
      'type' => 'DATE',
    ),
  ),
);
if (!empty($_GET['q'])) {
  $q = $_GET['q'];
  $args_campaign['s'] = $q;
} else {
  $q = null;
}
$query_campaign = new WP_Query($args_campaign);
?>

<!-- 리스트 -->
<div class="card-group">
  <?php
  if ($query_campaign->have_posts()) {
    while ($query_campaign->have_posts()) {
      $query_campaign->the_post();
      $comment_count = $post->comment_count;
      echo '<div class="card">';
      echo project_card_image('default.jpg');
      echo '<div class="card-body">';
      echo '<div class="card-title"><a href="' . project_permalink() . '">' . get_the_title() . ' (' . $comment_count . ')</a></div>';
      echo '<div class="card-text">';
      echo '<p class="text-truncate">' . get_the_excerpt() . '</p>';
      echo '<p>날짜 : ' . get_field('campaign_date')['start'] . ' ~ ' . get_field('campaign_date')['end'] . '</p>';
      echo '<p>시간 : ' . get_field('campaign_time')['start'] . ' ~ ' . get_field('campaign_time')['end'] . '</p>';
      echo '</div>';
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
    'total' => $query_campaign->max_num_pages,
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
    <input type="search" placeholder="<?php echo esc_attr_x('검색어를 입력하세요', 'placeholder'); ?>" value="<?php echo $q; ?>" name="q" title="<?php echo esc_attr_x('검색어 입력', 'label'); ?>">
    <input type="submit" value="<?php echo esc_attr_x('검색', 'submit button'); ?>">
  </form>
</div>
<!-- //게시판 검색 -->

<?php get_footer(); ?>