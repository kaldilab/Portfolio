<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php
// 고정글
$args_board_admin_pin = array(
  'post_type' => 'board_admin',
  'posts_per_page' => -1,
  'meta_key' => 'board_admin_pin',
  'meta_value' => '1',
);
$query_board_admin_pin = new WP_Query($args_board_admin_pin);
$count_board_admin_pin = $query_board_admin_pin->found_posts;

// 전체글(고정글 제외)
$paging = 10 - $count_board_admin_pin;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_board_admin = array(
  'post_type' => 'board_admin',
  'posts_per_page' => $paging,
  'paged' => $paged,
  'meta_key' => 'board_admin_pin',
  'meta_value' => '0',
);
if (!empty($_GET['q'])) {
  $q = $_GET['q'];
  $args_board_admin['s'] = $q;
} else {
  $q = null;
}
if (!empty($_GET['t'])) {
  $t = $_GET['t'];
  $args_board_admin['tax_query'] = array(
    array(
      'taxonomy' => 'tax_board_admin',
      'field' => 'term_id',
      'terms' => $t,
    )
  );
} else {
  $t = null;
}
$query_board_admin = new WP_Query($args_board_admin);
$count_board_admin = $query_board_admin->found_posts;
$count_board_admin = $count_board_admin - ($paged - 1) * $paging;
?>

<!-- 카테고리 -->
<ul class="nav nav-tabs">
  <?php
  $terms_board = get_terms('tax_board_admin');
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
    <col style="width:*">
    <col style="width:20%">
  </colgroup>
  <thead>
    <!-- 고정글 -->
    <?php
    if ($query_board_admin_pin->have_posts()) {
      while ($query_board_admin_pin->have_posts()) {
        $query_board_admin_pin->the_post();
        echo '<tr>';
        echo '<th>고정글</th>';
        echo '<th><a href="' . project_permalink() . '">' . get_the_title() . '</a></th>';
        echo '<th>' . get_the_date() . ' ' . get_the_time() . '</th>';
        echo '</tr>';
      }
    }
    wp_reset_postdata();
    ?>
    <!-- //고정글 -->
  </thead>
  <tbody>
    <!-- 전체글 -->
    <?php
    if ($query_board_admin->have_posts()) {
      while ($query_board_admin->have_posts()) {
        $query_board_admin->the_post();
        $terms = get_the_terms(false, 'tax_board_admin');
        $term = ($terms) ? ('<span>[' . $terms[0]->name . ']</span>') : '';
        $comment_count = $post->comment_count;
        echo '<tr>';
        echo '<td>' . $count_board_admin . '</td>';
        echo '<td>' . $term . ' <a href="' . project_permalink() . '">' . get_the_title() . ' (' . $comment_count . ')</a></td>';
        echo '<td>' . get_the_date() . ' ' . get_the_time() . '</td>';
        echo '</tr>';
        $count_board_admin--;
      }
    } else {
      echo '<tr>';
      echo '<td colspan="3" class="none">게시글이 없습니다.</td>';
      echo '</tr>';
    }
    wp_reset_postdata();
    ?>
    <!-- //전체글 -->
  </tbody>
</table>
<!-- //리스트 -->

<!-- 페이지네비 -->
<div>
  <?php
  $pagenavi = array(
    'total' => $query_board_admin->max_num_pages,
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