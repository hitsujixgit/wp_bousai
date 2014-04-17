<?php get_header(); ?>
<!-- メイン -->
<div id="content">
	<div id="main">
	<?php
	while(have_posts()) {
		the_post();
		get_template_part('content');
		get_template_part('pagination');
		}
	?>
	</div><!-- #main -->
<?php get_sidebar(); ?>
</div><!-- #content -->
<?php get_footer();