(function($) {
	"use strict";
	jQuery(document).ready(function($) {
		var carouselIds = new Array();
		var carouselImprovedIds = new Array();
		var carouselSkyIds = new Array();
		/*do owl carousel*/
		$(".tb-carousel").each(function() {
			carouselIds.push($(this).attr("id"));
		});
		for (var i in carouselIds) {
			var params = {};
			var datas = $(document.getElementById(carouselIds[i])).data();
			for (var paramName in datas) {
				var data = $(document.getElementById(carouselIds[i])).data(paramName);
				if (data !== "") {
					// If it's an array (contains comma) parse the string to array
					if(String(data).indexOf(",") > -1) {
						data = data.split(",");
					}
					// New random param not available in Owl Carousel
					if(paramName == "random") {
						params[owlCarouselParamName("beforeInit")] = function(elem) {
							random(elem);
						};
					} else {
						params[owlCarouselParamName(paramName)] = data;
					}
				}
			}
			params.itemsDesktop = '[1199,3]';
			params.itemsTablet = '[768,1]';
			console.log(params);
			$(document.getElementById(carouselIds[i])).owlCarousel(params);
		}
		/*do improved carousel*/
		$(".tb-carousel-improved").each(function() {
			carouselImprovedIds.push($(this).attr("id"));
		});
		for (var i in carouselImprovedIds) {
			var params = {};
			var datas = $(document.getElementById(carouselImprovedIds[i])).data();
			for (var paramName in datas) {
				var data = $(document.getElementById(carouselImprovedIds[i])).data(paramName);
				if (data !== "") {
					// If it's an array (contains comma) parse the string to array
					if(String(data).indexOf(",") > -1) {
						data = data.split(",");
					}
					// New random param not available in Owl Carousel
					if(paramName == "random") {
						params[owlCarouselParamName("beforeInit")] = function(elem) {
							random(elem);
						};
					} else {
						params[owlCarouselParamName(paramName)] = data;
					}
				}
			}
			params['itemsdesktop'] = '[1199,3]';
			params['itemsmobile'] = '[479,3]';
			$(document.getElementById(carouselImprovedIds[i])).owlCarouselImproved(params);
			var count = $(document.getElementById(carouselImprovedIds[i])).find('.owl-item').length;
			var index = parseInt(count/2);
			var carousel = $(document.getElementById(carouselImprovedIds[i])).data('owlCarousel');
			carousel.goTo(index); 
		}
		/*do sky carousel*/
		$(".sky-carousel").each(function() {
			carouselSkyIds.push($(this).attr("id"));
		});
		for (var i in carouselSkyIds) {
			var params = {};
			var datas = $(document.getElementById(carouselSkyIds[i])).data();
			for (var paramName in datas) {
				var data = $(document.getElementById(carouselSkyIds[i])).data(paramName);
				console.log(data+'&&'+paramName);
				if (data !== "") {
					// If it's an array (contains comma) parse the string to array
					if(String(data).indexOf(",") > -1) {
						data = data.split(",");
					}
					// New random param not available in Owl Carousel
					if(paramName == "random") {
						params[skyCarouselParamName("beforeInit")] = function(elem) {
							random(elem);
						};
					} else {
						params[skyCarouselParamName(paramName)] = data;
					}
				}
			}
			$(document.getElementById(carouselSkyIds[i])).skycarousel(params);
		}

		/**
		 * Sort random function
		 * @param {Selector} owlSelector Owl Carousel selector
		 */
		function random(owlSelector){
			owlSelector.children().sort(function(){
				return Math.round(Math.random()) - 0.5;
			}).each(function(){
				$(this).appendTo(owlSelector);
			});
		}

	});

	/**
	 * Fix Owl Carousel parameter name case.
	 * @param {String} paramName Parameter name
	 * @returns {String} Fixed parameter name
	 */
	function owlCarouselParamName(paramName) {

		var parameterArray = {
			ADDCLASSACTIVE: "addClassActive",
			AFTERACTION: "afterAction",
			AFTERINIT: "afterInit",
			AFTERLAZYLOAD: "afterLazyLoad",
			AFTERMOVE: "afterMove",
			AFTERUPDATE: "afterUpdate",
			AUTOHEIGHT: "autoHeight",
			AUTOPLAY: "autoPlay",
			BASECLASS: "baseClass",
			BEFOREINIT: "beforeInit",
			BEFOREMOVE: "beforeMove",
			BEFOREUPDATE: "beforeUpdate",
			DRAGBEFOREANIMFINISH: "dragBeforeAnimFinish",
			ITEMS: "items",
			ITEMSCUSTOM: "itemsCustom",
			ITEMSDESKTOP: "itemsDesktop",
			ITEMSDESKTOSMALL: "itemsDesktopSmall",
			ITEMSMOBILE: "itemsMobile",
			ITEMSSCALEUP: "itemsScaleUp",
			ITEMSTABLET: "itemsTablet",
			ITEMSTABLETSMALL: "itemsTabletSmall",
			JSONPATH: "jsonPath",
			JSONSUCCESS: "jsonSuccess",
			LAZYLOAD: "lazyLoad",
			LAZYFOLLOW: "lazyFollow",
			LAZYEFFECT: "lazyEffect",
			MOUSEDRAG: "mouseDrag",
			NAVIGATION: "navigation",
			NAVIGATIONTEXT: "navigationText",
			PAGINATION: "pagination",
			PAGINATIONNUMBERS: "paginationNumbers",
			PAGINATIONSPEED: "paginationSpeed",
			RESPONSIVE: "responsive",
			RESPONSIVEBASEWIDTH: "responsiveBaseWidth",
			RESPONSIVEREFRESHRATE: "responsiveRefreshRate",
			REWINDNAV: "rewindNav",
			REWINDSPEED: "rewindSpeed",
			SCROLLPERPAGE: "scrollPerPage",
			SINGLEITEM: "singleItem",
			SLIDESPEED: "slideSpeed",
			STARTDRAGGING: "startDragging",
			STOPONHOVER: "stopOnHover",
			THEME: "theme",
			TOUCHDRAG: "touchDrag",
			TRANSITIONSTYLE: "transitionStyle",
		};

		return parameterArray[paramName.toUpperCase()];
	}
	/**
	 * Fix Sky Carousel parameter name case.
	 * @param {String} paramName Parameter name
	 * @returns {String} Fixed parameter name
	 */
	function skyCarouselParamName(paramName) {

		var parameterArray = {
			ITEMWIDTH: 'itemWidth',
			ITEMHEIGHT: 'itemHeight',
			DISTANCE: 'distance',
			STARTINDEX: 'startIndex',
			ENABLEKEYBOARD: 'enableKeyboard',
			ENABLEMOUSEWHEEL: 'enableMouseWheel',
			REVERSEMOUSEWHEEL: 'reverseMouseWheel',
			AUTOSLIDESHOW: 'autoSlideshow',
			AUTOSLIDESHOWDELAY: 'autoSlideshowDelay',
			LOOP: 'loop',
			SELECTEDITEMDISTANCE: 'selectedItemDistance',
			SELECTEDITEMZOOMFACTOR: 'selectedItemZoomFactor',
			UNSELECTEDITEMZOOMFACTOR: 'unselectedItemZoomFactor',
			UNSELECTEDITEMALPHA: 'unselectedItemAlpha',
			MOTIONSTARTDISTANCE: 'motionStartDistance',
			TOPMARGIN: 'topMargin',
			PRELOAD: 'preload',
			SHOWPRELOADER: 'showPreloader',
			NAVIGATIONBUTTONSVISIBLE: 'navigationButtonsVisible',
			GRADIENTSTARTPOINT: 'gradientStartPoint',
			GRADIENTENDPOINT: 'gradientEndPoint',
			GRADIENTOVERLAYVISIBLE: 'gradientOverlayVisible',
			GRADIENTOVERLAYCOLOR: 'gradientOverlayColor',
			GRADIENTOVERLAYSIZE: 'gradientOverlaySize',
			REFLECTIONVISIBLE: 'reflectionVisible',
			REFLECTIONDISTANCE: 'reflectionDistance',
			REFLECTIONSIZE: 'reflectionSize',
			REFLECTIONALPHA: 'reflectionAlpha',
			SLIDESPEED: 'slideSpeed',
			SELECTBYCLICK: 'selectByClick',
		};

		return parameterArray[paramName.toUpperCase()];
	}
})(jQuery);