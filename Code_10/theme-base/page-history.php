<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<ul class="list-group">
	<?php
	if (have_rows('history', 'option')) {
		while (have_rows('history', 'option')) {
			the_row();
			echo '<li class="list-group-item">';
			echo '<p>' . the_sub_field('year') . '</p>';
			echo '<dl>';
			if (have_rows('content')) {
				while (have_rows('content')) {
					the_row();
					echo '<dt>' . get_sub_field('date') . '</dt>';
					echo '<dd>' . get_sub_field('text') . '</dd>';
				}
			}
			echo '</dl>';
			echo '</li>';
		}
	}
	?>
</ul>

<?php get_footer(); ?>