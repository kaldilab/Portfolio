<?php if ($comments) : ?>
  <div class="comments" id="comments">
    <?php $comments_number = absint(get_comments_number()); ?>
    <div class="comments-header">
      <h2 class="comment-reply-title">
        <?php
        if (!have_comments()) {
          _e('Leave a comment');
        } elseif ('1' === $comments_number) {
          printf(_x('One reply on &ldquo;%s&rdquo;', 'comments title'), esc_html(get_the_title()));
        } else {
          echo sprintf(
            _nx(
              '%1$s reply on &ldquo;%2$s&rdquo;',
              '%1$s replies on &ldquo;%2$s&rdquo;',
              $comments_number,
              'comments title',
            ),
            number_format_i18n($comments_number),
            esc_html(get_the_title())
          );
        }
        ?>
      </h2>
    </div>
    <ul class="comments-list">
      <?php
      wp_list_comments();
      $comment_pagination = paginate_comments_links();
      if ($comment_pagination) {
        $pagination_classes = '';
        if (false === strpos($comment_pagination, 'prev page-numbers')) {
          $pagination_classes = ' only-next';
        }
      ?>
        <nav class="comments-pagination pagination<?php echo $pagination_classes; ?>" aria-label="<?php esc_attr_e('Comments'); ?>">
          <?php echo wp_kses_post($comment_pagination); ?>
        </nav>
      <?php
      }
      ?>
    </ul>
  </div>
<?php endif; ?>

<?php
if (comments_open() || pings_open()) {
  if ($comments) {
    echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
  }
  comment_form(
    array(
      'class_form'         => 'comments-form',
      'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
      'title_reply_after'  => '</h2>',
    )
  );
} elseif (is_single()) {
  if ($comments) {
    echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
  }
?>
  <div class="comment-respond" id="respond">
    <p class="comments-closed"><?php _e('Comments are closed.'); ?></p>
  </div>
<?php
}
?>