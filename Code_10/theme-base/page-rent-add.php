<?php acf_form_head(); ?>
<?php get_header(); ?>

<?php
isset($_GET['return']) ? $return = $_GET['return'] : $return = null;
?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!-- 작성 폼 -->
<div>

  <?php
  // hide filed
  add_filter('acf/prepare_field/name=rent_limit', function () {
    return false;
  });
  add_filter('acf/prepare_field/name=rent_status', function () {
    return false;
  });
  add_filter('acf/prepare_field/name=rent_reason', function () {
    return false;
  });
  ?>

  <?php
  acf_form(array(
    'post_id' => 'new_post',
    'post_title' => true,
    'new_post' => array(
      'post_type' => 'rent',
      'post_status' => 'private',
    ),
    'submit_value' => '작성완료',
    'return' => add_query_arg('updated', 'true', home_url($return)),
  ));
  ?>

</div>
<!-- //작성 폼 -->

<?php get_footer(); ?>