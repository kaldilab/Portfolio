<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <!-- 본문바로가기 -->
  <a class="accesibility sr-only sr-only-focusable" href="#content"><?php echo '본문 바로가기'; ?></a>

  <div class="container">

    <header class="header">

      <div class="row pt-4 pb-4">

        <!-- 타이틀 -->
        <div class="col">
          <a href="<?php echo project_homeurl('/'); ?>">
            <img src="<?php echo project_image_uri('logo.png'); ?>" alt="<?php echo esc_html(get_bloginfo('name')); ?>" style="width:170px">
          </a>
        </div>
        <!-- //타이틀 -->

        <!-- 회원 -->
        <div class="col text-right">
          <?php if (is_user_logged_in()) : ?>
            <a class="btn btn-light" href="<?php echo wp_logout_url(home_url()); ?>">로그아웃</a>
          <?php else : ?>
            <a class="btn btn-light" href="<?php echo project_homeurl('login'); ?>">로그인</a>
          <?php endif; ?>
          <?php if ((is_user_logged_in()) && (!current_user_can('administrator'))) : ?>
            <a class="btn btn-light" href="<?php echo project_homeurl('account'); ?>">마이페이지</a>
          <?php elseif ((is_user_logged_in()) && (current_user_can('administrator'))) : ?>
            <a class="btn btn-light" href="<?php echo project_homeurl('admin'); ?>">관리자</a>
          <?php else : ?>
            <a class="btn btn-light" href="<?php echo project_homeurl('register'); ?>">회원가입</a>
          <?php endif; ?>
        </div>
        <!-- //회원 -->

      </div>

      <!-- 메뉴 -->
      <nav class="nav pt-4 pb-4">
        <?php wp_nav_menu(array(
          'theme_location' => 'main-menu',
          'container' => false,
          'menu_class' => 'nav__menu'
        )); ?>
      </nav>
      <!-- //메뉴 -->

      <!-- 검색 -->
      <div class="col text-right">
        <?php get_search_form(); ?>
      </div>
      <!-- /검색 -->

    </header>

    <main id="content" class="<?php echo (is_home()) ? 'main' : 'sub'; ?>">

      <hr>