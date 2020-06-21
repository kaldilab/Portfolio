<?php
$url = urlencode(get_the_permalink());
$title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));
$media = urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full'));
?>

<!-- 페이스북 -->
<a class="btn btn-dark" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank">페이스북</a>

<!-- 트위터 -->
<a class="btn btn-dark" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php echo $url; ?>&amp;via=<?php bloginfo('name'); ?>" target="_blank">트위터</a>

<!-- 카카오톡 -->
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<a class="btn btn-dark" href="javascript:;" id="shareKakao">카카오톡</a>
<script>
  //<![CDATA[
  // 사용할 앱의 JavaScript 키를 설정해 주세요.
  Kakao.init('카카오개발자계정JavaScript키');
  // 카카오링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
  Kakao.Link.createScrapButton({
    container: '#shareKakao',
    requestUrl: '<?php echo project_permalink(); ?>',
  });
  //]]>
</script>

<!-- 네이버 -->
<a class="btn btn-dark" href="http://share.naver.com/web/shareView.nhn?url=<?php echo $url; ?>&title=<?php the_title(); ?>" target="_blank">네이버</a>

<!-- 이메일 -->
<a class="btn btn-dark" href="mailto:?subject=[<?php bloginfo('name'); ?>] <?php the_title(); ?>&body=<?php bloginfo('name'); ?>에서 찾은 글을 공유합니다.\n[<?php the_title(); ?>]\n<a href='<?php echo project_permalink(); ?>'><?php echo project_permalink(); ?></a>" target="_blank">이메일</a>

<!-- URL복사 -->
<input class="sr-only" id="shareUrl" type="text" value="<?php echo project_permalink(); ?>">
<a class="btn btn-dark" href="javascript:shareUrl();">URL복사</a>
<script>
  function shareUrl() {
    var copyText = document.getElementById("shareUrl");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert("URL이 클립보드에 복사되었습니다.");
  }
</script>