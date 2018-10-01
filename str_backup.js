var speed = 16000;
var tout = 5000;
var current = 0;
var timeoutid = -1;

var ilength = new Array();
var icount;
var ix = new Array();

jQuery(document).ready(function(){
function inStr() {
	icount = jQuery('.lineone').length;
	var tx;
	jQuery('.lineone').each(function() {
		tx = (jQuery(window).width() - jQuery(this).width()) / 2;
		ilength.push(jQuery(this).width());
		if (tx <= 0) {
			ix.push(10);
		} else {
			ix.push(tx);
		}
	});
	jQuery('.lineone').css('left', jQuery(window).width());
	jQuery('.lineone').css('opacity', '1');
}
function rStr(ii) {
	jQuery('.swbuttons li').removeClass('active');
	jQuery('.swbuttons li').eq(ii).addClass('active');
	jQuery('.lineone').eq(ii).animate({left: ix[ii]}, speed, 'linear', function() {
		timeoutid = setTimeout(function() {
			var backk;
			if (ilength[ii] < jQuery(window).width()) {
				backk = speed;
			} else {
				backk = Math.round(speed * ilength[ii] / jQuery(window).width());
			}
			jQuery('.lineone').eq(ii).animate({left: -1 * ilength[ii]}, backk, 'linear', function() {
				jQuery('.lineone').eq(ii).css('left', jQuery(window).width());
				current++;
				if (current >= icount) {
					current = 0;
				}
				rStr(current);
			});
		}, tout);
	});
}
if (jQuery('.lineone').length) {
	jQuery('.lineone').each(function() {
		jQuery('.swbuttons').append('<li></li>');		
	});
	jQuery('.swbuttons li').eq(0).addClass('active');
	inStr();
	rStr(current);
	jQuery('.swbuttons li').click(function() {
		jQuery('.lineone').stop(true, true);
		if (timeoutid != -1) {
			clearTimeout(timeoutid);
		}
		inStr();
		rStr(jQuery('.swbuttons li').index(jQuery(this)));
		return false;
	});
}

});