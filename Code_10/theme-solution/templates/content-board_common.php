<?php
// CPT
$post_name = $post->post_name;
$page_name = str_replace('board', 'board_', $post_name);
$custom_post_type = $page_name;
$custom_taxonomy = 'tax_' . $page_name;
?>

<?php
// 고정글
$args_board_pin = array(
  'post_type' => $custom_post_type,
  'posts_per_page' => -1,
  'meta_key' => 'board_pin',
  'meta_value' => '1',
);
$query_board_pin = new WP_Query($args_board_pin);
$count_board_pin = $query_board_pin->found_posts;

// 전체글(고정글 제외)
$paging = 10 - $count_board_pin;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_board = array(
  'post_type' => $custom_post_type,
  'posts_per_page' => $paging,
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
$count_board = $query_board->found_posts;
$count_board = $count_board - ($paged - 1) * $paging;

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
  <table class="board-common table layout-fixed">
    <colgroup>
      <col style="width:10%">
      <col style="width:75%">
      <col style="width:15%">
    </colgroup>
    <thead>
      <th>번호</th>
      <th>제목</th>
      <th>날짜</th>
    </thead>
    <tbody>
      <!-- 고정글 -->
      <?php
      if ($query_board_pin->have_posts()) {
        while ($query_board_pin->have_posts()) {
          $query_board_pin->the_post();
          $file = get_field('board_file');
          $file_check = $file ? '<a href="' . $file['url'] . '" class="file" download><span class="sr-only">첨부파일</span></a>' : '';
          echo '<tr>';
          echo '<th class="num">고정글</th>';
          echo '<th class="tit"><a class="link" href="' . project_permalink() . '">' . get_the_title() . '</a>' . $file_check . '</th>';
          echo '<th class="date">' . get_the_date() . ' ' . get_the_time() . '</th>';
          echo '</tr>';
        }
      }
      wp_reset_postdata();
      ?>
      <!-- //고정글 -->
      <!-- 전체글 -->
      <?php
      if ($query_board->have_posts()) {
        while ($query_board->have_posts()) {
          $query_board->the_post();
          $file = get_field('board_file');
          $file_check = $file ? '<a href="' . $file['url'] . '" class="file" title="다운로드" download><span class="sr-only">첨부파일</span></a>' : '';
          $terms = get_the_terms(false, $custom_taxonomy);
          $term = ($terms) ? ('<span class="cat">[' . $terms[0]->name . ']</span> ') : '';
          echo '<tr>';
          echo '<td class="num">' . $count_board . '</td>';
          echo '<td class="tit"><a class="link" href="' . project_permalink() . '">' . $term . get_the_title() . '</a>' . $file_check . '</td>';
          echo '<td class="date">' . get_the_date() . ' ' . get_the_time() . '</td>';
          echo '</tr>';
          $count_board--;
        }
      } else {
        echo '<tr>';
        echo '<td colspan="4">게시글이 없습니다.</td>';
        echo '</tr>';
      }
      wp_reset_postdata();
      ?>
      <!-- //전체글 -->
    </tbody>
  </table>
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