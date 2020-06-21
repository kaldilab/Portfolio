<?php
$url = urlencode(get_the_permalink());
$title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));
$media = urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full'));
$etc_view = get_field('etc_view', 'option');
$kakao_api = $etc_view['kakao_api'];
$share = $etc_view['share'];
?>

<!-- 네이버 -->
<?php if (in_array('naver', $share)) : ?>
  <a class="share naver" href="//share.naver.com/web/shareView.nhn?url=<?php echo $url; ?>&title=<?php the_title(); ?>" target="_blank" title="네이버"></a>
<?php endif; ?>

<!-- 페이스북 -->
<?php if (in_array('facebook', $share)) : ?>
  <a class="share facebook" href="//www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank" title="페이스북"></a>
<?php endif; ?>

<!-- 카카오톡 -->
<?php if (in_array('kakaotalk', $share)) : ?>
  <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
  <a class="share kakaotalk" href="javascript:;" id="shareKakao" title="카카오톡"></a>
  <script>
    //<![CDATA[
    // 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init('<?php echo $kakao_api; ?>');
    // 카카오링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
    Kakao.Link.createScrapButton({
      container: '#shareKakao',
      requestUrl: '<?php echo project_permalink(); ?>',
    });
    //]]>
  </script>
<?php endif; ?>

<!-- 트위터 -->
<?php if (in_array('twitter', $share)) : ?>
  <a class="share twitter" href="//twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php echo $url; ?>&amp;via=<?php echo get_bloginfo('name'); ?>" target="_blank" title="트위터"></a>
<?php endif; ?>

<!-- 이메일 -->
<?php if (in_array('email', $share)) : ?>
  <a class="share email" href="mailto:?subject=[<?php echo get_bloginfo('name'); ?>] <?php the_title(); ?>&body=<?php echo get_bloginfo('name'); ?>에서 찾은 글을 공유합니다.\n[<?php the_title(); ?>]\n<a href='<?php echo project_permalink(); ?>'><?php echo project_permalink(); ?></a>" target="_blank" title="이메일"></a>
<?php endif; ?>

<!-- URL복사 -->
<?php if (in_array('urlcopy', $share)) : ?>
  <input class="sr-only" id="shareUrl" type="text" value="<?php echo project_permalink(); ?>">
  <a class="share urlcopy" href="javascript:shareUrl();" title="URL복사"></a>
  <script>
    function shareUrl() {
      var copyText = document.getElementById("shareUrl");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      alert("URL이 클립보드에 복사되었습니다.");
    }
  </script>
<?php endif; ?>