<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php
// 전체글
$paging = 5;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_faq = array(
  'post_type' => 'faq',
  'posts_per_page' => $paging,
  'paged' => $paged,
);
if (!empty($_GET['q'])) {
  $q = $_GET['q'];
  $args_faq['s'] = $q;
} else {
  $q = null;
}
if (!empty($_GET['t'])) {
  $t = $_GET['t'];
  $args_faq['tax_query'] = array(
    array(
      'taxonomy' => 'tax_faq',
      'field' => 'term_id',
      'terms' => $_GET['t'],
    )
  );
} else {
  $t = null;
}
$query_faq = new WP_Query($args_faq);
$count_faq = $query_faq->found_posts;
$count_faq = $count_faq - ($paged - 1) * $paging;
?>

<!-- 카테고리 -->
<ul class="nav nav-tabs">
  <?php
  $terms_board = get_terms('tax_faq');
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
  <tbody>
    <?php
    if ($query_faq->have_posts()) {
      while ($query_faq->have_posts()) {
        $query_faq->the_post();
        $terms = get_the_terms(false, 'tax_faq');
        echo '<tr>';
        echo '<td>' . $count_faq . '</td>';
        echo '<td>';
        echo '<p><strong>[' . $terms[0]->name . ']</strong> : ' . get_the_title() . '</p>';
        echo '<p>' . get_the_content() . '</p>';
        echo '</td>';
        echo '</tr>';
        $count_faq--;
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
    'total' => $query_faq->max_num_pages,
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