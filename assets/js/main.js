(function($) { 
	'use strict';

  	/**
	 * Match Height
	 */
	
	if ( $.isFunction($.fn.matchHeight) ) {
		$('.wpb-is-item').matchHeight();
	}


	/**
	 * Gettings Instagram Images 
	 */
	
	if ( typeof Instafeed !== 'undefined' ){
		$(".wpb-instragram-feed-wrapper").each(function() {

			var t 			= $(this).find('.wpb-instragram-feed'),
			wpb_is_slider 	= $(this).find('.wpb-is-content-type-slider'),
			ElementId       = t.attr('id'),
			userid          = t.data("userid") ? parseInt(t.data("userid")) : '',
			contenttype     = t.data("contenttype"),
			count    		= t.data("count") ? parseInt(t.data("count")) : '',
			caption    		= t.data("caption"),
			image_size    	= t.data("image_size"),
			auto            = t.data("autoplay") ? !0 : !1,
			loop            = t.data("loop") ? !0 : !1,
			rtl             = t.data("direction") ? !0 : !1,
			items           = t.data("items") ? parseInt(t.data("items")) : '',
			desktopsmall    = t.data("desktopsmall") ? parseInt(t.data("desktopsmall")) : '',
			tablet          = t.data("tablet") ? parseInt(t.data("tablet")) : '',
			mobile          = t.data("mobile") ? parseInt(t.data("mobile")) : '',
			nav             = t.data("navigation") ? !0 : !1,
			pag             = t.data("pagination") ? !0 : !1,
			navTextLeft 	= t.data("direction") ? 'right' : 'left',
	        navTextRight 	= t.data("direction") ? 'left' : 'right';

			var loadButton = $(this).find('.wpb-instragram-load-more');

			if( contenttype == 'slider' ){
				var ItemClass 	   = 'wpb-is-item';
			}else{
				var ItemClass 	   = 'wpb-is-item wpb-is-col-md-4 wpb-is-col-sm-6';
			}

			if( caption == 'on' ){
				var captionText 	   = '<h3 class="wpb-is-item-title">{{caption}}</h3>';
			}else{
				var captionText 	   = '';
			}

			var feed = new Instafeed({
		        get: 			'user',
		        clientId: 		'81379547dcf44db19ed8aae77e7fb652',
		        userId: 		userid,
		        accessToken: 	wpb_instagram_js_options.wpb_instagram_accesstoken,
		        target: 		ElementId,
		        limit: 			count,
		        resolution:     image_size,
		        template: 		'<div class="'+ ItemClass +'"><a class="wpb-is-item-link" data-url="{{link}}" href="{{model.images.standard_resolution.url}}" data-rel="lightcase:'+ ElementId +':slideshow"><span class="wpb-is-item-image"><img src="{{image}}" alt="{{caption}}"/></span>'+ captionText +'</a></div>',
		        before: function() {
		        	t.append( "<strong class='wpb-is-loading'>" + wpb_instagram_loading_text_options.wpb_is_loading_text + "</strong>" );

		        	if ( $.isFunction($.fn.matchHeight) ) {
						$('.wpb-is-item').matchHeight({ remove: true });
					}
		        },
		        after: function() {
		            if (!this.hasNext()) {
		                loadButton.addClass('wpb-is-btn-disabled');
		            }

		            if ( $.isFunction($.fn.lightcase) ) {
						$('a[data-rel^=lightcase]').lightcase({
							maxWidth : 1080,
							maxHeight : 1080,
						});
					}

					if( contenttype == 'slider' ){
						wpb_is_slider.owlCarousel({
							items: items,
							responsiveClass:true,
							responsive:{
								0:{
									items: mobile,
								},
								479:{
									items: mobile,
								},
								767:{
									items: tablet,
								},
								980:{
									items: desktopsmall,
								},
								1170:{
									items: items,
								}
							},
							loop: loop,
							rtl: rtl,
							autoplay: auto,
							dots: pag,
							nav: nav,
							autoplayTimeout: 7000,
							navText : ['<i class="flaticon-'+navTextLeft+'-arrow" aria-hidden="true"></i>','<i class="flaticon-'+navTextRight+'-arrow" aria-hidden="true"></i>'],
							autoplayHoverPause: false,
							touchDrag: true,
							mouseDrag: true,
							margin: 10,
						});
					}

					if ( $.isFunction($.fn.matchHeight) ) {
						$('.wpb-is-item').matchHeight({ 
							byRow: ( contenttype == 'slider' ? true : false ), 
						});
					}

					$( ".wpb-is-loading" ).remove();
		        }
		    });

		    // bind the load more button
		    loadButton.on('click', function(e) {
		    	e.preventDefault();
		        feed.next();
		    });

			feed.run();

		}); 
	}


	/**
	 * LightBox
	 */
	
	if ( $.isFunction($.fn.lightcase) ) {
		$('a[data-rel^=lightcase]').lightcase({
			maxWidth : 1080,
			maxHeight : 1080,
		});
	}


})(jQuery);  