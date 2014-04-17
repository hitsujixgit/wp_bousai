<?php
//カスタムメニューを1つ設置する
register_nav_menu('mainmenu', 'メインメニュー');

// ウィジェットを設置する
register_sidebar(
	array(
			'before_widget' => '<section class="widget-wrapper">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
	)
);
// アイキャッチ画像を有効にする
add_theme_support('post-thumbnails');
set_post_thumbnail_size(240, 240, true);

//editor
add_editor_style();

// 概要表示をカスタマイズ
function my_excerpt_mblength($length) {
	return 100;
}
add_filter('excerpt_mblength', 'my_excerpt_mblength');

function my_excerpt_more($more) {
	return '・・・';
}
add_filter('excerpt_more', 'my_excerpt_more');

function my_more_link($excerpt) {
	return $excerpt . '<a class="readon" href="' . get_permalink($post->ID) . '">続きを読む</a>';
}
add_filter('wp_trim_excerpt', 'my_more_link');

// 固定ページに抜粋を追加する
function my_add_excerpt_to_page() {
	add_post_type_support('page', 'excerpt');
}

add_action('init', 'my_add_excerpt_to_page');

// authorページを非表示にする
add_filter( 'author_rewrite_rules', '__return_empty_array' );

// javascript
function myJavaScript_head() {
	
	wp_deregister_script('jquery');
	wp_register_script('jquery',get_bloginfo('template_url'). '/js/jquery-1.7.1.min.js');
	wp_enqueue_script('jquery');
	wp_enqueue_script('pageslide', get_bloginfo('template_url'). '/js/jquery.pageslide.min.js', array('jquery'), false, true);
	wp_enqueue_script('mypageslide', get_bloginfo('template_url'). '/js/myPageslide.js', array('jquery'), false ,true);
	
	// IE6-8の場合は、HTML5対応Javascriptを読み込む
	$agent = getenv('HTTP_USER_AGENT');
	if (mb_ereg("MSIE", $agent)) {
		if(mb_ereg("MSIE 6", $agent) or mb_ereg("MSIE 7", $agent) or mb_ereg("MSIE 8", $agent)) {
			wp_enqueue_script('html5shiv', get_bloginfo('template_url'). '/js/html5shiv.js',array('jquery'));
			wp_enqueue_script('css3-mediaqueries', get_bloginfo('template_url'). '/js/css3-mediaqueries.js',array('jquery'));
		}
	}
}
add_action('wp_head', 'myJavaScript_head', 1);

