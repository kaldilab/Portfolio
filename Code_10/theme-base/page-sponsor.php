<?php acf_form_head(); ?>
<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!-- 후원하기 -->
<div>
  <h3>후원하기</h3>
  <a class="btn btn-danger" href="#" target="_blank">외부링크</a>
</div>
<!-- //후원하기 -->

<hr>

<!-- 후원 신청하기 -->
<div>
  <h3>후원 신청하기</h3>
  <form class="form" id="applyForm" method="POST" novalidate>
    <div class="form-group">
      <label for="apply_name">이름 <span class="est">*</span></label>
      <input type="text" class="form-control" id="apply_name" name="apply_name" placeholder="이름을 입력하세요.">
    </div>
    <div class="form-group">
      <label for="apply_nickname">닉네임 <span class="est">*</span></label>
      <input type="text" class="form-control" id="apply_nickname" name="apply_nickname" placeholder="닉네임을 입력하세요.">
    </div>
    <div class="form-group">
      <label for="apply_password">비밀번호 <span class="est">*</span></label>
      <input type="password" class="form-control" id="apply_password" name="apply_password" placeholder="비밀번호를 입력하세요.">
    </div>
    <div class="form-group">
      <label for="apply_confirm_password">비밀번호 확인 <span class="est">*</span></label>
      <input type="password" class="form-control" id="apply_confirm_password" name="apply_confirm_password" placeholder="비밀번호를 입력하세요.">
    </div>
    <div class="form-group">
      <label for="apply_email">이메일 <span class="est">*</span></label>
      <input type="email" class="form-control" id="apply_email" name="apply_email" placeholder="이메일을 입력하세요.">
    </div>
    <div class="form-group">
      <label for="apply_url">홈페이지</label>
      <input type="url" class="form-control" id="apply_url" name="apply_url" placeholder="홈페이지를 입력하세요.">
    </div>
    <div class="form-group">
      <label for="apply_comment">신청 이유 <span class="est">*</span></label>
      <textarea class="form-control" id="apply_comment" name="apply_comment" placeholder="신청 이유를 입력하세요." rows="10"></textarea>
    </div>
    <div class="form-group">
      <label for="apply_agree">개인정보보호방침에 동의합니다. <span class="est">*</span></label>
      <input type="checkbox" class="checkbox" id="apply_agree" name="apply_agree">
    </div>
    <div class="form-group">
      <input class="btn btn-dark" type="submit" value="신청하기">
    </div>
  </form>
</div>
<!-- 후원신청하기 -->

<script>
  jQuery(document).ready(function($) {

    // validation
    $("#applyForm").validate({
      rules: {
        apply_name: {
          required: true,
          minlength: 2
        },
        apply_nickname: {
          required: true,
          minlength: 2
        },
        apply_password: {
          required: true,
          minlength: 5
        },
        apply_confirm_password: {
          required: true,
          minlength: 5,
          equalTo: "#apply_password"
        },
        apply_email: {
          required: true,
          email: true
        },
        apply_url: {
          url: true
        },
        apply_comment: {
          required: true,
          minlength: 10
        },
        apply_agree: "required"
      },
      messages: {
        apply_name: {
          required: "이름을 입력하세요.",
          minlength: "2자 이상 입력하세요."
        },
        apply_nickname: {
          required: "닉네임을 입력하세요.",
          minlength: "2자 이상 입력하세요."
        },
        apply_password: {
          required: "비밀번호를 입력하세요.",
          minlength: "5자 이상 입력하세요."
        },
        apply_confirm_password: {
          required: "비밀번호를 입력하세요.",
          minlength: "5자 이상 입력하세요.",
          equalTo: "동일한 비밀번호를 입력하세요."
        },
        apply_email: {
          required: "이메일주소를 입력하세요.",
          email: "유효하지 않은 이메일주소입니다.",
        },
        apply_url: {
          url: "유효하지 않은 URL입니다.",
        },
        apply_comment: {
          required: "신청 이유를 입력하세요.",
          minlength: "10자 이상 입력하세요.",
        },
        apply_agree: "동의하세요.",
      },
      submitHandler: function(form) {
        alert("후원 신청이 접수되었습니다.");
        form.submit();
      }
    });

  });
</script>

<?php get_footer(); ?>