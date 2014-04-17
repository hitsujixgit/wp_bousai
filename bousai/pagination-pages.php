<?php 
	// リンクが無い場合はNULLが返ってくる
	$prev_link = get_previous_posts_link('前のページ');
	$next_link = get_next_posts_link('次のページ');
	
	if(isset($prev_link) or isset($next_link)) {
		echo '<ul id="pagination" class="pages">', PHP_EOL;
		if(isset($prev_link)) {
			echo '<li class="prev">',$prev_link,'</li>', PHP_EOL;
		}
		if(isset($next_link)) {
			echo '<li class="next">',$next_link,'</li>', PHP_EOL;
		}
		echo '</ul>', PHP_EOL;
	}
?>