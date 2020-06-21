<?php
// get field
$shortcut = get_field('theme_01_main_shortcut', 'option');
$sns = get_field('theme_01_main_sns', 'option');
$name = get_field('theme_01_main_name', 'option');
?>

<footer class="footer">
  <div class="footer__top">

    <!-- 바로가기 -->
    <ul class="footer__left">
      <?php
      if ($shortcut) {
        foreach ($shortcut as $row) {
          echo '<li><a class="link" href="' . $row['link'] . '">' . $row['title'] . '</a></li>';
        }
      }
      ?>
    </ul>
    <!-- //바로가기 -->

    <!-- SNS -->
    <ul class="footer__right">
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

  </div>

  <div class="footer__bottom">

    <!-- 주소및연락처 -->
    <p class="contact"><?php echo get_field('theme_01_main_contact', 'option'); ?></p>
    <p class="copyright">Copyright <?php echo date('Y'); ?> <?php echo $name; ?>. All Rights Reserved.</p>
    <!-- //주소및연락처 -->

  </div>

</footer>