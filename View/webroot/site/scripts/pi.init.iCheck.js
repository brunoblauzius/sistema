/* Aura version: 1.8.5 */

jQuery(function($){

	//region iCheck
	if($.fn.iCheck){
		$('input.pi-stylish-checkbox, input.pi-stylish-radio').iCheck({
			checkboxClass: 'icheckbox_square',
			radioClass: 'iradio_square',
			focusClass: 'focus',
			increaseArea: '20%' // optional
		});
	}
	//endregion

});