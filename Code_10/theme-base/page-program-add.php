<?php acf_form_head(); ?>
<?php get_header(); ?>

<?php
isset($_GET['id']) ? $post_id = $_GET['id'] : $post_id = null;
isset($_GET['return']) ? $return = $_GET['return'] : $return = null;
$post_title = get_the_title($post_id);
?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!-- 작성 폼 -->
<div>

  <h3>프로그램명 : <?php echo $post_title ?></h3>

  <?php
  // load program id
  function acf_load_field_program_apply_id($field)
  {
    $field['readonly'] = true;
    $field['value'] = $_GET['id'];
    return $field;
  }
  add_filter('acf/load_field/name=program_apply_id', 'acf_load_field_program_apply_id');
  ?>

  <?php
  acf_form(array(
    'post_id' => 'new_post',
    'new_post' => array(
      'post_type' => 'program_apply',
      'post_status' => 'pending',
      'post_title' => $post_title . ' (' . $post_id . ')',
    ),
    'submit_value' => '작성완료',
    'return' => add_query_arg('updated', 'true', home_url($return)),
  ));
  ?>

</div>
<!-- //작성 폼 -->

<?php get_footer(); ?>