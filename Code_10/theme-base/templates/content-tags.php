<!-- 태그 -->
<?php $tags = wp_get_post_tags($post->ID); ?>
<ul class="list-group list-group-horizontal mt-3 mb-3">
  <?php if ($tags) : ?>
    <?php
    foreach ($tags as $tag) {
      $tag_link = get_tag_link($tag->term_id);
      echo '<li class="list-group-item"><a href="' . $tag_link . '" title="' . $tag->name . '">' . $tag->name . '</a></li>';
    }
    ?>
  <?php endif; ?>
</ul>
<!-- //태그 -->