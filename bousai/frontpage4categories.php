<?php 
/*
 Template Name: Front page with 4 categories
*/
get_header(); ?>
<!-- メイン -->
<div id="content">
	<img id="frontpage-image" src="<?php echo get_template_directory_uri() ?>/img/sky_2x.jpg" width="900" height="200" />
	<div id="main">
	<?php
		// boxの中身を出力する（記事タイトル、抜粋、サムネ）無名関数を定義する
		$the_box_content = function ($cat, $img_id = false) {
			if ($cat->cat_name == '' ) return;
			$link = get_category_link($cat->term_id);
			
			echo '<div class="box-wrapper"><section class="box">', PHP_EOL;
			echo '<a class="box-link" href="'.$link.'">'.$cat->cat_name.'</a>';
			echo '<h3 class="box-title">'.$cat->cat_name.'</h3>';
			if (!empty($img_id)) {
				$img = wp_get_attachment_image_src($img_id, array(240, 240));
				$width = $img[1]/2;
				$height = $img[2]/2;
				echo '<a href="'.$link.'"><img src="'.$img[0].'" width="'.$width.'" hight="'.$height.'" /></a>', PHP_EOL;
			} else {
				echo '<a href="'.$link.'"><img src="'.get_template_directory_uri().'/img/no_image_2x.png" width="120" height="120"/></a>', PHP_EOL;
			}
			echo '<p>'. $cat->category_description.'<br />', PHP_EOL;
			echo '<span class="read-more-link"><a href="'.$link.'">&gt;&gt;続きを読む</a></span></p>', PHP_EOL;
			echo '</section></div>', PHP_EOL;
		};
	?>
	<?php 
		// トップページに指定した記事の内容と、カスタムフィールドで指定した３つの記事を表示する
		if ( have_posts() ): $top_post = get_post();
	?>
		<article class="post">
			<header class="post-header">
				<h2 class="post-title"><?php echo $top_post->post_title; ?></h2>
			</header>
			<div class="post-content">
				<?php echo $top_post->post_content; ?>
			</div>
			<section class="boxes-container">
				<?php 
					$box_cat = get_category_by_slug(get_post_meta($top_post->ID, "cat1_name", true));
					$box_img = get_post_meta($top_post->ID, "cat1_image", true);
					if ( isset($box_cat) ) $the_box_content($box_cat, $box_img);
					$box_cat = get_category_by_slug(get_post_meta($top_post->ID, "cat2_name", true));
					$box_img = get_post_meta($top_post->ID, "cat2_image", true);
					if ( isset($box_cat) ) $the_box_content($box_cat, $box_img);
					$box_cat = get_category_by_slug(get_post_meta($top_post->ID, "cat3_name", true));
					$box_img = get_post_meta($top_post->ID, "cat3_image", true);
					if ( isset($box_cat) ) $the_box_content($box_cat, $box_img);
					$box_cat = get_category_by_slug(get_post_meta($top_post->ID, "cat4_name", true));
					$box_img = get_post_meta($top_post->ID, "cat4_image", true);
					if ( isset($box_cat) ) $the_box_content($box_cat, $box_img);
				?>
			</section>
		</article><!-- post -->
	<?php endif; ?>
	</div><!-- #main -->
<?php get_sidebar(); ?>
</div><!-- #content -->
<?php get_footer();