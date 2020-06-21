<?php
// CPT
$post_name = $post->post_name;
$page_name = str_replace('board', 'board_', $post_name);
$custom_post_type = $page_name;
$custom_taxonomy = 'tax_' . $page_name;
?>

<?php
// 전체글
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_board = array(
  'post_type' => $custom_post_type,
  'posts_per_page' => 8,
  'paged' => $paged,
);
if (!empty($_GET['q'])) {
  $q = $_GET['q'];
  $args_board['s'] = $q;
} else {
  $q = null;
}
if (!empty($_GET['t'])) {
  $t = $_GET['t'];
  $args_board['tax_query'] = array(
    array(
      'taxonomy' => $custom_taxonomy,
      'field' => 'term_id',
      'terms' => $t,
    )
  );
} else {
  $t = null;
}
$query_board = new WP_Query($args_board);

// taxonomy
$terms_board = get_terms([
  'taxonomy' => $custom_taxonomy,
  'hide_empty' => false,
]);
?>

<!-- 카테고리 -->
<?php if ($terms_board) : ?>
  <div class="sub__tabs tabs-board">
    <ul class="nav nav-tabs">
      <?php
      $active_all = (empty($t)) ? 'active' : '';
      echo '<li class="nav-item"><a class="nav-link ' . $active_all . '" href="' . project_permalink() . '">전체</a></li>';
      if ($terms_board) {
        foreach ($terms_board as $term) {
          $active_term = ($t == $term->term_id) ? 'active' : '';
          echo '<li class="nav-item"><a class="nav-link ' . $active_term . '" href="' . project_permalink() . '?t=' . $term->term_id . '">' . $term->name . '</a></li>';
        }
      }
      ?>
    </ul>
  </div>
<?php endif; ?>
<!-- //카테고리 -->

<section class="section board">

  <h3 class="sr-only"><?php the_title(); ?></h3>

  <!-- 리스트 -->
  <ul class="board-card row">
    <?php
    if ($query_board->have_posts()) {
      while ($query_board->have_posts()) {
        $query_board->the_post();
        $terms = get_the_terms(false, $custom_taxonomy);
        $term = ($terms) ? ('<span class="cat"><strong>' . $terms[0]->name . '</strong></span>') : '';
        echo '<li class="card-item col-sm-3">';
        echo '<a class="card-link" href="' . project_permalink() . '">';
        echo '<div class="card-image">';
        echo project_featured_image('img_default.png');
        echo $term;
        echo '</div>';
        echo '<div class="card-body">';
        echo '<div class="tit">' . get_the_title() . '</div>';
        echo '<div class="desc">' . get_the_excerpt() . '</div>';
        echo '</div>';
        echo '</a>';
        echo '<div class="card-foot">' . get_the_date() . ' ' . get_the_time() . '</div>';
        echo '</li>';
      }
    } else {
      echo '<li class="card-item col-12 none">게시글이 없습니다.</li>';
    }
    wp_reset_postdata();
    ?>
  </ul>
  <!-- //리스트 -->

  <!-- 페이지네비 -->
  <div class="pagenavi">
    <?php
    $pagenavi = array(
      'total' => $query_board->max_num_pages,
      'prev_text' => '<i>이전</i>',
      'next_text' => '<i>다음</i>',
      'mid_size' => 1,
    );
    echo paginate_links($pagenavi);
    ?>
  </div>
  <!-- //페이지네비 -->

  <!-- 게시판 검색 -->
  <div class="board__search">
    <div class="form-search search-board">
      <form role="search" action=<?php echo project_permalink(); ?>>
        <div class="form-select">
          <select class="form-control" name="t">
            <?php
            $selected_all = (empty($t)) ? 'selected' : '';
            echo '<option value="" ' . $selected_all . '>전체</option>';
            if ($terms_board) {
              foreach ($terms_board as $term) {
                $selected_term = ($t == $term->term_id) ? 'selected' : '';
                echo '<option value="' . $term->term_id . '" ' . $selected_term . '>' . $term->name . '</option>';
              }
            }
            ?>
          </select>
        </div>
        <input type="search" class="search form-control" name="q" value="<?php echo $q; ?>" placeholder="<?php echo esc_attr_x('검색어를 입력하세요', 'placeholder'); ?>" title="<?php echo esc_attr_x('검색어 입력', 'label'); ?>">
        <input type="submit" class="submit btn btn-sm btn-ghost" value="<?php echo esc_attr_x('검색', 'submit button'); ?>">
      </form>
    </div>
  </div>
  <!-- //게시판 검색 -->

</section>