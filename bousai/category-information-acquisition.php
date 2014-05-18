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
			// 固定ページ "category-information-acquisition" の本文を挿入する
			$cat_discription_page = get_page_by_path('category-information-acquisition');
			if(isset($cat_discription_page)) {
				echo '<div class="post-content">'.apply_filters('the_content', $cat_discription_page->post_content).'</div><hr />';
			}
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