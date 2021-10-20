/* BTN EFFECT RIPPLE PLUGIN */
(function($) {
	"use strict";
	!(function($){
		function tbripple(elem, opts){
			this.thisEl = $(elem),
			this.opts = $.extend({
				version: "1.0.0"
			}, opts);

			this.init();
		}

		tbripple.prototype = {
			init: function(){
				if(this.thisEl.is('[disable]') == true){ return; }
				var tbripple = this;

				var ripple = $('<span>').addClass('ripple').css({width: 100, height: 100});
				this.thisEl.append(ripple);

				this.thisEl.bind('click', function(e){
					var p = tbripple.thisEl.offset();
					var position = { x: p.left, y: p.top }
					var mPosition = { x: e.pageX - 50, y: e.pageY - 50 }

					ripple.removeClass('animate');
					setTimeout(function(){
						ripple.css({
							left: mPosition.x - position.x,
							top: mPosition.y - position.y,
						}).addClass('animate');
					}, 20)
					
				})
			}
		}

		$.fn.tbripple = function(opts){
			return $(this).each(function(){
				new tbripple(this, opts);
			})
		}
	})(jQuery)

	/* CAROUSEL PARAMOVE PLUGIN */
	!(function($){
		function paramove(elem, $otps){
			this.element = $(elem);
			this.otps = $.extend({
				version: '1.0.0',
				selector: ''
			}, $otps)
			this.animate();
		}
		paramove.prototype = {
			animate: function(){
				var paramove = this,
					thisEl = this.element,
					elemP = thisEl.offset(),
					elemC = {},
					mouse = {};
				thisEl.css({ translate: '0s' });
				
				this.element.on({
					mousemove: function(event){
						m = { x: (event.pageX - elemP.left), y: (event.pageY - elemP.top) };
						elemC = { w: (thisEl.width() / 2), h: (thisEl.height() / 2) };
						x = (m.x > elemC.w)? ((m.x - elemC.w) * -1) : (elemC.w - m.x);
						y = (m.y > elemC.h)? ((m.y - elemC.h) * -1) : (elemC.h - m.y);
						console.log(event.clientX - elemP.left);
						if(paramove.otps.selector){
							thisEl.find(paramove.otps.selector).css({
								transform: 'translate3d({0}px, {1}px, 0)'.format(x / 50, y / 50)
							});
						}else{
							thisEl.children().css({
								transform: 'translate3d({0}px, {1}px, 0)'.format(x / 50, y / 50)
							});
						}
					},
					mouseout: function(){
						if(paramove.otps.selector){
							thisEl.find(paramove.otps.selector).css({
								transform: 'translate3d({0}px, {1}px, 0)'.format(0, 0)
							});
						}else{
							thisEl.children().css({
								transform: 'translate3d({0}px, {1}px, 0)'.format(0, 0)
							});
						}
					}
				})
			}
		}
		$.fn.paramove = function($otps){
			return this.each(function(){
				new paramove(this, $otps);
			})
		}
		String.prototype.format = function () {
			var args = arguments;
			return this.replace(/\{\{|\}\}|\{(\d+)\}/g, function (m, n) {
				if (m == "{{") { return "{"; }
				if (m == "}}") { return "}"; }
				return args[n];
			});
		};
	})(jQuery)

	/* IMG BLUR PLUGIN */
	!(function($){
		function tbblur(elem, opts){
			this.thisEL = $(elem);
			this.opts = $.extend({
				version: '1.0.0'
			}, opts);
			
			this.init();
		}
		
		tbblur.prototype = {
			init: function(){
				var tbblur = this,
					canvas = document.createElement('canvas'),
					ctx = canvas.getContext("2d"),
					e = 2;
					
				
				tbblur.params_img = { w: 0, h: 0 };
				tbblur.img = tbblur.thisEL.find('img');
				
				$(window).resize(function(){
					tbblur.params_img.w = parseInt(tbblur.img.css('width'));
					tbblur.params_img.h = parseInt(tbblur.img.css('height'));
					
					canvas.width = tbblur.params_img.w;
					canvas.height = tbblur.params_img.h;
					
					ctx.drawImage(tbblur.img.get(0), 0, 0, tbblur.params_img.w, tbblur.params_img.h);
					ctx.globalAlpha = 0.5;
					for(var t = -e; t <= e; t += 3) {
						for(var n = -e; n <= e; n += 3) {
							ctx.drawImage(canvas, n, t, tbblur.params_img.w, tbblur.params_img.h);
							var blob = n >= 0 && t >= 0 && ctx.drawImage(canvas, -(n-1), -(t-1), tbblur.params_img.w, tbblur.params_img.h);
						}
					}
				}).trigger('resize');
				
				tbblur.thisEL.append(canvas);
			}
		}
		
		$.fn.tbblur = function(opts){
			return $(this).each(function(){
				new tbblur(this, opts);
			})
		}
	})(jQuery)
	jQuery(document).ready(function($) {
		function ROtesttimonialSlider($elem) {
			if ($elem.length) {
				$elem.flexslider({
					controlNav: true,
					directionNav: true
				});
			}
		}
		ROtesttimonialSlider($('#ro-testimonial-slider'));
		
		function ROtesttimonialSlider2() {
			$('#ro-testimonial-1').flexslider({
				animation: "slide",
				animationLoop: true,
				controlNav: true,
				slideshow: true,
				directionNav: false
			});
		}
		ROtesttimonialSlider2();

		function ROtesttimonialSlider3() {
			$('#ro-testimonial-2').flexslider({
				animation: "slide",
				controlNav: false,
				directionNav: true
			});
		}
		ROtesttimonialSlider3();
		function ROimgSlider() {
			$('#ro-images-slider').flexslider({
				animation: "slide",
				animationLoop: false,
				itemWidth: 200,
				controlNav: false,
				directionNav: true,
				minItems: 2,
				move: 1,
				maxItems: 8
			});
		}
		ROimgSlider();
		function ROzoomImage() {
			var $window = $(window);
			$("#Ro_zoom_image > img").elevateZoom({
				zoomType: "lens",
				responsive: true,
				containLensZoom: true,
				cursor: 'pointer',
				gallery:'Ro_gallery_0',
				borderSize: 3,
				borderColour: "#84C340",
				galleryActiveClass: "ro-active",
				loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
			});

			$("#Ro_zoom_image > img").on("click", function(e) {
				var ez =   $('#Ro_zoom_image > img').data('elevateZoom');
					$.fancybox(ez.getGalleryList());
				return false;
			});
		}
		ROzoomImage();
		function ROheadervideo() {
			$("#ro-play-button").on("click", function(e){
				e.preventDefault();
					$.fancybox({
					'padding' : 0,
					'autoScale': false,
					'transitionIn': 'none',
					'transitionOut': 'none',
					'title': this.title,
					'width': 720,
					'height': 405,
					'href': this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
					'type': 'swf',
					'swf': {
					'wmode': 'transparent',
					'allowfullscreen': 'true'
					}
				});
			});
		}
		ROheadervideo();
		function ROEasingMoving() {
			var $root = $('html, body');
			$('#nav > li > a, .ro-follow-button').on('click', function() {
				var href = $.attr(this, 'href');
				if(href.substring(0,1)=='#'){
					$root.animate({
						scrollTop: ($(href).offset().top)
					}, 500, function() {
						window.location.hash = href;
					});
					return false;
				}
			});
		}
		ROEasingMoving();
		//Date picker
		function RODatePicker() {
			if ($('#rtb-date_custom').length) {
				$('#rtb-date_custom').datepicker();
			}
		}
		RODatePicker();
		
		$(".blog-desc").each(function() {
			$(this).dotdotdot();
		});
		$(window).on('resize', function() {
			$(".blog-desc").each(function() {
				$(this).dotdotdot();
			});
		});
		// Back to top btn
		var tb_back_to_top = jQuery('#tb_back_to_top');
		var window_height = jQuery(window).height();
		jQuery(window).scroll(function () {
			/* back to top */
			var scroll_top = $(window).scrollTop();
			if (scroll_top < window_height) {
				tb_back_to_top.addClass('no-active').removeClass('active');
			} else {
				tb_back_to_top.removeClass('no-active').addClass('active');
			}
		});
		tb_back_to_top.click(function () {
			jQuery("html, body").animate({
				scrollTop: 0
			}, 1500);
		});
		// switch currency
		$(document).on("click",".dd-select",function(){
			console.log('ok');
			$('.dd-pointer').each(function(){
				if($(this).hasClass('dd-pointer-up')){
					$(this).closest('.dd-select').addClass('active');
				}else{					
					$(this).closest('.dd-select').removeClass('active');
				}
			})
		})
		// Hook cart success
		jQuery('.add_to_cart_button').click(function(e){
			var $_this = jQuery(this);
			var $_cart = jQuery('.widget_mini_cart_wrap');
			$_cart.removeClass('animate_cart');
			var cart = jQuery('.tb_right_fx_wrap .widget_shopping_cart');
			jQuery(document).ajaxSuccess(function(e, xhr, settings) {
				//console.log(settings.data);
				if(!$('.widget_mini_cart_wrap').is(":visible")){
					$('.widget_mini_cart_wrap').show();
				}
				if(typeof(settings.data)!='undefined'){
					if(settings.data.indexOf('woocommerce_add_to_cart') > -1){
						console.log('yay!');
						$_cart.addClass('animate_cart');				
					}
				}
				
				$('.widget_mini_cart_wrap').removeClass('tb-cart-empty');
			});
		})
		/* Btn menu click */
		jQuery('#ro-hamburger').click(function(){
			jQuery('body').toggleClass('ro-main-nav-opened');
		})
		jQuery('.tb_right_fx_wrap .wg-title').click(function(e){
			 e.stopPropagation();
			jQuery(this).toggleClass( "active" );
			jQuery('.tb_right_fx_wrap .widget_shopping_cart_content').toggleClass( "active" );
		})	
		$('body').click(function (e) {
			var target = $(e.target);
			if (target.parents('.tb_right_fx_wrap').length == 0 && !target.hasClass('tb_right_fx_wrap')) {
				$('.tb_right_fx_wrap .wg-title,.tb_right_fx_wrap .widget_shopping_cart_content').removeClass('active');
			}
		});
		// Same Height
		jQuery('.row').each(function() {
			if (jQuery(this).hasClass('same-height')) {
				var height = jQuery(this).children().height();
				jQuery(this).children().each(function() {
					jQuery(this).css('min-height', height);
				});
			}
		});
		// Color box
		jQuery(".view-image").colorbox({rel:'colorbox', maxWidth:'90%', maxHeight:'90%' });
		// Mixitup
		if ($.fn.mixItUp) { $('#Container').mixItUp(); }
		// Ripple
		jQuery('.tbripple').tbripple();
		
		if (jQuery('.tb-blog-image .blog-note-top').length > 0){
			jQuery('.tb-blog-image .blog-note-top').on('click', function(e){
				e.preventDefault();
				$(this).parent().fadeOut('slow', function(){
					$(this).remove();
				});
			})
		}
		
		$('body').on('click focus', '#rtb-date, #rtb-time', function(e){  
			var $this = $(this),
				top = $(window).scrollTop();
			setTimeout(function(){
				$(window).scrollTop(top);
			}, 10)
			
			$('.picker__holder').unbind('click').bind('click', function(){
				setTimeout(function(){
					$(window).scrollTop(top);
				}, 10)
			})
		})
		
		//countdown
		var $tb_countdown_js = $('.tb-countdown-js');
		if($tb_countdown_js.length > 0){
			$tb_countdown_js.each(function(){
				var $this = $(this),
					dateEnd = $this.data('countdown');
					
				$this.countdown(dateEnd, function(event){
					var $this = $(this).html(event.strftime(''
					+ '<span class="tb-box-countdown"><span>%m</span> <p>Months</p></span> '
					+ '<span class="tb-box-countdown"><span>%d</span> <p>Days</p></span> '
					+ '<span class="tb-box-countdown"><span>%H</span> <p>Hours</p></span> '
					+ '<span class="tb-box-countdown"><span>%M</span> <p>Minutes</p></span> '
					+ '<span class="tb-box-countdown"><span>%S</span> <p>Seconds</p></span>'));
				});
			})
		}
		
		//checkout
		$('.ro-checkout-process .ro-hr-line .ro-tab-1, .ro-customer-info .ro-edit-customer-info').click(function(){
			var process1 = $('.ro-checkout-process .ro-hr-line .ro-tab-1');
			process1.parent().parent().removeClass('ro-process-2');
			process1.parent().parent().addClass('ro-process-1');
			$('.ro-checkout-panel .ro-panel-1').css('display', 'block');
			$('.ro-checkout-panel .ro-panel-2').css('display', 'none');
		});
		$('.ro-checkout-process .ro-hr-line .ro-tab-2, .ro-checkout-panel .ro-btn-2').click(function(){
			var process2 = $('.ro-checkout-process .ro-hr-line .ro-tab-2');
			process2.parent().parent().removeClass('ro-process-1');
			process2.parent().parent().addClass('ro-process-2');
			$('.ro-checkout-panel .ro-panel-1').css('display', 'none');
			$('.ro-checkout-panel .ro-panel-2').css('display', 'block');
		});
	});
	jQuery(window).load(function(){
		// Paramove carousel
		setTimeout(function(){
			jQuery('.js-paramove').each(function(){
				jQuery(this).paramove({ selector: jQuery(this).data('paramove-target') });
			})
		}, 1000)
		
		// Image blur
		if( jQuery('.tbblur').length > 0 )
			jQuery('.tbblur').tbblur();
			
		// func active tabs default
		jQuery('.wpb_tabs').each(function(){
			var wpb_tabs_nav = $(this).find('.wpb_tabs_nav'),
				active_num = wpb_tabs_nav.data('active-tab');
			wpb_tabs_nav.find('li').eq(parseInt(active_num) - 1).trigger('click');
		})
		
		var $nice_scroll_class_js = $('.nice-scroll-class-js');
		if($nice_scroll_class_js.length > 0 && $.fn.niceScroll !== undefined){
			$nice_scroll_class_js.each(function(){
				$(this).niceScroll();
			})
		}
	})
})(jQuery);