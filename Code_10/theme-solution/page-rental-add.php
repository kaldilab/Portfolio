<?php acf_form_head(); ?>
<?php get_header(); ?>

<?php
// CPT
$post_name = $post->post_name;
$post_name = str_replace('-add', '', $post_name);
$custom_post_type = 'cpt_' . $post_name;
?>

<div class="sub__top">
  <h2 class="sub__title"><?php the_title(); ?></h2>
  <?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>
<!-- 작성 폼 -->
<section class="section">

  <?php
  // hide filed
  add_filter('acf/prepare_field/name=rental_limit', function () {
    return false;
  });
  add_filter('acf/prepare_field/name=rental_status', function () {
    return false;
  });
  add_filter('acf/prepare_field/name=rental_reason', function () {
    return false;
  });
  ?>

  <?php
  acf_form(array(
    'post_id' => 'new_post',
    'post_title' => true,
    'new_post' => array(
      'post_type' => $custom_post_type,
      'post_status' => 'private',
    ),
    'submit_value' => '작성완료',
    'return' => add_query_arg('updated_rental', 'true', home_url('/')),
  ));
  ?>

</section>
<!-- //작성 폼 -->

<?php get_footer(); ?>