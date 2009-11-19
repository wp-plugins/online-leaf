$(document).ready(function() {
	$(".fade").fadeTo(500, 0.6);

	$(".fade").hover(function() {
		$(this).stop().fadeTo(150, 1.0);
	}, function() {
   		$(this).stop().fadeTo(1000, 0.6);
	});
});