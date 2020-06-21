<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php
// 전체글
$num = 5;
if (!empty($_GET['load'])) {
  $load = $_GET['load'];
  $paging = $num * $load;
  $load_more = $load + 1;
} else {
  $paging = $num;
  $load_more = 2;
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_board_admin = array(
  'post_type' => 'board_admin',
  'posts_per_page' => $paging,
  'paged' => $paged,
);
if (!empty($_GET['q'])) {
  $q = $_GET['q'];
  $args_board_admin['s'] = $q;
  $args_board_admin['paged'] = $paged;
} else {
  $q = null;
}
$query_board_admin = new WP_Query($args_board_admin);
$count_board_admin = $query_board_admin->found_posts;
$count_board_admin_result = $count_board_admin;
if (!empty($_GET['q'])) {
  $count_board_admin = $count_board_admin - ($paged - 1) * $paging;
}
?>

<!-- 리스트 -->
<table class="table">
  <colgroup>
    <col style="width:10%">
    <col style="width:*">
    <col style="width:20%">
  </colgroup>
  <tbody>
    <!-- 전체글 -->
    <?php
    if ($query_board_admin->have_posts()) {
      while ($query_board_admin->have_posts()) {
        $query_board_admin->the_post();
        $terms = get_the_terms(false, 'tax_board_admin');
        $term = ($terms) ? ('<span>[' . $terms[0]->name . ']</span>') : '';
        echo '<tr>';
        echo '<td>' . $count_board_admin . '</td>';
        echo '<td>' . $term . ' <a href="' . project_permalink() . '">' . get_the_title() . '</a></td>';
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
<div id="scrollToMore">
  <?php
  if (!isset($q)) {
    // 기본
    if (($paging < $count_board_admin_result)) {
      echo '<form action="#scrollToMore">';
      echo '<input type="hidden" value="' . $load_more . '" name="load">';
      echo '<input class="btn btn-dark" type="submit" value="더보기">';
      echo '</form>';
    } else {
      echo '<p>게시물이 없습니다.</p>';
    }
  } else {
    // 검색
    $pagenavi = array(
      'total' => $query_board_admin->max_num_pages,
      'prev_text' => '이전',
      'next_text' => '다음',
    );
    echo paginate_links($pagenavi);
  }
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

<!-- scroll to more -->
<script>
  jQuery(document).ready(function($) {
    if (window.location.hash) {
      // hash
      hash = window.location.hash;
      // scrollTo
      check = hash.indexOf('scrollTo');
      $target = $(hash);
      if ($target && check) {
        $('html, body').animate({
          scrollTop: ($target.offset().top + $target.height() - $(window).height()) + 50
        }, 1);
      }
    }
  });
</script>
<!-- //scroll to more -->

<?php get_footer(); ?>