<?php get_header(); ?>

<div class="sub__top">
	<h2 class="sub__title"><?php the_title(); ?></h2>
	<?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>

<?php
// get field
$history = get_field('history', 'option');
$history_reverse = array_reverse($history);
?>

<section class="section history">

	<h3 class="sr-only">리스트</h3>

	<!-- 리스트 -->
	<ul class="history__head">
		<li class="year">연도</li>
		<li class="cont">
			<dl>
				<dt>일자</dt>
				<dd>활동</dd>
			</dl>
		</li>
	</ul>
	<?php
	if ($history_reverse) {
		foreach ($history_reverse as $row) {
			$history_content = $row['content'];
			echo '<ul class="history__list">';
			echo '<li class="history__item year">' . $row['year'] . '</li>';
			echo '<li class="history__item cont">';
			echo '<dl>';
			if ($history_content) {
				foreach ($history_content as $row) {
					echo '<dt>' . $row['date'] . '</dt>';
					echo '<dd>' . $row['text'] . '</dd>';
				}
			}
			echo '</dl>';
			echo '</li>';
			echo '</ul>';
		}
	}
	?>
	<!-- //리스트 -->

</section>

<?php get_footer(); ?>