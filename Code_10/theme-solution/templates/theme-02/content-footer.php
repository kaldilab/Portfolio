<?php
// get field
$logo = get_field('theme_02_main_logo', 'option');
$logo_image = $logo['image'];
$utilmenu = get_field('theme_02_main_utilmenu', 'option');
$sns = get_field('theme_02_main_sns', 'option');
$name = get_field('theme_02_main_name', 'option');
?>

<footer class="footer">
  <div class="footer__top">

    <!-- 메뉴 -->
    <nav class="footer__nav">
      <?php wp_nav_menu(array(
        'theme_location' => 'main-menu',
        'container' => false,
        'menu_class' => 'nav-foot'
      )); ?>
    </nav>
    <!-- //메뉴 -->

    <!-- 유틸메뉴 -->
    <ul class="footer__utilmenu">
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

  </div>

  <div class="footer__bottom">

    <!-- SNS -->
    <ul class="footer__sns">
      <?php
      if ($sns) {
        foreach ($sns as $row) {
          $title = $row['title'];
          echo '<li><a class="link ' . $title['value'] . '" href="' . $row['link'] . '" target="_blank"><span class="sr-only">' . $title['label'] . '</span></a></li>';
        }
      }
      ?>
    </ul>
    <!-- //SNS -->

    <!-- 타이틀 -->
    <a class="footer__title" href="<?php echo project_homeurl('/'); ?>">
      <img src="<?php echo ($logo_image) ? $logo_image : (get_template_directory_uri() . '/images/logo.png'); ?>" alt="<?php echo esc_html(get_bloginfo('name')); ?>">
    </a>
    <!-- //타이틀 -->

    <!-- 주소및연락처 -->
    <div class="footer__address">
      <p class="contact"><?php echo get_field('theme_02_main_contact', 'option'); ?></p>
      <p class="copyright">Copyright <?php echo date('Y'); ?> <?php echo $name; ?>. All Rights Reserved.</p>
    </div>
    <!-- //주소및연락처 -->

  </div>
</footer>