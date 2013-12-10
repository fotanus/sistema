// JavaScript Document
(function(window, $, undefined) {
    $.fokusss = function(options, element) {
        this.$el = $(element);
        this.$lista = this.$el.children('div');
        this.$elementos = this.$lista.find('img');
        this.$first = this.$el.find('div:first');
        this.numElementos = this.$elementos.length;
        this.actual = this.$first.index();
        this.anterior = 0;
        this.siguiente = 0;

        this.inicio = true;

        this._init(options);
    };

    $.fokusss.defaults = {
        animation: 'fadeout',
        autoplay: true,
        slideshow_interval: 3000
    };

    $.fokusss.prototype = {
        _init: function(options) {
            this.options = $.extend(true, {}, $.fokusss.defaults, options);
            var _self = this;
            this.$loading = $('<div>Cargando...</div>').prependTo('.mo-riel');

            _self.$el.hide();
            
            $.when(_self._preloadImages()).done(function() {
                _self.$loading.hide();
                _self.$el.show();
                _self._showImage();
                if (_self.options.autoplay) {
                    _self._startSlideshow();
                }
            });
        },
        _preloadImages: function() {
            var _self = this, loaded = 0;
            return $.Deferred(
                    function(dfd) {
                        _self.$elementos.each(function(i) {
                            $('<img/>').load(function() {
                                if (++loaded === _self.numElementos) {
                                    dfd.resolve();
                                }
                            }).attr('src', $(this).attr('src'));
                        });
                    }
            ).promise();
        },
        _showImage: function() {
            var _self = this;
            $('.mo-arrow').click(function(e) {
                var lado = ($(this).hasClass('mo-riel-left') ? -1 : 1);
                var idx = $('.mo-riel-imagen, .mo-fondo-secciones-carrusel').find('#currentDiv').index() + lado;
                clearTimeout(_self.slideshow);
                _self._startSlideshow(idx);
            });
        },
        _nextSlide: function(show) {
            var _self = this;
            if (this.actual == this.numElementos) {
                this.actual = 0;
            } else if (this.actual == -1) {
                this.actual = this.numElementos - 1;
            }

            if (show != undefined) {
                _self.$lista.eq(this.siguiente).fadeOut();
                _self.$lista.eq(this.siguiente).removeAttr('id');
                if (show == this.numElementos) {
                    show = 0;
                }
                this.actual = _self.$lista.eq(show).index() - 1;
                this.siguiente = show;
            } else {
                this.siguiente = (this.actual == this.numElementos - 1) ? 0 : this.actual + 1;
                this.anterior = (this.actual == 0) ? this.numElementos - 1 : this.actual - 1;
            }

            var $esconder = _self.$lista.eq(this.actual);
            var $mostrar = _self.$lista.eq(this.siguiente);
            $esconder.fadeOut();
            $esconder.removeAttr('id');
            $mostrar.fadeIn();
            $mostrar.attr('id', 'currentDiv');

            $('#titulo').html($($mostrar).find('span[class="titulo"]').html());
            $('#descripcion').html($($mostrar).find('span[class="descripcion"]').html());

            this.actual++;
        },
        _startSlideshow: function(show) {
            var _self = this;

            _self._nextSlide(show);
            this.slideshow = setTimeout(function() {
                if (_self.options.autoplay) {
                    _self._startSlideshow();
                }
            }, _self.options.slideshow_interval);
        }
    };
    $.fn.fokusslideshow = function(options) {
        if (typeof options === 'string') {
            var args = Array.prototype.slice.call(arguments, 1);
            this.each(function() {
                var instance = $.data(this, 'fokusslideshow');
                if (!instance) {
                    logError("cannot call methods on fokusslideshow prior to initialization; " +
                            "attempted to call method '" + options + "'");
                    return;
                }
                if (!$.isFunction(instance[options]) || options.charAt(0) === "_") {
                    logError("no such method '" + options + "' for fokusslideshow instance");
                    return;
                }
                instance[ options ].apply(instance, args);
            });
        }
        else {
            this.each(function() {
                var instance = $.data(this, 'fokusslideshow');
                if (!instance) {
                    $.data(this, 'fokusslideshow', new $.fokusss(options, this));
                }
            });
        }
        return this;
    };
})(window, jQuery);