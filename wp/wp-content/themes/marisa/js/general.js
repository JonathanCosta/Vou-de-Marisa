function closelightbox(){
    $('.film').fadeOut(300);
    $('.formnewuser').fadeOut(300);
}

//POSTS Infinite Scrool
function moreposts(url, category) {
    var loadedAjaxPage, pageLoaded, page;
    pageLoaded = $('#pagenumber').val();
    loadedAjaxPage = true;
    $.ajax({
        url: url+"../../../../wp-content/themes/marisa/pagination.php?page="+pageLoaded+"&category="+category+"&loadeditems="+$("#artigos .artigo").length,
        dataType: "text/html",
        beforeSend: function() {
            $(".loaderPage").slideDown(200);
        },
        complete: function (data) {
            var $temp = $($.parseHTML( data.responseText )).find('div.artigo');
            var $totalposts = $.parseHTML( data.responseText );
                $totalposts = ($($totalposts).find('.general').attr('rel'));
            
            $temp.each(function( index ) {
                $('#artigos').append(  $(this).delay(index*150).animate({opacity:1, top:0}, 200)  );
            });
            
            if (data.responseText != "nothing") { 
                $('#pagenumber').val(++pageLoaded);
                //$(".container.loader .mais").slideUp(200);
            } else {
                
            }
            if ( $totalposts >= $('#artigos .artigo').length ) {
                $('.loader').slideUp();
                $('#artigos').css('margin','0 auto 60px');
            }
            $(".loaderPage").slideUp(200, function(){
                loadedAjaxPage = false;
            });
        },
        error: function () {
            $(".loaderPage").slideUp(200, function(){ 
                loadedAjaxPage = false; 
            });
        }
    });
}

(function(){
    'use strict';

    /*
     *
     *
     * GLOBAL VARS
     *
     *
     */
    var scrolled = 0,
        lightboxtimer,
        ajax = true,
        themeurl = "http://vert.se/marisa/blog/wp-content/themes/marisa";

    /*
     *
     *
     * GENERAL FUNCTIONS AND CLASSES
     *
     *
     */

    var BannerCarrossel = function BannerCarrossel($el) {
        this.$el = $el;
        this.interval = 5000;
        this.actual = -1;
        this.slides = 0;
        this.width = 0;
        this.widthStep = 0;
        this.direction = 'foward';
        this.$slider = $el.find('.arrow');
        this.$sliderPrev = $el.find('.arrow.previous');
        this.$sliderNext = $el.find('.arrow.next');
        this.$bulletsContainer = $el.find('.bullets');
        this.$bullets = $el.find('.bullets a');
        this.buildElements();
        this.numberofelements = 0;
    }; //CONSTRUCTOR

    BannerCarrossel.prototype.buildElements = function() {
        var $self = this;
        if(this.$el.length === 0) {
            this.$el.remove();
        } else {
            this.$el.find('li').each(function( index ) {
                var bg = $(this).data('bg'),
                    fg = $(this).data('fg'),
                    fgm = $(this).data('fgm'),
                    link = $(this).data('link'),
                    target_window = $(this).data('window');

                $(this).append('<div href="'+link+'" class="headerBg"></div>');
                $(this).find('.headerBg').css( "background-image", "url('"+bg+"')" );

                $(this).append('<a href="'+link+'" class="headerFg"></a>');
                $(this).find('a').css( "background-image", "url('"+fg+"')" );
                $(this).find('a').attr( "mobile", fgm);

                if ( target_window == 1 ) { $(this).find('a').attr('target','_blank'); }
                //WIDTH OF UL ELEMENT
                $self.width += parseInt($(this).width(), 10);
                $self.widthStep = parseInt($(this).width(), 10);
                $self.slides = $self.$el.find('li').length;
                
                $self.$bulletsContainer.append("<a href='#' rel='"+index+"' onclick='banner.bullet(event, "+index+");'>'"+index+"'</a>");
                
                $self.numberofelements++;
                
            });
            this.$slider.on('click', function(e){
                self = this;
                window.clearInterval($self.timer);
                $self.timer = window.setInterval(function(){ $self.next(); },$self.interval);
                $self[$(self).hasClass('previous') ? 'previous' : 'next']();
            });
            
            $self.next();
            $self.timer();
        }
    };
    
    BannerCarrossel.prototype.bullet = function(e, index, obj) {
        var $self = this;
        e.preventDefault();
        window.clearInterval($self.timer);
        $self.timer = window.setInterval(function(){ $self.next(); },$self.interval);
        if ($self.actual < index) {
            $self.actual++;
            $self.direction = 'foward';
            $self.animaOut($self.actual-1);
        } else if ($self.actual > index) {
            $self.actual--;
            $self.direction = 'backward';
            $self.animaOut(this.actual+1);
        }
    };

    BannerCarrossel.prototype.previous = function(e) {
        if ( this.actual > 0 ) {
            this.actual--;
            this.direction = 'backward';
            this.animaOut(this.actual+1);
        } else {
            this.actual = this.numberofelements - 1;
            this.next();
        }
    };

    BannerCarrossel.prototype.next = function() {
        if ( this.actual < this.slides - 1 ) {
            this.actual++;
            this.direction = 'foward';
            this.animaOut(this.actual-1);
        } else {
            this.actual = 0;
            this.previous();
        }
    };

    BannerCarrossel.prototype.animaOut = function(index) {
        var self = this,
            param;
        if (this.direction == 'foward') {
            param = -this.widthStep;
        } else if (this.direction == 'backward') {
            param = this.widthStep;
        }
        TweenLite.to(this.$el.find('li .headerFg').eq(index), 0.6, {opacity:0, left:param, onComplete: step2});
        function step2() {
            TweenLite.to(self.$el.find('li .headerBg').eq(index), 0.5, {opacity: 0, oncomplete: displaynone(self)});
            TweenLite.to(self.$el.find('li .headerBg').eq(self.actual), 0.5, { opacity:1});
            
            function displaynone(el) {
                el.$el.find('li').eq(index).css('display','none');
                self.animaIn();
            }
        }
    };

    BannerCarrossel.prototype.animaIn = function() {
        this.checkArrows();
        var index = this.actual;
        var self = this;
        this.$el.find('li').eq(index).css('display','block');
        if (this.direction == 'foward') {
            this.$el.find('li .headerFg').eq(index).css('left', (this.widthStep)+'px');
        } else if (this.direction == 'backward') {
        }
        TweenLite.to(this.$el.find('li .headerFg').eq(index), 0.6, { opacity:1, left:0});
    };

    BannerCarrossel.prototype.checkArrows = function() {
        $(this.$bulletsContainer).find('a').removeClass("active");
        $(this.$bulletsContainer).find('a').eq(this.actual).addClass("active");
        if (this.slides > 1) {
            if (this.actual <= 0 ) {
                TweenLite.to(this.$sliderPrev, 0.5, {left:"-200px", opacity: 0});
                TweenLite.to(this.$sliderNext, 0.5, {right:"10px", opacity: 1});
                return false;
            } else if (this.actual >= this.slides - 1 ) {
                TweenLite.to(this.$sliderNext, 0.5, {right:"-200px", opacity: 0});
                TweenLite.to(this.$sliderPrev, 0.5, {left:"10px", opacity: 1});
                return false;
            } else {
                TweenLite.to(this.$sliderNext, 0.5, {right:"10px", opacity: 1});
                TweenLite.to(this.$sliderPrev, 0.5, {left:"10px", opacity: 1});
            }
        } else {
            this.$slider.fadeOut();
            this.$bulletsContainer.fadeOut();
        }
    }; 

    BannerCarrossel.prototype.timer = function() {
        if( $('.film:visible').length < 1 && this.slides > 1 ) {
            var $this = this;
            this.timer = window.setInterval(function(){ $this.next(); },this.interval);
        }
    };

    /*
     *
     *
     * ON PAGE READY
     *
     *
     */
    
    $(function(){
        
        var banner = new BannerCarrossel($('#banner'));
        window.banner = banner;
        
        
        //FIXED MENU ON SCROOL
        $(window).on( 'scroll', function(){
            scrolled = $('body').scrollTop();
            if (scrolled >= 145) {
                $('.fixed_menu').fadeIn(600);
            } else {
                $('.fixed_menu').fadeOut(600);
            }
            if ( $('body.single').length > 0 ) {
                if ( scrolled >= $('#artigos').position().top && scrolled + ( $('.author').outerHeight() ) <= $('#relacionados').position().top - 70 ) {
                    $('#sidebar .author').css('position','fixed');
                    $('#sidebar .author').css('top','10px');
                } else if ( scrolled + ( $('.author').outerHeight() ) > $('#relacionados').position().top - 70 ) {
                    $('#sidebar .author').css('position','absolute');
                    $('#sidebar .author').css('top',$('#relacionados').position().top - $('.author').outerHeight() - 70+'px');
                } else {
                    $('#sidebar .author').removeAttr('style');
                }
            }
            
            if ($('#socials:visible').length > 0) {
                if ( scrolled >= $('#socials').position().top - $(window).outerHeight() + 150 ) {
                    //TWITTER
                    if (ajax === true) {
                        ajax = false;
                        $.ajax({
                            url: themeurl+"/inc/facebook.php",
                            dataType: "text/html",
                            complete: function (data) {
                                var $temp = $($.parseHTML( data.responseText )).find('li');
                                $('.box_facebook_lis img').remove();
                                $temp.prevObject.each(function( index ) {
                                    $('.box_facebook_lis').append(this);
                                });
                                //ajax = true;
                            },
                            error: function () {

                            }
                        });

                        ajax = false;
                        $.ajax({
                            url: themeurl+"/inc/tweets.php",
                            dataType: "text/html",
                            complete: function (data) {
                                var $temp = $($.parseHTML( data.responseText )).find('li');
                                $('.box_twitter_lis img').remove();
                                $temp.prevObject.each(function( index ) {
                                    $('.box_twitter_lis').append(this);
                                });
                                //ajax = true;
                            },
                            error: function () {

                            }
                        });

                        $.ajax({
                            url: themeurl+"/inc/instagram.php",
                            dataType: "text/html",
                            complete: function (data) {
                                var $temp = $($.parseHTML( data.responseText )).find('li');
                                $('.box_instagram_lis img').remove();
                                $temp.prevObject.each(function( index ) {
                                    $('.box_instagram_lis').append(this);
                                });
                                //ajax = true;
                            },
                            error: function () {

                            }
                        });

                        $.ajax({
                            url: themeurl+"/inc/gplus.php",
                            dataType: "text/html",
                            complete: function (data) {
                                var $temp = $($.parseHTML( data.responseText )).find('li');
                                $('.box_gplus_lis img').remove();
                                $temp.prevObject.each(function( index ) {
                                    $('.box_gplus_lis').append(this);
                                });
                                //ajax = true;
                            },
                            error: function () {

                            }
                        });
                    }
                }
            }
        });
        
        $(window).on( 'resize', function(){
            if ($(window).outerWidth() < 920) {
                //ADJUSTING MENU LI's WIDTH
                var navwidth = $('#header nav').outerWidth();
                var headeritens = $('#header nav ul li').length;
                var childrenheaderitens = $('#header nav ul li ul.children li').length;
                var x = ((navwidth)/(headeritens-childrenheaderitens-1))-1;
                $('#header nav ul li').css('min-width',x+'px');
                $('#header nav ul li ul.children li, #header nav ul li ul.children').css('min-width',x+'px');
                
                /*banner.$el.find('li').each(function( index ) {
                    var bg = $(this).data('bg'),
                        fg = $(this).data('fg'),
                        fgm = $(this).data('fgm'),
                        link = $(this).data('link'),
                        target_window = $(this).data('window');

                    $(this).append('<div href="'+link+'" class="headerBg"></div>');
                    $(this).find('.headerBg').css( "background-image", "url('"+bg+"')" );

                    $(this).append('<a href="'+link+'" class="headerFg"></a>');
                    $(this).find('a').css( "background-image", "url('"+fg+"')" );
                    $(this).find('a').attr( "mobile", fgm)" );

                    if ( target_window == 1 ) { $(this).find('a').attr('target','_blank'); }
                    //WIDTH OF UL ELEMENT
                    $self.width += parseInt($(this).width(), 10);
                    $self.widthStep = parseInt($(this).width(), 10);
                    $self.slides = $self.$el.find('li').length;

                    $self.$bulletsContainer.append("<a href='#' rel='"+index+"' onclick='banner.bullet(event, "+index+");'>'"+index+"'</a>");

                    $self.numberofelements++;

                });*/
            } else {
                
            }
        });
        
        //INITIAL LIGHTBOX ENGINE
        $('.closelightbox').on('click', closelightbox);
        if( $('.film:visible').length > 0 ) {
            lightboxtimer = window.setTimeout(function(){ $('.closelightbox').click(); }, 5000);
        }
        $('.formnewuser').mouseenter(function(){
            clearTimeout(lightboxtimer);
        }).mouseleave(function(){
            lightboxtimer = window.setTimeout(function(){ $('.closelightbox').click(); }, 5000);
        });
        
        $('.menumobile').on('click', function(event){
            event.preventDefault();
            $('#header nav ul').slideToggle(300);
        });
        
        
    });

})();