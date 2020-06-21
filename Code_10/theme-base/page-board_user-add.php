<?php acf_form_head(); ?>
<?php get_header(); ?>

<?php
isset($_GET['id']) ? $post_id = $_GET['id'] : $post_id = null;
isset($_GET['return']) ? $return = $_GET['return'] : $return = null;
?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!-- 작성/수정 폼 -->
<div class="<?php echo (empty($post_id)) ? 'form_write' : 'form_modify'; ?>">

  <?php
  if (empty($post_id)) {
    // 작성
    acf_form(array(
      'post_id' => 'new_post',
      'post_title' => true,
      'post_content' => true,
      'new_post' => array(
        'post_type' => 'board_user',
        'post_status' => 'publish',
      ),
      'uploader' => 'basic',
      'submit_value' => '작성완료',
      'return' => add_query_arg('updated', 'true', home_url($return)),
    ));
  } else {
    // 수정
    acf_form(array(
      'post_id' => $post_id,
      'post_title' => true,
      'post_content' => true,
      'post_type' => 'acf-field-group',
      'uploader' => 'basic',
      'submit_value' => '수정완료',
      'return' => add_query_arg('updated', 'true', '%post_url%'),
    ));
  }
  ?>

</div>
<!-- //작성/수정 폼 -->

<?php get_footer(); ?>