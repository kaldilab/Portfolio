<?php get_header(); ?>

<section class="section notfound">
  <figure class="notfound__figure">
    <img src="<?php echo project_image_uri('img_404.png'); ?>" alt="404 Not Found">
  </figure>
  <h2 class="notfound__title">존재하지 않는 페이지 입니다.</h2>
  <p class="notfound__desc">입력한 페이지의 주소가 정확한지 다시 한 번 확인해주세요.</p>
  <div class="notfound__btn">
    <a class="btn" href="<?php echo project_homeurl('/'); ?>" rel="home">메인으로 이동</a>
  </div>
</section>

<?php get_footer(); ?>