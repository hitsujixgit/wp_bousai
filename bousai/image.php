<?php get_header(); ?>
<!-- メイン -->
<div id="content">
	<div id="main">
	<?php
	while(have_posts()):
		the_post();
		global $post;
		$image_attributes = wp_get_attachment_image_src( $post->ID, "large_for_2x" ); // returns an array
		?>
		<article class="post">
			<header class="post-header">
				<h2 class="post-title"><?php the_title(); ?></h2>
				<p class="post-meta">
					<time class="post-date" pubdate><?php echo get_the_date(); ?></time>
				</p>
			</header>
			<div class="post-content">
			<?php if( $image_attributes ) : ?>
				<?php if( has_term('retina','media_category',$post->ID) ): ?>
				<img src="<?php echo $image_attributes[0]; ?>" width="<?php echo floor($image_attributes[1]/2); ?>" height="<?php echo floor($image_attributes[2]/2); ?>">
				<?php else: ?>
				<img src="<?php echo $image_attributes[0]; ?>" width="<?php echo floor($image_attributes[1]); ?>" height="<?php echo floor($image_attributes[2]); ?>">
		<?php endif;endif;endwhile; ?>
			</div>
		</article>
	</div><!-- #main -->
<?php get_sidebar(); ?>
</div><!-- #content -->
<?php get_footer();