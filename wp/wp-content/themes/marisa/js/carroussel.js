Carroussel = function(elem, itens, cb) {
    var elem = elem, itensPerPage = itens || 1;
    return {
        load: function () {
            var html = '<span class="slider prev"></span><span class="slider next"></span>';
            elem.prepend(html);
            this.setSliders();
        },


        setSliders: function () {
            var item, that = this;
            this.index = 1;
            // Set sliders reference and update slider buttons
            this.$sliderPrev = elem.find('.prev');
            this.$sliderNext = elem.find('.next');
            this.$gallery    = elem.find('ul');
            this.$window     = this.$gallery.parent();
            item = this.$gallery.find('li:visible');
            this.totalItens = item.length;

            if(this.totalItens > itensPerPage) {
                this.itemWidth = this.$window.width() / itensPerPage;
                this.$gallery.css({
                    width: (this.itemWidth * this.totalItens) + 'px',
                    height: '100%',
                    position: 'absolute',
                    top: 0,
                    left: 0
                }).parent().css({ position: 'relative'});
                this.lastItem = itensPerPage;
                this.updateSliders();
            } else {
                if(cb) cb(this.index);
            }

            elem.find('.slider').bind('click', function() {
                if(!$(this).hasClass('show') || that.animating) return;
                var method = $(this).hasClass('prev') ? 'slidePrev' : 'slideNext';
                that[method]();
            });
        },

        updateSliders: function () {
            // this.$gallery.find('iframe').each(function() {
            //  $(this).attr('src', $(this).attr('src'));
            // });
            if (this.lastItem < this.totalItens) {
                this.$sliderNext.addClass('show');
            } else {
                this.$sliderNext.removeClass('show');
            }
            if (this.lastItem > itensPerPage) {
                this.$sliderPrev.addClass('show');
            } else {
                this.$sliderPrev.removeClass('show');
            }
            this.animating = false;
            if(cb) cb(this.index);
        },

        slidePrev: function () {
            this.index--;
            this.animating = true;
            var that = this,
                steps = (this.lastItem - itensPerPage) >= itensPerPage ?
                    itensPerPage : this.lastItem - itensPerPage,
                left = (this.lastItem - steps - itensPerPage) * this.itemWidth;

            this.lastItem -= steps;
            
            this.$gallery.animate({'left': -left}, 500, function () {
                that.updateSliders();
            });
        },

        slideNext: function () {
            this.index++;
            this.animating = true;
            var that = this,
                steps = (this.lastItem + itensPerPage) <= this.totalItens ?
                    itensPerPage : this.totalItens - this.lastItem,
                left = (this.lastItem + steps - itensPerPage) * this.itemWidth;

            this.lastItem += steps;
            
            this.$gallery.animate({'left': -left}, 500, function () {
                that.updateSliders();
            });
        }
    }
};