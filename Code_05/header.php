<?php
/**
 * The Header for the theme.
 *
 * Displays all of the <head> section and logo, navigation, header widgets
 *
 * @package kale
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="naver-site-verification" content="d8aee7ddc0369288b24cf9f5545f3d2b106dafb7"/>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Kaldi">
    <meta name="title" content="지상파 1번가">
    <meta name="description" content="지상파 1번가는 대한민국 최초 지상파 불만처리 대행서비스입니다.">
    <meta name="keywords" content="방송, 언론, 방송국, 미디어, TV, 지상파, 1번가, 지상파 1번가, 드라마, 시사, 지상파 재허가, 불만처리 대행서비스">
    <!-- Open Graph -->
    <meta property="og:site_name" content="<?php echo bloginfo('name'); ?>">
    <meta property="og:url" content="<?php if (is_home()) { echo esc_url( home_url('/') ); } else { echo the_permalink(); } ?>">
    <meta property="og:title" content="<?php if (is_home()) { echo bloginfo('name'); } else { echo the_title(); } ?>">
    <meta property="og:type" content="<?php if (is_home()) { echo "website"; } else { echo "article"; } ?>">
    <meta property="og:description" content="<?php echo bloginfo('description'); ?>">
    <meta property="og:image" content="<?php if (is_home()) { } else { echo the_post_thumbnail_url(); } ?>">
    <meta name="twitter:card" content="summary_large_image">
    <!-- /Open Graph -->
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="main-wrapper">
    <div class="container">

        <!-- Header -->
        <div class="header">

            <!-- Header Row 2 -->
            <div class="header-row-2">
                <div class="logo">
                    <?php
                    if(kale_get_option('kale_image_logo_show') == 1) {
                        if ( function_exists( 'the_custom_logo' ) ) the_custom_logo();
                    }
                    else {
                        $kale_text_logo = kale_get_option('kale_text_logo');
                        if($kale_text_logo == '') $kale_text_logo = get_bloginfo('name');
                    ?>

                        <h1 class="header-logo-text"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="/wp/wp-content/themes/kale/assets/images/logo.jpg" alt="지상파 1번가 - 대한민국 최초 지상파 쇼핑몰"></a></h1>

                    <?php } ?>
                </div>
                <div class="facebook_go">
                    <a href="https://www.facebook.com/지상파1번가-356783381434320/" title="Facekbook 바로가기" target="_blank"><img src="/wp/wp-content/themes/kale/assets/images/facebook_go.png" alt="페이스북으로 이동"></a>
                </div>
            </div>
            <!-- /Header Row 2 -->

        </div>
        <!-- /Header -->

<?php if(is_front_page() && !is_paged() ) {
get_template_part('parts/frontpage', 'banner');
get_template_part('parts/frontpage', 'featured');
} ?>
