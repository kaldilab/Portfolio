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
$paging = 5;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_board_approval = array(
  'post_type' => 'board_approval',
  'posts_per_page' => $paging,
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
$count_board_approval = $query_board_approval->found_posts;
$count_board_approval = $count_board_approval - ($paged - 1) * $paging;
?>

<!-- 카테고리 -->
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
<!-- //카테고리 -->

<!-- 리스트 -->
<table class="table">
  <colgroup>
    <col style="width:10%">
    <col style="width:20%">
    <col style="width:*">
  </colgroup>
  <tbody>
    <?php
    if ($query_board_approval->have_posts()) {
      while ($query_board_approval->have_posts()) {
        $query_board_approval->the_post();
        $terms = get_the_terms(false, 'tax_board_approval');
        $term = ($terms) ? ('<span>[' . $terms[0]->name . ']</span>') : '';
        echo '<tr>';
        echo '<td>' . $count_board_approval . '</td>';
        echo '<td>' . project_thumbnail_image('default.jpg') . '</td>';
        echo '<td>';
        echo $term . ' <a href="' . project_permalink() . '">' . get_the_title() . '</a>';
        echo '<p>' . get_the_excerpt() . '</p>';
        echo '<p>' . get_the_date() . ' ' . get_the_time() . '</p>';
        echo '<p>' . get_the_author() . '</p>';
        echo '</td>';
        echo '</tr>';
        $count_board_approval--;
      }
    } else {
      echo '<tr>';
      echo '<td colspan="3" class="none">게시글이 없습니다.</td>';
      echo '</tr>';
    }
    wp_reset_postdata();
    ?>
  </tbody>
</table>
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