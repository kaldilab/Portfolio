<?php get_header(); ?>

<?php
// CPT
$post_name = $post->post_name;
$custom_post_type = 'cpt_' . $post_name;
$custom_taxonomy = 'tax_' . $post_name;
?>

<div class="sub__top">
  <h2 class="sub__title"><?php the_title(); ?></h2>
  <?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>

<?php
// get field
$etc_faq = get_field('etc_faq', 'option');
$faq_information_set = $etc_faq['faq_information_set'];
$faq_information = $etc_faq['faq_information'];
?>

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_faq = array(
  'post_type' => $custom_post_type,
  'posts_per_page' => 5,
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
      'taxonomy' => $custom_taxonomy,
      'field' => 'term_id',
      'terms' => $_GET['t'],
    )
  );
} else {
  $t = null;
}
$query_faq = new WP_Query($args_faq);
?>

<?php
// taxonomy
$terms_faq = get_terms([
  'taxonomy' => $custom_taxonomy,
  'hide_empty' => false,
]);
?>

<!-- 카테고리 -->
<?php if ($terms_faq) : ?>
  <ul class="nav nav-tabs tabs-faq">
    <?php
    $active_all = (empty($t)) ? 'active' : '';
    echo '<li class="nav-item"><a class="nav-link ' . $active_all . '" href="' . project_permalink() . '">전체</a></li>';
    foreach ($terms_faq as $term) :
      $active_term = ($t == $term->term_id) ? 'active' : '';
      echo '<li class="nav-item"><a class="nav-link ' . $active_term . '" href="' . project_permalink() . '?t=' . $term->term_id . '">' . $term->name . '</a></li>';
    endforeach;
    ?>
  </ul>
<?php endif; ?>
<!-- //카테고리 -->

<section class="section faq">
  <h3 class="sr-only"><?php the_title(); ?></h3>

  <!-- 리스트 -->
  <ul class="accordion-list" id="accordionFaq">
    <?php
    if ($query_faq->have_posts()) {
      $index = 1;
      while ($query_faq->have_posts()) {
        $query_faq->the_post();
        $collapsed = ($index == 1) ? '' : 'collapsed';
        $expanded = ($index == 1) ? 'true' : 'false';
        $show = ($index == 1) ? 'show' : '';
        $content = get_the_content();
        $cotent_with_breaks = wpautop($content);
        echo '<li class="accordion-item">';
        echo '<div id="heading' . $index . '">';
        echo '<a class="accordion-head ' . $collapsed . '" data-toggle="collapse" href="#collapse' . $index . '" role="button" aria-expanded="' . $expanded . '" aria-controls="collapse' . $index . '">';
        echo '<strong class="h4">Q</strong>';
        echo '<p class="tit h5_left">' . get_the_title() . '</p>';
        echo '</a>';
        echo '</div>';
        echo '<div id="collapse' . $index . '" class="collapse ' . $show . '" aria-labelledby="heading' . $index . '" data-parent="#accordionFaq">';
        echo '<div class="accordion-body">';
        echo '<strong class="h4">A</strong>';
        echo '<div class="cont">' . $cotent_with_breaks . '</div>';
        echo '</div>';
        echo '</div>';
        echo '</li>';
        $index++;
      }
    } else {
      echo '<li class="accordion-item none">게시글이 없습니다.</li>';
    }
    wp_reset_postdata();
    ?>
  </ul>
  <!-- //리스트 -->

  <!-- 페이지네비 -->
  <div class="pagenavi">
    <?php
    $pagenavi = array(
      'total' => $query_faq->max_num_pages,
      'prev_text' => '<i>이전</i>',
      'next_text' => '<i>다음</i>',
      'mid_size' => 1,
    );
    echo paginate_links($pagenavi);
    ?>
  </div>
  <!-- //페이지네비 -->

  <!-- information -->
  <?php if ($faq_information_set) : ?>
    <div class="information inform-link">
      <h5 class="h5_left"><?php echo $faq_information['title']; ?></h5>
      <p class="desc"><?php echo $faq_information['description']; ?></p>
      <a class="btn btn-gray" href="<?php echo $faq_information['button_link']; ?>" target="_blank"><?php echo $faq_information['button_name']; ?></a>
    </div>
  <?php endif; ?>
  <!-- /information -->

</section>


<?php get_footer(); ?>