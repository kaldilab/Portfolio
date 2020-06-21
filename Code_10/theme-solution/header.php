<?php $theme = wp_get_theme()->stylesheet; ?>

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
  <?php get_template_part('templates/content', 'seo'); ?>
</head>

<body id="<?php echo $theme; ?>" <?php body_class(); ?>>

  <?php
  if (is_home()) {
    get_template_part('templates/content', 'popup');
  }
  ?>

  <a class="accesibility sr-only sr-only-focusable" href="#content"><?php echo '본문 바로가기'; ?></a>

  <?php
  if (is_home()) {
    get_template_part('templates/content', 'topbanner');
  }
  ?>

  <div class="container-fluid">

    <?php
    if ($theme == 'theme-origin') {
      get_template_part('templates/' . get_field('dev_theme', 'option') . '/content', 'header');
    } else {
      get_template_part('templates/' . $theme . '/content', 'header');
    }
    ?>

    <main id="content" class="<?php echo (is_home()) ? 'main' : 'sub'; ?>">