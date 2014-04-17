<?php get_header(); ?>
<!-- メイン -->
<div id="content">
	<div id="main">
		<article class="post">
		<?php 
		if(is_category()) {
			$obj = get_queried_object();
			$title = '<span>「'.get_cat_name($obj->term_id).'」</span>の記事';
		} elseif (is_tag()) {
			$obj = get_queried_object();
			$title = '<span>「'.single_tag_title($obj->term_id,false).'」</span>の記事';
		} else {
			$title = 'アーカイブ記事一覧';
		}
		if(have_posts()) {
			echo '<h2 class="post-title">'.$title.'</h2>';
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