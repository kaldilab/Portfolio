<?php get_header(); ?>

<div class="swiper swiper-container">
  <div class="swiper-wrapper">
    <?php
    if (have_rows('visual_slider', 'option')) {
      while (have_rows('visual_slider', 'option')) {
        the_row();
        echo '<div class="swiper-slide">';
        echo '<a href="' . get_sub_field('link') . '" target="_blank">';
        echo '<span class="position-absolute" style="display:flex;width:100%;height:100%;align-items:center;justify-content:center;font-size:40px">' . get_sub_field('text') . '</span>';
        if (wp_is_mobile()) {
          echo '<figure><img class="img-fluid" src="' . get_sub_field('image_mo') . '" alt="슬라이더 모바일 이미지"></figure>';
        } else {
          echo '<figure><img class="img-fluid" src="' . get_sub_field('image_pc') . '" alt="슬라이더 피씨 이미지"></figure>';
        }
        echo '</a>';
        echo '</div>';
      }
    }
    ?>
  </div>
</div>

<div class="row mt-5">
  <div class="col">
    <h3>회원게시판 최신글</h3>
    <?php
    $args_board_user = array(
      'post_type' => 'board_user',
      'posts_per_page' => 5,
    );
    $query_board_user = new WP_Query($args_board_user);
    ?>
    <div class="card-group">
      <?php
      if ($query_board_user->have_posts()) {
        while ($query_board_user->have_posts()) {
          $query_board_user->the_post();
          $terms = get_the_terms(false, 'tax_board_user');
          echo '<div class="card">';
          echo project_card_image('default.jpg');
          echo '<div class="card-body">';
          echo '<div class="card-title"><a href="' . project_permalink() . '"><strong>[' . $terms[0]->name . ']</strong> ' . get_the_title() . '</a></div>';
          echo '<div class="card-text"><p class="text-truncate">' . get_the_excerpt() . '</p></div>';
          echo '</div>';
          echo '<div class="card-footer">' . get_the_date() . ' ' . get_the_time() . '</div>';
          echo '</div>';
        }
      } else {
        echo '<div class="card">';
        echo '<p class="none">게시글이 없습니다.</p>';
        echo '</div>';
      }
      wp_reset_postdata();
      ?>
    </div>
  </div>
</div>

<div class="row mt-5">
  <div class="col">
    <h3>특정 카테고게시판 최신글</h3>
    <?php
    $categories = get_categories();
    foreach ($categories as $category) {
      $category_slug = $category->slug;
      if ($category_slug == 'card') {
        $category_id = $category->term_id;
      }
    }
    $args_category = array(
      'cat' => $category_id,
      'posts_per_page' => 5,
    );
    $query_category = new WP_Query($args_category);
    ?>
    <div class="card-group">
      <?php
      if ($query_category->have_posts()) {
        while ($query_category->have_posts()) {
          $query_category->the_post();
          $category = get_the_category();
          echo '<div class="card">';
          echo project_card_image('default.jpg');
          echo '<div class="card-body">';
          echo '<div class="card-title"><a href="' . project_permalink() . '"><strong>[' . $category[0]->name . ']</strong> ' . get_the_title() . '</a></div>';
          echo '<div class="card-text"><p class="text-truncate">' . get_the_excerpt() . '</p></div>';
          echo '</div>';
          echo '<div class="card-footer">' . get_the_date() . ' ' . get_the_time() . '</div>';
          echo '</div>';
        }
      } else {
        echo '<div class="card">';
        echo '<p class="none">게시글이 없습니다.</p>';
        echo '</div>';
      }
      wp_reset_postdata();
      ?>
    </div>
  </div>
</div>

<div class="row mt-5">
  <div class="col">
    <h3>관리자게시판 최신글</h3>
    <?php
    $args_board_recent = array(
      'post_type' => 'board_admin',
      'posts_per_page' => 5,
    );
    $query_board_recent = new WP_Query($args_board_recent);
    ?>
    <ul class="list-group">
      <?php
      if ($query_board_recent->have_posts()) {
        while ($query_board_recent->have_posts()) {
          $query_board_recent->the_post();
          $terms = get_the_terms(false, 'tax_board_admin');
          echo '<li class="list-group-item">';
          echo '<span>[' . $terms[0]->name . ']</span> ';
          echo '<span><a href="' . project_permalink() . '">' . get_the_title() . '</a></span>';
          echo '<span>' . get_the_date() . '</span>';
          echo '</li>';
        }
      } else {
        echo '<li class="list-group-item">';
        echo '<span class="none">게시글이 없습니다.</span>';
        echo '</li>';
      }
      wp_reset_postdata();
      ?>
    </ul>
  </div>
  <div class="col">
    <h3>관리자게시판 특정 카테고리</h3>
    <?php
    $args_board_category = array(
      'post_type' => 'board_admin',
      'posts_per_page' => 5,
      'tax_query' => array(
        array(
          'taxonomy' => 'tax_board_admin',
          'field' => 'term_id',
          'terms' => 12,
        )
      ),
    );
    $query_board_category = new WP_Query($args_board_category);
    ?>
    <ul class="list-group">
      <?php
      if ($query_board_category->have_posts()) {
        while ($query_board_category->have_posts()) {
          $query_board_category->the_post();
          $terms = get_the_terms(false, 'tax_board_admin');
          echo '<li class="list-group-item">';
          echo '<span>[' . $terms[0]->name . ']</span> ';
          echo '<span><a href="' . project_permalink() . '">' . get_the_title() . '</a></span>';
          echo '<span>' . get_the_date() . '</span>';
          echo '</li>';
        }
      } else {
        echo '<li class="list-group-item">';
        echo '<span class="none">게시글이 없습니다.</span>';
        echo '</li>';
      }
      wp_reset_postdata();
      ?>
    </ul>
  </div>
  <div class="col">
    <h3>관리자게시판 메인 노출글</h3>
    <?php
    $args_board_main = array(
      'post_type' => 'board_admin',
      'posts_per_page' => 5,
      'meta_key' => 'board_admin_main',
      'meta_value' => '1',
    );
    $query_board_main = new WP_Query($args_board_main);
    ?>
    <ul class="list-group">
      <?php
      if ($query_board_main->have_posts()) {
        while ($query_board_main->have_posts()) {
          $query_board_main->the_post();
          $terms = get_the_terms(false, 'tax_board_admin');
          echo '<li class="list-group-item">';
          echo '<span>[' . $terms[0]->name . ']</span> ';
          echo '<span><a href="' . project_permalink() . '">' . get_the_title() . '</a></span>';
          echo '<span>' . get_the_date() . '</span>';
          echo '</li>';
        }
      } else {
        echo '<li class="list-group-item">';
        echo '<span class="none">게시글이 없습니다.</span>';
        echo '</li>';
      }
      wp_reset_postdata();
      ?>
    </ul>
  </div>
</div>

<div class="row mt-5">
  <?php
  if (have_rows('visual_banner', 'option')) {
    while (have_rows('visual_banner', 'option')) {
      the_row();
      echo '<span class="position-absolute">' . get_sub_field('text') . '</span>';
      if (wp_is_mobile()) {
        echo '<figure><img class="img-fluid" src="' . get_sub_field('image_mo') . '" alt="배너 모바일 이미지"></figure>';
      } else {
        echo '<figure><img class="img-fluid" src="' . get_sub_field('image_pc') . '" alt="배너 피씨 이미지"></figure>';
      }
    }
  }
  ?>
</div>

<div class="row mt-5">
  <div class="col">
    <h3>태그 검색 : 태그 페이지로(인기순 3개)</h3>
    <?php
    $favorite_tags = get_tags(
      array(
        'orderby' => 'count',
        'order' => 'DESC'
      )
    );
    ?>
    <ul class="list-group">
      <?php
      if ($favorite_tags) {
        $index = 1;
        foreach ($favorite_tags as $tag) {
          echo '<li class="list-group-item"><a href="' . esc_url(get_tag_link($tag->term_id)) . '">#' . $tag->name . '(' . $tag->count . ')</a></li>';
          if ($index++ == 3) break;
        }
      }
      ?>
    </ul>
  </div>
  <div class="col">
    <h3>태그 검색 : 검색 페이지로(가나다순 3개)</h3>
    <?php
    $alphabet_tags = get_tags(
      array(
        'orderby' => 'name',
        'order' => 'ASC'
      )
    );
    ?>
    <ul class="list-group">
      <?php
      if ($alphabet_tags) {
        $index = 1;
        foreach ($alphabet_tags as $tag) {
          echo '<li class="list-group-item"><a href="' . project_homeurl('/?s=') . '' . $tag->name . '">#' . $tag->name . '(' . $tag->count . ')</a></li>';
          if ($index++ == 3) break;
        }
      }
      ?>
    </ul>
  </div>
</div>

<div class="row mt-5">
  <div class="col font-16">
    <h3>태그 클라우드(인기순)</h3>
    <?php wp_tag_cloud(array(
      'smallest' => 12,
      'largest' => 30,
      'number' => 10,
      'orderby' => 'count',
      'order' => 'DESC',
    )); ?>
  </div>
</div>

<?php get_template_part('templates/content', 'popup'); ?>

<script>
  // backend script
  jQuery(document).ready(function($) {

    var swiper = new Swiper('.swiper', {
      loop: true,
      speed: 1000,
      grabCursor: true,
      autoplay: {
        delay: 1500,
        disableOnInteraction: false,
      },
    });

  });
</script>

<?php get_footer(); ?>