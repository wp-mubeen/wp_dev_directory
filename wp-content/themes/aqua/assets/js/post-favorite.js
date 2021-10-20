(function($) { "use strict";
jQuery(document).ready(function($){
	$('body').on('click','.nectar-love', function() {
			var $loveLink = $(this);
			var $icon = $(this).find('i');
			var $id = $(this).attr('id');
			var $that = $(this);

			if($loveLink.hasClass('loved')) return false;
			if($(this).hasClass('inactive')) return false;

			var $dataToPass = {
				action: 'nectar-love',
				loves_id: $id
			}

			$.post(nectarLove.ajaxurl,$dataToPass, function(data){
				$loveLink.find('span').html(data);
				$loveLink.addClass('loved').attr('title','You already love this!');
				$icon.removeClass('icon-basic-heart').addClass('icon-heart');
				$loveLink.find('span').css({'opacity': 1,'width':'auto'});
			});

			$(this).addClass('inactive');

			return false;
	});
});
})(jQuery);
