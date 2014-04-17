<?php get_header(); ?>
<!-- メイン -->
<div id="content">
	<div id="main">
		<article class="post">
		<?php
		if(have_posts()) {
			echo '<h2 class="post-title"><span>'.$_GET['s'].'」</span>の検索結果</h2>';
			while(have_posts()) {
				the_post();
				get_template_part('content','excerpt');
			}
			get_template_part('pagination','pages');
		} else {
			echo '<p>該当する記事がありません</p>';
		}
		?>
		</article>
	</div><!-- #main -->
<?php get_sidebar(); ?>
</div><!-- #content -->
<?php get_footer();