<?php get_header(); ?>

<?php echo project_approval_message(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!-- 작성하기 -->
<div class="text-right">
  <?php echo project_add_post('board_approval-add'); ?>
</div>
<!-- //작성하기 -->

<?php
// 전체글
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_board_approval = array(
  'post_type' => 'board_approval',
  'posts_per_page' => 4,
  'paged' => $paged,
  'post_status' => 'publish',
  'meta_key' => 'board_approval_status',
  'meta_value' => '승인',
);
if (!empty($_GET['q'])) {
  $q = $_GET['q'];
  $args_board_approval['s'] = $q;
} else {
  $q = null;
}
if (!empty($_GET['t'])) {
  $t = $_GET['t'];
  $args_board_approval['tax_query'] = array(
    array(
      'taxonomy' => 'tax_board_approval',
      'field' => 'term_id',
      'terms' => $t,
    )
  );
} else {
  $t = null;
}
$query_board_approval = new WP_Query($args_board_approval);
?>

<ul class="nav nav-tabs">
  <?php
  $terms_board = get_terms('tax_board_approval');
  $active_all = (empty($t)) ? 'active' : '';
  echo '<li class="nav-item"><a class="nav-link ' . $active_all . '" href="' . project_permalink() . '">전체</a></li>';
  foreach ($terms_board as $term) :
    $active_term = ($t == $term->term_id) ? 'active' : '';
    echo '<li class="nav-item"><a class="nav-link ' . $active_term . '" href="' . project_permalink() . '?t=' . $term->term_id . '">' . $term->name . '</a></li>';
  endforeach;
  ?>
</ul>

<!-- 리스트 -->
<div class="card-group">
  <?php
  if ($query_board_approval->have_posts()) {
    while ($query_board_approval->have_posts()) {
      $query_board_approval->the_post();
      $terms = get_the_terms(false, 'tax_board_approval');
      $term = ($terms) ? ('<strong>[' . $terms[0]->name . ']</strong>') : '';
      echo '<div class="card">';
      echo project_card_image('default.jpg');
      echo '<div class="card-body">';
      echo '<div class="card-title"><a href="' . project_permalink() . '">' . $term . ' ' . get_the_title() . '</a></div>';
      echo '<div class="card-text"><p class="text-truncate">' . get_the_excerpt() . '</p></div>';
      echo '</div>';
      echo '<div class="card-footer">' . get_the_author() . ' | ' . get_the_date() . ' ' . get_the_time() . '</div>';
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
    'total' => $query_board_approval->max_num_pages,
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
    <select name="t">
      <?php
      $selected_all = (empty($t)) ? 'selected' : '';
      echo '<option value="" ' . $selected_all . '>전체</option>';
      foreach ($terms_board as $term) :
        $selected_term = ($t == $term->term_id) ? 'selected' : '';
        echo '<option value="' . $term->term_id . '" ' . $selected_term . '>' . $term->name . '</option>';
      endforeach;
      ?>
    </select>
    <input type="search" placeholder="<?php echo esc_attr_x('검색어를 입력하세요', 'placeholder'); ?>" value="<?php echo $q; ?>" name="q" title="<?php echo esc_attr_x('검색어 입력', 'label'); ?>">
    <input type="submit" value="<?php echo esc_attr_x('검색', 'submit button'); ?>">
  </form>
</div>
<!-- //게시판 검색 -->

<?php get_footer(); ?>