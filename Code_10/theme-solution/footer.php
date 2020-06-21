<?php $theme = wp_get_theme()->stylesheet; ?>

</main>

<?php
if ($theme == 'theme-origin') {
  get_template_part('templates/' . get_field('dev_theme', 'option') . '/content', 'footer');
} else {
  get_template_part('templates/' . $theme . '/content', 'footer');
}
?>

</div>

<?php echo project_updated_message(); ?>

<?php wp_footer(); ?>

</body>

</html>