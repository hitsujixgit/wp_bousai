/**
 * call bxSlider
 */
$(function($) {
	var mySlider = $('.bxslider').bxSlider({
		auto: true,
		speed: 1000,
		pause: 500,
		mode: 'fade',
		captions: false,
	});
	//windowサイズが変わったらmain()実行
	$( window ).resize(function(){
		mySlider.reloadSlider();
	});
});
