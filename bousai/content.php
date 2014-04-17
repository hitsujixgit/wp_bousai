<article class="post">
	<header class="post-header">
		<h2 class="post-title"><?php the_title(); ?></h2>
		<p class="post-meta">
			<time class="post-date" pubdate><?php echo get_the_date(); ?></time>
		</p>
	</header>
	<div class="post-content">
		<?php the_content(); ?>
	</div>
</article><!-- post -->