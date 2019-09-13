
+function($) {

// cache img.lazyload collection
    var $lazyload;

// VIEWPORT HELPER CLASS DEFINITION
// ================================
    var viewport;
    var ViewPort = function(options){
        this.viewportWidth = 0;
        this.viewportHeight = 0;
        this.options = $.extend({}, ViewPort.DEFAULTS, options);
        this.attrib = "src";
        this.update();
    };

    ViewPort.DEFAULTS = {
        breakpoints : {
            0: 'extrasmall',
            768: 'small',
            992: 'medium',
            1200: 'large'
        }
    };

    ViewPort.prototype.viewportW = function() {
        var clientWidth = document.documentElement['clientWidth'], innerWidth = window['innerWidth'];
        return this.viewportWidth = clientWidth < innerWidth ? innerWidth : clientWidth;
    };

    ViewPort.prototype.viewportH = function() {
        var clientHeight = document.documentElement['clientHeight'], innerHeight = window['innerHeight'];
        return this.viewportHeight = clientHeight < innerHeight ? innerHeight : clientHeight;
    };

    ViewPort.prototype.inviewport = function(boundingbox) {
        return !!boundingbox && boundingbox.bottom >= 0 && boundingbox.right >= 0 && boundingbox.top <= this.viewportHeight && boundingbox.left <= this.viewportWidth;
    };

    ViewPort.prototype.update = function(){
        this.viewportH();
        this.viewportW();
        var attrib = this.attrib,
            width = this.viewportWidth;

        $.each(this.options.breakpoints, function (breakpoint, datakey) {
            if (width >= breakpoint) {
                attrib = datakey;
            }
        });

        this.attrib = attrib;
    };

// expose viewportH & viewportW methods
    $.fn.viewportH = ViewPort.prototype.viewportH;
    $.fn.viewportW = ViewPort.prototype.viewportW;

// RESPONSIVE IMAGES CLASS DEFINITION
// ==================================
    var ResponsiveContent = function(element, options) {
        this.$element = $(element);
        this.options = $.extend({}, ResponsiveContent.DEFAULTS, options);
        this.attrib = "data-link";
        this.loaded = false;
        this.checkviewport();
    };

    ResponsiveContent.DEFAULTS = {
        threshold: 0,
        attrib: "data-link",
        skip_invisible: false,
        preload: false
    };

    ResponsiveContent.prototype.checkviewport = function() {
        if (this.attrib !== viewport.attrib) {
            this.attrib = viewport.attrib;
            this.loaded = false;
        }
        this.unveil();
    };

    ResponsiveContent.prototype.boundingbox = function() {
        var boundingbox = {},
            coords = this.$element[0].getBoundingClientRect(),
            threshold = +this.options.threshold || 0;
        boundingbox['right'] = coords['right'] + threshold; boundingbox['left'] = coords['left'] - threshold;
        boundingbox['bottom'] = coords['bottom'] + threshold; boundingbox['top'] = coords['top'] - threshold;
        return boundingbox;
    };

    ResponsiveContent.prototype.inviewport = function() {
        var boundingbox = this.boundingbox();
        return viewport.inviewport(boundingbox);
    };

    ResponsiveContent.prototype.unveil = function(force) {
        if (this.loaded || !force && !this.options.preload && this.options.skip_invisible && this.$element.is(":hidden")) return;
        var inview = force || this.options.preload || this.inviewport();
        console.log("ResponsiveContent view?");
		var loading = loading || false
        if (inview) {
            var source = $(this.$element).data("link");
			$(this.$element).addClass("fadeInLeft").addClass("animated");
			if (!loading && source) {
				loading = true;

                console.log("ResponsiveContent load");
                this.$element.attr("data-link", source);
				var $newscontainer = $j('#news-container-' + $j(this).data('container'))
				var loader = $j('<div class="loader" style="position:absolute; z-index:999; height:50px;width:50px"></div>')
					.appendTo($newscontainer.find('.pagination'));
                $.ajax({
                    url: source.replace("http:", "https:"),
                    type: 'GET',
                    success: function (result) {
                        $j(loader).remove();
						var ajaxDom = $j(result).find('.news-list-item');
						$j('.pagination .last.next').replaceWith($j(result).find('.pagination .last.next'));

						if(ajaxDom){
							$j(ajaxDom).each( function () {

								if($j.type(tp3_app.isotop == "function") && ($newscontainer.hasClass("isotop") || $newscontainer.hasClass("boxes"))){
									$j('.news-panel').append(this);
                            // add and lay out newly prepended items
									var item = this;
									window.$container.isotope()
										.append( item )
										.isotope( 'appended', item )
										.isotope('layout');

                        }
								else

									$j('.news-panel').append(this);
							});
                        }
                        // })
                        $('.news-panel').height('100%')
                        // if ($.type(tp3_app.isotop == "function") && ($('.news-panel').hasClass("isotop") || $('.news-panel').hasClass("boxes"))) {
                        //     window.$container.isotope({
                        //         itemSelector: '.news-list-item',
                        //         layoutMode: 'masonry', //masonry
                        //         masonry: {
                        //             columnWidth: screen.availHeight / 3
                        //         },
                        //         getSortData: {
                        //             headline: '.headline',
                        //             category: '[data-category]',
                        //             time: '[data-time]',
                        //
                        //         }
                        //     });
                        // }
                    },
                    error: function () {
                        $(loader).remove();
                        $('.pagination').show();

                    }
                });
                this.loaded	= true;
            }
            else if($(this.$element).parents('.news-list-view').hasClass('isotop') || $(this.$element).parents('.news-list-view').hasClass("boxes")){
					$(this.$element).parents('.news-panel').isotope('layout');

            }
        }
    };

    ResponsiveContent.prototype.print = function() {
        this.unveil(true);
    };

// RESPONSIVE IMAGES PLUGIN DEFINITION
// ===================================
    function Plugin(option) {
        $lazyload = this;
        console.log("ResponsiveContent");
        return this.each(function() {
            var $this = $(this);
            var data = $this.data("tp3.responsiveContent");
            var options = typeof option === 'object' && option;

            if (!data) {
                if (!viewport) viewport = new ViewPort(options && options.breakpoints ? {breakpoints:options.breakpoints} : {});

                if (options && options.breakpoints) options.breakpoints = null;
                options = $.extend({}, $this.data(), options);

                $this.data('tp3.responsiveContent', (data = new ResponsiveContent(this, options)));
            }
            if (typeof option === 'string') data[option]();
        });
    }
// var old = $.fn.responsiveContents;
    $.fn.responsiveContent = Plugin;
    $.fn.responsiveContent.Constructor = ResponsiveContent;

    $(window).on('load.tp3.responsiveContent', function() {
        $('.news .responsiveContent, .frame-backgroundimage-fade').responsiveContent();
        // EVENTS
        // ======
        $(window)
            .on('scroll.tp3.responsiveContent', function(){
                $lazyload.responsiveContent('unveil');
            })
            .on('resize.tp3.responsiveContent', function(){
                if (viewport) viewport.update();
                $lazyload.responsiveContent('checkviewport');
            })
            .on('beforeprint.tp3.responsiveContent', function(){
                $lazyload.responsiveContent('print');
                $(window).trigger("readytoprint.tp3.responsiveContent");
            });
    });
}(jQuery);
