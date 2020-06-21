<?php get_header(); ?>

<h1><?php single_cat_title(); ?>타입</h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php
$category = get_queried_object();
$category_id = $category->term_id;
?>

<?php
// 고정글
$args_category_pin = array(
  'cat' => $category_id,
  'posts_per_page' => -1,
  'meta_key' => 'category_pin',
  'meta_value' => '1',
);
$query_category_pin = new WP_Query($args_category_pin);
$count_category_pin = $query_category_pin->found_posts;

// 전체글(고정글 제외)
$paging = 10 - $count_category_pin;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_category = array(
  'cat' => $category_id,
  'posts_per_page' => $paging,
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
$count_category = $query_category->found_posts;
$count_category = $count_category - ($paged - 1) * $paging;
?>

<!-- 리스트 -->
<table class="table">
  <colgroup>
    <col style="width:10%">
    <col style="width:20%">
    <col style="width:*">
  </colgroup>
  <thead>
    <!-- 고정글 -->
    <?php
    if ($query_category_pin->have_posts()) {
      while ($query_category_pin->have_posts()) {
        $query_category_pin->the_post();
        echo '<tr>';
        echo '<th class="align-top">고정글</th>';
        echo '<th class="align-top">' . project_thumbnail_image('default.jpg') . '</th>';
        echo '<th class="align-top">';
        echo '<a href="' . project_permalink() . '">' . get_the_title() . '</a>';
        echo '<p>' . get_the_excerpt() . '</p>';
        echo '<p>' . get_the_date() . ' ' . get_the_time() . '</p>';
        echo '</th>';
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
    if ($query_category->have_posts()) {
      while ($query_category->have_posts()) {
        $query_category->the_post();
        echo '<tr>';
        echo '<td>' . $count_category . '</td>';
        echo '<td>' . project_thumbnail_image('default.jpg') . '</td>';
        echo '<td>';
        echo '<a href="' . project_permalink() . '">' . get_the_title() . '</a>';
        echo '<p>' . get_the_excerpt() . '</p>';
        echo '<p>' . get_the_date() . ' ' . get_the_time() . '</p>';
        echo '</td>';
        echo '</tr>';
        $count_category--;
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