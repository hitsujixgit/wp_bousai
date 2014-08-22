<?php
//カスタムメニューを1つ設置する
register_nav_menu('mainmenu', 'メインメニュー');

// カスタムヘッダーを有効にする
$custom_header_defaults = array(
		'default-image'          => get_bloginfo('template_url').'/img/sky_2x.jpg',
		'width'                  => 1800,
		'height'                 => 400,
		'header-text'            => false,	//ヘッダー画像上にテキストをかぶせる
);
add_theme_support( 'custom-header', $custom_header_defaults );

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

// 倍解像度画像サイズを追加する
add_image_size('thumbnail_for_2x', 300, 300);
add_image_size('medium_for_2x', 600, 600);
add_image_size('large_for_2x', 1200, 1200);

// メディアライブラリに倍解像度画像サイズを登録する
add_filter( 'image_size_names_choose', 'my_custom_image_sizes' );
if( !function_exists('my_custom_image_sizes') ) {
	function my_custom_image_sizes( $sizes ) {
		return array_merge( $sizes, array(
				'thumbnail_for_2x' => __('高解像度画像 サムネイル'),
				'medium_for_2x' => __('高解像度画像 中サイズ'),
				'large_for_2x' => __('高解像度画像 大サイズ'),
				'full_for_2x' => __('高解像度画像 フルサイズ'),
		) );
	}
}

// Fullサイズと等しい場合は、画像サイズ選択メニューに高解像度用画像サイズを追加する
// きちんと作る場合は、widthやheightなどのkey存在確認したほうがいいです。
add_filter( 'wp_prepare_attachment_for_js', 'add_imagesize_for_js_preparation');
if( !function_exists('add_imagesize_for_js_preparation') ) {
	function add_imagesize_for_js_preparation($response) {
		
		foreach ($response['sizes'] as $size => $values) {
			if( in_array($size, array('thumbnail_for_2x','medium_for_2x','large_for_2x')) ) {
				$response['sizes'][$size]['width'] = floor($response['sizes'][$size]['width'] / 2);
				$response['sizes'][$size]['height'] = floor($response['sizes'][$size]['height'] / 2);
			}
		}
		
		$full_max = max($response['sizes']['full']['width'], $response['sizes']['full']['height']);
		$key = '';
		switch ($full_max) {
			case 300:
				$key = 'thumbnail_for_2x';
				break;
			case 600:
				$key = 'medium_for_2x';
				break;
			case 1200:
				$key = 'large_for_2x';
				break;
			default:
				$key = 'full_for_2x';
		}
		$response['sizes'] = array_merge($response['sizes'], array($key => array(
				'width' =>  floor($response['sizes']['full']['width'] / 2),
				'height' => floor($response['sizes']['full']['height'] / 2),
				'url' => $response['sizes']['full']['url'],
				'orientation' => $response['sizes']['full']['orientation'],
		)));
		return $response;
	}
}

// 倍解像度画像が投稿に挿入された場合に、imgタグのwidth/height属性値を半分にする
add_filter('get_image_tag', 'change_imagesize_tohalf', 1, 6);
if( !function_exists('change_imagesize_tohalf') ) {
	
	function change_imagesize_tohalf($html, $id, $alt, $title, $align, $size) {
		
		// 高解像度用サイズが選択された場合のみ、widthとheightの値を半分にする
		if (in_array($size, array('thumbnail_for_2x','medium_for_2x','large_for_2x','full_for_2x'))) {
			// function image_hwstring (media.php)の仕様に合わせて正規表現でwidthとheightの値をマッチさせる
			if(preg_match('/^(?<before>.*width=["\'])(?<value>[\d]+)(?<after>["\'].*)$/', $html, $m)) {
				$val = floor($m['value'] / 2);
				$html = $m['before'].$val.$m['after'];
			}
			if(preg_match('/^(?<before>.*height=["\'])(?<value>[\d]+)(?<after>["\'].*)$/', $html, $m)) {
				$val = floor($m['value'] / 2);
				$html = $m['before'].$val.$m['after'];
			}
		}
		return $html;
	}
}

// メディア用のカテゴリを作成する
add_action('init', 'create_attachment_category');
if( !function_exists('create_attachment_category') ) {
	function create_attachment_category() {
		// カテゴリを作成
		$labels = array(
				'name'                => 'メディアカテゴリー',		//複数系のときのカテゴリ名
				'singular_name'       => 'メディアカテゴリー',		//単数系のときのカテゴリ名
				'search_items'        => 'メディアカテゴリーを検索',
				'all_items'           => '全てのメディアカテゴリー',
				'parent_item'         => '親カテゴリー',
				'parent_item_colon'   => '親カテゴリー:',
				'edit_item'           => 'メディアカテゴリーを編集',
				'update_item'         => 'メディアカテゴリーを更新',
				'add_new_item'        => '新規メディアカテゴリーを追加',
				'new_item_name'       => '新規メディアカテゴリー',
				'menu_name'           => 'メディアカテゴリー'		//ダッシュボードの左サイドバーメニュー名
		);
		$args = array(
				'hierarchical'        => true,
				'labels'              => $labels,
				'rewrite'             => array( 'slug' => 'media_category' )
		);
		register_taxonomy( 'media_category', 'attachment', $args );
	}
}

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
	global $post;
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
add_action('wp_head', 'myJavaScript_head', 1);
if( !function_exists('myJavaScript_head') ) {
	function myJavaScript_head() {
		
		wp_deregister_script('jquery');
		wp_register_script('jquery',get_bloginfo('template_url'). '/js/jquery-1.7.1.min.js');
		wp_enqueue_script('jquery');
		wp_enqueue_script('pageslide', get_bloginfo('template_url'). '/js/jquery.pageslide.min.js', array('jquery'), false, true);
		wp_enqueue_script('mypageslide', get_bloginfo('template_url'). '/js/myPageslide.js', array('jquery'), false ,true);
		wp_enqueue_script('bxslider', get_bloginfo('template_url'). '/js/jquery.bxslider.min.js', array('jquery'));
		wp_enqueue_script('mybxslider', get_bloginfo('template_url'). '/js/mybxslider.js', array('jquery'), false ,true);
		
		// IE6-8の場合は、HTML5対応Javascriptを読み込む
		$agent = getenv('HTTP_USER_AGENT');
		if (mb_ereg("MSIE", $agent)) {
			if(mb_ereg("MSIE 6", $agent) or mb_ereg("MSIE 7", $agent) or mb_ereg("MSIE 8", $agent)) {
				wp_enqueue_script('html5shiv', get_bloginfo('template_url'). '/js/html5shiv.js',array('jquery'));
				wp_enqueue_script('css3-mediaqueries', get_bloginfo('template_url'). '/js/css3-mediaqueries.js',array('jquery'));
			}
		}
	}
}
