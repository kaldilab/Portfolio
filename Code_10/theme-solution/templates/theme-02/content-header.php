<?php
// get field
$logo = get_field('theme_02_main_logo', 'option');
$logo_size = $logo['size'];
$logo_image = $logo['image'];
$utilmenu = get_field('theme_02_main_utilmenu', 'option');
?>

<header class="header <?php echo (!is_home()) ? 'active-sub' : ''; ?>">
  <div class="header__inner">

    <!-- 메뉴 -->
    <nav class="header__nav">
      <button class="header__navbtn" aria-label="메뉴 열기/닫기"><span class="sr-only">메뉴 버튼</span></button>
      <?php wp_nav_menu(array(
        'theme_location' => 'main-menu',
        'container' => false,
        'menu_class' => 'nav-menu'
      )); ?>
    </nav>
    <!-- //메뉴 -->

    <!-- 타이틀 -->
    <a class="header__title" href="<?php echo project_homeurl('/'); ?>" rel="home">
      <img src="<?php echo ($logo_image) ? $logo_image : (get_template_directory_uri() . '/images/logo.png'); ?>" alt="<?php echo esc_html(get_bloginfo('name')); ?>" style="width: <?php echo (wp_is_mobile()) ? $logo_size['mo'] : $logo_size['pc']; ?>px;">
    </a>
    <!-- //타이틀 -->

    <!-- 유틸 -->
    <div class="header__util">

      <!-- 유틸메뉴 -->
      <ul class="header__utilmenu">
        <?php
        if ($utilmenu) {
          foreach ($utilmenu as $row) {
            $outlink = ($row['outlink']) ? 'target="_blank"' : '';
            echo '<li>';
            echo '<a class="link" href="' . $row['link'] . '" ' . $outlink . '>' . $row['title'] . '</a>';
            echo '</li>';
          }
        }
        ?>
      </ul>
      <!-- //유틸메뉴 -->

      <!-- 검색 -->
      <div class="header__search">
        <button class="header__searchbtn" aria-label="검색창 열기"><i class="xi-search"></i></button>
        <?php get_template_part('templates/content', 'searchbar'); ?>
      </div>
      <!-- //검색 -->

    </div>
    <!-- //유틸 -->


  </div>
</header>