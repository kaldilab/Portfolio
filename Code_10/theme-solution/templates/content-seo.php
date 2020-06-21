<!-- SEO 기본 -->
<?php $seo_base = get_field('seo_base', 'option'); ?>
<meta name="Title" content="<?php echo ($seo_base['title']) ? $seo_base['title'] : get_bloginfo('name'); ?>">
<?php if (is_single()) : ?>
  <meta name="Description" content="<?php echo get_the_excerpt(); ?>">
<?php else : ?>
  <meta name="Description" content="<?php echo ($seo_base['description']) ? $seo_base['description'] : get_bloginfo('description'); ?>">
<?php endif; ?>
<meta name="Subject" content="<?php echo ($seo_base['subject']) ? $seo_base['subject'] : get_bloginfo('description'); ?>">
<meta name="Author" content="<?php echo ($seo_base['author']) ? $seo_base['author'] : get_bloginfo('name'); ?>">
<meta name="Keywords" content="<?php echo ($seo_base['keywords']) ? $seo_base['keywords'] : get_bloginfo('name'); ?>">
<meta name="Reply-To(Email)" content="<?php echo ($seo_base['replyto']) ? $seo_base['replyto'] : get_bloginfo('admin_email'); ?>">
<meta name="Copyright" content="<?php echo ($seo_base['copyright']) ? $seo_base['copyright'] : 'Copyright ' . date('Y') . ' ' . get_bloginfo('name') . ' Co. Ltd. All rights reserved.'; ?>">
<meta name="Publisher" content="<?php echo ($seo_base['publisher']) ? $seo_base['publisher'] : 'dev'; ?>">
<meta name="Distribution" content="<?php echo ($seo_base['distribution']) ? $seo_base['distribution'] : 'dev'; ?>">
<meta name="Robots" content="<?php echo ($seo_base['robots']) ? $seo_base['robots'] : 'noindex,nofollow'; ?>">
<!-- SEO 기본 -->
<!-- SEO Open Graph -->
<?php $seo_og = get_field('seo_og', 'option'); ?>
<meta property="og:image" content="<?php echo (is_single() && get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $seo_og['image']; ?>">
<meta property="og:locale" content="ko_KR">
<meta property="og:type" content="<?php echo (is_single()) ? 'article' : 'website'; ?>">
<meta property="og:title" content="<?php bloginfo('name'); ?> | <?php ((is_home()) ? bloginfo('description') : the_title()); ?>">
<meta property="og:url" content="<?php echo (is_home()) ? project_homeurl('/') : project_permalink(); ?>">
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<?php if (is_single()) : ?>
  <meta property="og:description" content="<?php echo get_the_excerpt(); ?>">
<?php endif; ?>
<meta name="twitter:image" content="<?php echo (is_single() && get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $seo_og['image']; ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php bloginfo('name'); ?> | <?php ((is_home()) ? bloginfo('description') : the_title()); ?>">
<?php if (is_single()) : ?>
  <meta name="twitter:description" content="<?php echo get_the_excerpt(); ?>">
<?php endif; ?>
<link rel="canonical" href="<?php echo (is_home()) ? project_homeurl('/') : project_permalink(); ?>">
<!-- //SEO Open Graph -->
<!-- Analytics Code -->
<?php
$seo_code = get_field('seo_code', 'option');
if ($seo_code['google']) {
  echo '<meta name="google-site-verification" content="' . $seo_code['google'] . '" />';
}
if ($seo_code['naver']) {
  echo '<meta name="naver-site-verification" content="' . $seo_code['naver'] . '" />';
}
?>
<!-- //Analytics Code -->
<!-- Analytics Script -->
<?php
$seo_script = get_field('seo_script', 'option');
echo ($seo_script) ? $seo_script : false;
?>
<!-- Analytics Script -->