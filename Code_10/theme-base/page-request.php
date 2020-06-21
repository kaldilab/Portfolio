<?php acf_form_head(); ?>
<?php get_header(); ?>

<?php echo project_send_message(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!-- 외부 폼 -->
<!-- <iframe src="" frameborder="0"></iframe> -->
<!-- //외부 폼 -->

<!-- 작성 폼 -->
<h3>문의하기 - 관리자 페이지</h3>
<div>
  <?php
  acf_form(array(
    'post_id' => 'new_post',
    'post_title' => true,
    'new_post' => array(
      'post_type' => 'request',
      'post_status' => 'pending',
    ),
    'submit_value' => '전송하기',
    'return' => add_query_arg('updated', 'true'),
    'updated_message' => false,
  ));
  ?>
</div>
<!-- //작성 폼 -->

<hr>

<!-- 이메일 폼 -->
<h3>문의하기 - 관리자 이메일</h3>
<div>
  <?php
  if (isset($_POST['submit_request'])) {
    $to = 'test@test.com';
    $name = $_POST['request_name'];
    $from = $_POST['request_email'];
    $from = "=?utf-8?B?" . base64_encode($from) . "?=\n";
    $subject = $_POST['request_subject'] . ' (' . date_i18n('Y-m-d') . ')';
    $content = '
    <div style="background:#eee;padding:20px;line-height:1.5;">
    <h3 style="margin-bottom:20px;">[이름]: ' . $name . '</h3>
    <h3 style="margin-bottom:20px;">[이메일]: ' . $from . '</h3>
    <h3 style="margin-bottom:20px;">[내용]</h3>
    <div style="font-size:14px;white-space:pre-line;">' . $_POST['request_content'] . '</div>
    </div>';
    $headers[] = 'From: ' . $name . ' <' . $from . '>';
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $attachment = array();
    for ($i = 0; $i < 3; $i++) {
      if (!empty($_FILES['request_file_' . $i])) {
        if (is_uploaded_file($_FILES['request_file_' . $i]['tmp_name']) && $_FILES['request_file_' . $i]['error'] == 0) {
          $file_name = date('YmdHis', time()) . '_' . $_FILES['request_file_' . $i]['name'];
          $destination = WP_CONTENT_DIR . '/uploads/request/' . str_replace(' ', '_', $file_name);
          if (!move_uploaded_file($_FILES['request_file_' . $i]['tmp_name'], $destination)) {
            die('파일 업로드에 실패하였습니다. 다시 시도해주세요.');
          } else {
            array_push($attachment, $destination);
          }
        }
      } else {
        $attachment = ' ';
      }
    }

    wp_mail($to, $subject, $content, $headers, $attachment);

    echo '<script type="text/javascript">';
    echo 'window.location="/"';
    echo '</script>';
  }
  ?>

  <!-- 우편번호 -->
  <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
  <script>
    function request_execDaumPostcode() {
      new daum.Postcode({
        oncomplete: function(data) {
          // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
          // 각 주소의 노출 규칙에 따라 주소를 조합한다.
          // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
          var addr = ''; // 주소 변수
          var extraAddr = ''; // 참고항목 변수

          //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
          if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
            addr = data.roadAddress;
          } else { // 사용자가 지번 주소를 선택했을 경우(J)
            addr = data.jibunAddress;
          }

          // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
          if (data.userSelectedType === 'R') {
            // 법정동명이 있을 경우 추가한다. (법정리는 제외)
            // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
            if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
              extraAddr += data.bname;
            }
            // 건물명이 있고, 공동주택일 경우 추가한다.
            if (data.buildingName !== '' && data.apartment === 'Y') {
              extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
            }
            // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
            if (extraAddr !== '') {
              extraAddr = ' (' + extraAddr + ')';
            }
            // 조합된 참고항목을 해당 필드에 넣는다.
            document.getElementById("request_extraAddress").value = extraAddr;

          } else {
            document.getElementById("request_extraAddress").value = '';
          }

          // 우편번호와 주소 정보를 해당 필드에 넣는다.
          document.getElementById('request_postcode').value = data.zonecode;
          document.getElementById("request_address").value = addr;

          // 커서를 상세주소 필드로 이동한다.
          document.getElementById("request_detailAddress").focus();
        }
      }).open();
    }
  </script>
  <!-- //우편번호 -->

  <form class="form" id="requestForm" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="request_name">이름 <span class="est">*</span></label>
      <input type="text" class="form-control" id="request_name" name="request_name" placeholder="이름을 입력하세요.">
    </div>
    <div class="form-group">
      <label for="request_email">이메일 <span class="est">*</span></label>
      <input type="email" class="form-control" id="request_email" name="request_email" placeholder="이메일을 입력하세요.">
    </div>
    <div class="form-group">
      <label class="col-form-label" for="request_address">주소 <span class="est">*</span></label>
      <label class="sr-only" for="request_searchAddress">주소검색</label>
      <input type="button" class="btn btn-dark" id="request_searchAddress" value="주소검색" onclick="request_execDaumPostcode()">
      <label class="sr-only" for="request_postcode">우편번호</label>
      <input type="text" class="form-control" id="request_postcode" name="request_postcode" onclick="request_execDaumPostcode()" placeholder="우편번호를 입력하세요.">
      <div class="clearfix"></div>
      <label class="sr-only" for="request_address">주소</label>
      <input type="text" class="form-control" id="request_address" name="request_address" placeholder="주소를 입력하세요.">
      <label class="sr-only" for="request_detailAddress">상세 주소</label>
      <input type="text" class="form-control" id="request_detailAddress" name="request_detailAddress" placeholder="상세 주소를 입력하세요.">
      <input type="hidden" id="request_extraAddress" name="request_extraAddress">
    </div>
    <div class="form-group">
      <label for="request_subject">제목 <span class="est">*</span></label>
      <input type="text" class="form-control" id="request_subject" name="request_subject" placeholder="제목을 입력하세요.">
    </div>
    <div class="form-group">
      <label for="request_content">내용 <span class="est">*</span></label>
      <textarea class="form-control" id="request_content" name="request_content" placeholder="내용을 입력하세요." rows="10"></textarea>
    </div>
    <div class="form-group">
      <label for="request_file_0">첨부파일</label>
      <div class="form-file">
        <input type="text" class="form-control d-inline-block file_name" style="width:80%;" placeholder="jpg, png, zip, pdf" disabled>
        <label class="form-control d-inline-block border file_label btn" style="width:15%;" for="request_file_0">파일찾기</label>
        <input type="file" class="file_upload sr-only" id="request_file_0" name="request_file_0">
        <a class="file_clear" href="#" style="display: none;">초기화</a>
      </div>
      <div class="form-file">
        <input type="text" class="form-control d-inline-block file_name" style="width:80%;" placeholder="jpg, png, zip, pdf" disabled>
        <label class="form-control d-inline-block border file_label btn" style="width:15%;" for="request_file_1">파일찾기</label>
        <input type="file" class="file_upload sr-only" id="request_file_1" name="request_file_1">
        <a class="file_clear" href="#" style="display: none;">초기화</a>
      </div>
      <div class="form-file">
        <input type="text" class="form-control d-inline-block file_name" style="width:80%;" placeholder="jpg, png, zip, pdf" disabled>
        <label class="form-control d-inline-block border file_label btn" style="width:15%;" for="request_file_2">파일찾기</label>
        <input type="file" class="file_upload sr-only" id="request_file_2" name="request_file_2">
        <a class="file_clear" href="#" style="display: none;">초기화</a>
      </div>
    </div>
    <div class="form-group">
      <input class="btn btn-dark" type="submit" value="문의 전송" name="submit_request">
    </div>
  </form>
</div>
<!-- //이메일 폼 -->

<script>
  jQuery(document).ready(function($) {

    // validation
    $("#requestForm").validate({
      rules: {
        request_name: {
          required: true,
          minlength: 5
        },
        request_email: {
          required: true,
          email: true
        },
        request_postcode: {
          required: true,
          number: true,
        },
        request_address: "required",
        request_detailAddress: "required",
        request_subject: "required",
        request_content: {
          required: true,
          minlength: 10
        },
        request_file_0: "required",
      },
      messages: {
        request_name: {
          required: "이름을 입력하세요.",
          minlength: "5자 이상 입력하세요."
        },
        request_email: {
          required: "이메일주소를 입력하세요.",
          email: "유효하지 않은 이메일주소입니다."
        },
        request_postcode: {
          required: "우편번호를 입력하세요.",
          number: "유효하지 않은 우편번호입니다.",
        },
        request_address: "주소를 입력하세요.",
        request_detailAddress: "상세주소를 입력하세요.",
        request_subject: "제목을 입력하세요.",
        request_content: {
          required: "내용을 입력하세요.",
          minlength: "10자 이상 입력하세요.",
        },
        request_file_0: "첨부파일을 등록하세요.",
      },
      submitHandler: function(form) {
        alert("문의 메일이 접수되었습니다.");
        form.submit();
      }
    });

    // upload file name
    $('.form-file').each(function() {
      $(this).find('.file_upload').on('change', function() {
        // 파일명 출력
        var file_size_confirm = fileCheck($(this)[0].files[0]);
        if (file_size_confirm) {
          if (window.FileReader) {
            var filename = $(this)[0].files[0].name;
          } else {
            var filename = $(this).val().split('/').pop().split('\\').pop();
          }
          $(this).siblings('.file_name').val(filename);
        } else {
          $(this).siblings('.file_name').val('');
          $(this).val('');
        }
        // 파일 초기화
        if ($(this).val()) {
          $(this).siblings('.file_clear').show();
        } else {
          $(this).siblings('.file_clear').hide();
        }
      });
      $(this).find('.file_clear').on('click', function(event) {
        event.preventDefault();
        $(this).hide();
        $(this).siblings('.file_upload').val('');
        $(this).siblings('.file_name').val('');
      });
    });

    // upload file check
    function fileCheck(file) {
      // 사이즈체크
      var maxSize = 10 * 1024 * 1024 //10MB
      var fileSize = 0;
      // 브라우저 확인
      var browser = navigator.appName;
      // 익스플로러일 경우
      if (browser == "Microsoft Internet Explorer") {
        var oas = new ActiveXObject("Scripting.FileSystemObject");
        fileSize = oas.getFile(file.value).size;
      }
      // 익스플로러가 아닐경우
      else {
        fileSize = file.size;
      }
      var digitFileSize = fileSize.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

      if (fileSize > maxSize) {
        alert("첨부파일 사이즈는 10MB 이내로 등록 가능합니다.\n현재 파일 사이즈 : " + digitFileSize + "Byte");
        return false;
      } else if ((!/(\.jpg|\.png|\.pdf|\.zip)$/i.test(file.name))) {
        alert("jpg, png, zip, pdf 파일만 등록 가능합니다.");
        return false;
      } else {
        return true;
      }
    }

  });
</script>

<?php get_footer(); ?>