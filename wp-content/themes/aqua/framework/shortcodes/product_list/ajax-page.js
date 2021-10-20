!(function($){
	$(function(){
		var $woocommerce = $('.woocommerce.tb-products-list.tpl2');
		$woocommerce.each(function(){
			var $this = $(this),
				$products = $this.find('.products'),
				$params = $products.data('params'),
				$pagination = $this.find('.pagination');
			
			// replace <span>
			var $spanInner = $pagination.find('span').html(),
				$a = $('<a>', { href: "?paged="+$spanInner, class: "page-numbers current", html: $spanInner });
			
			$pagination.find('span').remove();
			$pagination.prepend($a);
			
			$pagination.on('click', 'a', function(e){
				e.preventDefault();
				var $thisEL = $(this),
					url = $thisEL.attr('href'),
					arr_paged = [];
					
				if( url.indexOf('page') >= 0 ){
					arr_paged = $thisEL.attr('href').split('page');
				}
				if( url.indexOf('paged') >= 0 ){
					arr_paged = $thisEL.attr('href').split('paged');
				}
				
				var paged_num = arr_paged[1].replace(/[^0-9]/g, '');
				
				
				$('body, html').animate({
					scrollTop: $this.offset().top - 120,
				}, 'slow');
				
				$thisEL.addClass('current').siblings().removeClass('current');
				$products.addClass('ajax-loading');
				
				$.ajax({
					type: "POST",
					url: variable_js.ajax_url,
					data: { action: 'render_product_list', paged: paged_num, params: $params},
					success: function(data){
						var obj = JSON.parse(data);
						$products.removeClass('ajax-loading');
						
						$products.find('.tb-product-items').html(obj.products_content);
						$pagination.html(obj.nav_content);
						
						var $spanInner = $pagination.find('span').html(),
						$a = $('<a>', { href: "?paged="+$spanInner, class: "page-numbers current", html: $spanInner });
					}
				})
			})
		})
	})
})(jQuery)