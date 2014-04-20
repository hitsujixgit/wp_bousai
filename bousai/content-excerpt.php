<article class="post post-excerpt">
	<header class="post-header">
		<?php 
			$link = get_permalink($post->ID);
		?>
		<h3 class="post-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h3>
		<p class="post-meta">
			<time class="post-date" pubdate><?php echo get_the_date(); ?></time>
		</p>
	</header>
	
	<div class="post-content">
		<?php 
			if (has_post_thumbnail($post->ID)) {
				$img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(240, 240));
				$width = $img[1]/2;
				$height = $img[2]/2;
				$img_src = $img[0];
			} else {
				$width = 120;
				$height = 120;
				$img_src = get_template_directory_uri()."/img/no_image_2x.png";
			}
		?>
		<a href="<?php echo $link ?>"><img src="<?php echo $img_src ?>" width="<?php echo $width ?>" height="<?php echo $height ?>" /></a>
		<p><?php echo wp_trim_excerpt() ?></p>
	</div>
	<span class="terms"><?php 
		$myterms = array();
		$terms1 = get_the_term_list($post->ID, 'post_tag','',', ','');
		$terms2 = get_the_term_list($post->ID, 'category','',', ','');
		if($terms1) array_push($myterms, $terms1);
		if($terms2) array_push($myterms, $terms2);
		echo implode(', ', $myterms);
	?></span>
</article><!-- post -->