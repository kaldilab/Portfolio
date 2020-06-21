<?php get_header(); ?>

<?php
$search = (isset($_GET['s'])) ? $_GET['s'] : null;
$etc_search = get_field('etc_search', 'option');
$search_target = $etc_search['target'];
if (!empty($_GET['board'])) {
  $board = $_GET['board'];
} else {
  $board = null;
}
?>

<div class="sub__top">
  <h2 class="sr-only">검색</h2>
  <div class="sub__search">
    <div class="form-search searchbar-all">
      <?php get_search_form(); ?>
    </div>
  </div>
</div>

<!-- 카테고리 -->
<?php if (count($search_target) > 1) : ?>
  <div class="sub__tabs tabs-board">
    <ul class="nav nav-tabs">
      <?php
      $active_all = (empty($board)) ? 'active' : '';
      echo '<li class="nav-item"><a class="nav-link ' . $active_all . '" href="' . project_homeurl('/?s=') . $search . '">전체</a></li>';
      foreach ($search_target as $item) {
        $active = ($board == $item['value']) ? 'active' : '';
        echo '<li class="nav-item"><a class="nav-link ' . $active . '" href="' . project_homeurl('/?s=') . $search . '&board=' . $item['value'] . '">' . $item['label'] . '</a></li>';
      }
      ?>
    </ul>
  </div>
<?php endif; ?>
<!-- //카테고리 -->

<!-- 전체페이지 검색결과 -->
<?php
$board_value = array();
foreach ($search_target as $item) {
  $board_value[] = $item['value'];
  if ($item['value'] == $board) {
    $board_label = $item['label'];
  }
}
if ($board) {
  $board_list = $board;
  $board_title = $board_label;
} else {
  $board_list = $board_value;
  $board_title = '전체';
}
$num_search = 3;
if (!empty($_GET['load_search'])) {
  $load_search = $_GET['load_search'];
  $paging_search = $num_search * $load_search;
  $load_more_search = $load_search + 1;
} else {
  $paging_search = $num_search;
  $load_more_search = 2;
}
$args_search = array(
  'post_type' => $board_list,
  'posts_per_page' => $paging_search,
  's' => $search,
);
$query_search = new WP_Query($args_search);
$count_search = $query_search->found_posts;
?>

<section class="section searchresult">

  <h3 class="searchresult__title"><?php echo $board_title . ' : 검색결과 ' . $count_search . '건'; ?></h3>

  <div class="board-blog board-search">
    <?php
    if ($query_search->have_posts()) {
      while ($query_search->have_posts()) {
        $query_search->the_post();
        $order_number_search = $query_search->current_post + 1;
        $tax = 'tax_' . get_post_type();
        $terms = get_the_terms(false, $tax);
        $term = ($terms) ? ('<span class="cat"><strong>' . $terms[0]->name . '</strong></span>') : '';
        $featured_image = get_the_post_thumbnail_url();
        $featured_image_checker = ($featured_image) ? '' : 'wide';
        $title = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_title());
        $excerpt = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_excerpt());
        echo '<ul class="blog-item">';
        echo '<li class="blog-head">' . $order_number_search . '</li>';
        if ($featured_image) {
          echo '<li class="blog-image">';
          echo '<a class="blog-link" href="' . project_permalink() . '">';
          echo project_featured_image('img_default.png');
          echo $term;
          echo '</a>';
          echo '</li>';
        }
        echo '<li class="blog-body ' . $featured_image_checker . '">';
        echo '<a class="blog-link" href="' . project_permalink() . '">';
        echo '<p class="tit">' . $title . '</p>';
        echo '<p class="desc">' . $excerpt . '</p>';
        echo '</a>';
        echo '<p class="date">' . get_the_date() . ' ' . get_the_time() . '</p>';
        echo '</li>';
        echo '</ul>';
      }
    } else {
      echo '<ul class="blog-item none">검색결과가 없습니다.</ul>';
    }
    wp_reset_postdata();
    ?>
  </div>

  <div id="scrollToMore" class="searchresult__more">
    <?php
    if ($paging_search < $count_search) {
      echo '<form action="#scrollToMore">';
      echo '<input type="hidden" name="load_search" value="' . $load_more_search . '">';
      echo '<input type="hidden" name="s" value="' . $search . '">';
      if ($board) {
        echo '<input type="hidden" name="board" value="' . $board . '">';
      }
      echo '<input class="btn btn-ghost" type="submit" value="더보기">';
      echo '</form>';
    } else {
      echo ($num_search < $count_search) ? '<p class="txt">검색결과가 없습니다.</p>' : null;
    }
    ?>
  </div>

</section>
<!-- //전체페이지 검색결과 -->

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