<?php
// get field
$shortcut = get_field('theme_03_main_shortcut', 'option');
$sns = get_field('theme_03_main_sns', 'option');
$name = get_field('theme_03_main_name', 'option');
?>

<footer class="footer">

  <!-- 바로가기 -->
  <ul class="footer__shortcut">
    <?php
    if ($shortcut) {
      foreach ($shortcut as $row) {
        echo '<li><a class="link" href="' . $row['link'] . '">' . $row['title'] . '</a></li>';
      }
    }
    ?>
  </ul>
  <!-- //바로가기 -->

  <!-- 주소및연락처 -->
  <p class="footer__contact"><?php echo get_field('theme_01_main_contact', 'option'); ?></p>
  <!-- //주소및연락처 -->

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

  <!-- copyright -->
  <p class="footer__copyright">Copyright <?php echo date('Y'); ?> <?php echo $name; ?>. All Rights Reserved.</p>
  <!-- copyright -->

</footer>