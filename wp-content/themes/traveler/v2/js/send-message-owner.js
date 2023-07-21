(function ($) {
	$(document).on("ready", function () {
	$('.single .st_ask_question #btn-send-message-owner').on('click',function(e){
		e.preventDefault();
		jQuery(".btn-send-message").trigger('click');
		});
	})
})(jQuery);
