<?php acf_form_head(); ?>
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
$etc_request = get_field('etc_request', 'option');
$request_information_set = $etc_request['request_information_set'];
$request_information = $etc_request['request_information'];
$request_policy = $etc_request['request_policy'];
?>

<section class="section request">

  <h3 class="sr-only">작성 폼</h3>

  <!-- information -->
  <?php if ($request_information_set) : ?>
    <div class="information inform-link">
      <p class="desc"><?php echo $request_information['description']; ?></p>
      <a class="btn btn-gray" href="<?php echo $request_information['button_link']; ?>" target="_blank"><?php echo $request_information['button_name']; ?></a>
    </div>
  <?php endif; ?>
  <!-- /information -->

  <!-- 작성 폼 -->
  <div class="request__form">
    <?php
    acf_form(array(
      'post_id' => 'new_post',
      'post_title' => true,
      'new_post' => array(
        'post_type' => $custom_post_type,
        'post_status' => 'private',
      ),
      'submit_value' => '문의하기',
      'return' => add_query_arg('updated_request', 'true', home_url('/')),
      'html_after_fields' => '<div class="request_policy">' . $request_policy . '</div>',
    ));
    ?>
  </div>
  <!-- //작성 폼 -->

</section>

<script>
  jQuery(document).ready(function($) {

    // validation
    $("#acf-form").validate({
      errorElement: "p",
      errorPlacement: function(error, element) {
        error.insertAfter(element.parents('.acf-input'));
      },
    });
    $('._post_title').rules('add', {
      required: true,
      minlength: 2,
      messages: {
        required: "제목을 입력하세요.",
        minlength: "2자 이상 입력하세요."
      }
    });
    $('.request_name').rules('add', {
      required: true,
      minlength: 2,
      messages: {
        required: "이름을 입력하세요.",
        minlength: "2자 이상 입력하세요."
      }
    });
    $('.request_email').rules('add', {
      required: true,
      email: true,
      messages: {
        required: "이메일주소를 입력하세요.",
        email: "유효하지 않은 이메일주소입니다."
      }
    });
    $('.request_content').rules('add', {
      required: true,
      messages: {
        required: "문의내용을 입력하세요.",
      }
    });
    $('.request_agree').rules('add', {
      required: true,
      messages: {
        required: "동의에 체크하세요.",
      }
    });

  });
</script>

<?php get_footer(); ?>