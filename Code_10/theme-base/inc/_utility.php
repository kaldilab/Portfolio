<?php
// project print
function pp($post)
{
  echo '<pre>[PRINT] : ' . print_r($post, true) . '</pre>';
}

// images url
function project_image_uri($image)
{
  return get_template_directory_uri() . '/images/' . $image;
}

// download url
function project_download_uri($file)
{
  return get_template_directory_uri() . '/download/' . $file;
}

// permalink
function project_permalink()
{
  return esc_url(get_permalink());
}

// home url
function project_homeurl($url)
{
  return esc_url(home_url($url));
}

// featured image
function project_featured_image($default)
{
  $featured_image = get_the_post_thumbnail_url();
  if ($featured_image) {
    return '<img class="img-fluid" src="' . $featured_image . '" alt="' . get_the_title() . '">';
  } else {
    return '<img class="img-fluid" src="' . project_image_uri($default) . '" alt="' . get_the_title() . '">';
  }
}

// excerpt more
function project_excerpt_more($more)
{
  return '⋯';
}
add_filter('excerpt_more', 'project_excerpt_more');

// excerpt length
function project_excerpt_length($length)
{
  return 30;
}
add_filter('excerpt_length', 'project_excerpt_length');
