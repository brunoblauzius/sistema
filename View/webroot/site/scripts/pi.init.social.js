/* Aura version: 1.8.5 */

jQuery(function($){

	//region Socials jumps
	$('.pi-jump a, .pi-jump-bg a').each(function () {
		var $el = $(this);
		if($el.find('i').length <= 1){
			$el.append($el.find('i').clone());
		}
	});

	$('.pi-social-icons-big a i').wrap('<span></span>');
	//endregion

});