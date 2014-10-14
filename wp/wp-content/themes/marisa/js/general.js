function closelightbox(){
    $('.film').fadeOut(300);
    $('.formnewuser').fadeOut(300, function(){
        if (banner.slides > 1) {
            banner.timer();
        }
    });
}

function adjustMenu() {
    var navwidth = $('#header nav').outerWidth();
    var headeritens = $('#header nav ul li').length;
    var childrenheaderitens = $('#header nav ul li ul.children li').length;
    var x = ((navwidth)/(headeritens-childrenheaderitens-1))-1;
    var x_fixed_menu = ((navwidth-(76*2))/(headeritens-childrenheaderitens-1))-1;
    $('#header nav ul li, #header nav ul li ul.children li, #header nav ul li ul.children').css('width',x+'px');
    $('.fixed_menu ul li, .fixed_menu ul li ul.children li, .fixed_menu ul li ul.children').css('width',x_fixed_menu+'px');
    $('#header nav ul.children li').css('min-width',x+'px');
    $('.fixed_menu ul.children li').css('min-width',x_fixed_menu+'px');
}

function removeImageDimensions() {
    $('.artigo img').each(function( index ) {
        $(this).removeAttr('width');
        $(this).removeAttr('height');
    });
}

function adjustCarrossel() {
    if ($(window).outerWidth() < 920) {
        banner.$el.find('li').each(function( index ) {
            var fg = $(this).data('fgm');
            if ( fg.length < 1 ) {
                fg = $(this).data('fg');
            }
            $(this).find('a').css('background-image','url('+fg+')');
        });
    } else {
        banner.$el.find('li').each(function( index ) {
            var fg = $(this).data('fg');
            $(this).find('a').css('background-image','url('+fg+')');
        });

    }
}

function fixlink(event){ event.preventDefault(); }

//POSTS Infinite Scrool
function moreposts(url, category) {
    var loadedAjaxPage, pageLoaded, page;
    pageLoaded = $('#pagenumber').val();
    loadedAjaxPage = true;
    $.ajax({
        url: app.templateUrl+"/pagination.php?page="+pageLoaded+"&category="+category+"&loadeditems="+$("#artigos .artigo").length,
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

function appendAdminOptions() {
    $('#wpadminbar')
        .addClass('visible')
        .addClass('hidemobile')
        .find('#wp-admin-bar-top-secondary')
        .detach();
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
        ajax = true;

    /*
     *
     *
     * GENERAL FUNCTIONS AND CLASSES
     *
     *
     */

    var BannerCarrossel = function BannerCarrossel($el) {
        this.$el = $el;
        this.interval = 6000;
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
                
                if (bg.length > 0 && fg.length > 0) {
                    $self.width += parseInt($(this).width(), 10);
                    $self.widthStep = parseInt($(this).width(), 10);
                    $self.slides = $self.$el.find('li').length;

                    $self.$bulletsContainer.append("<a href='#' rel='"+index+"' onclick='banner.bullet(event, "+index+");'>'"+index+"'</a>");
                    $self.numberofelements++;
                } else {
                    $(this).remove();
                }
                
                
            });
            this.$slider.on('click', function(e){
                self = this;
                window.clearInterval($self.timer);
                $self.timer = window.setInterval(function(){ $self.next(); },$self.interval);
                $self[$(self).hasClass('previous') ? 'previous' : 'next']();
            });
            
            if ( $self.$el.find('li').length > 0) {
                $self.next();
                $self.timer();
            } else {
                $self.$el.remove();
            }
        }
    };
    
    BannerCarrossel.prototype.bullet = function(e, index, obj) {
        var $self = this;
        e.preventDefault();
        window.clearInterval($self.timer);
        if ($self.actual < index) {
            $self.actual++;
            $self.direction = 'foward';
            $self.animaOut($self.actual-1);
        } else if ($self.actual > index) {
            $self.actual--;
            $self.direction = 'backward';
            $self.animaOut(this.actual+1);
        }
        $self.actual=index;
        $self.timer = window.setInterval(function(){ $self.next(); },$self.interval);
        
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
            TweenLite.to(self.$el.find('li .headerBg').eq(index), 0.5, {opacity: 0, onComplete: displaynone(self)});
            TweenLite.to(self.$el.find('li .headerBg').eq(self.actual), 0.5, { opacity:1});
            
            function displaynone(el) {
                //el.$el.find('li').eq(index).css('display','none');
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
            this.$el.find('a').on('click', fixlink);
            this.$el.find('a').css('cursor','default');
        }
    }; 

    BannerCarrossel.prototype.timer = function() {
        var $this = this;
        if( $('.film:visible').length < 1 && this.slides > 1 ) {
            this.timer = window.setInterval(function(){ $this.next(); },$this.interval);
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
        
        adjustMenu();
        adjustCarrossel();
        removeImageDimensions();
        
        $('.children li:last-child').find('a').css('border-bottom', '0px');
        
        $('#submenu input').on('click', function(e){
            $('#submenu ul li a.active').click();
        });
        
        //FIXED LAST MENU LI
        $('#header nav ul li:visible').last().addClass('last');
        
        $('#submenu ul li a').on('click', function(e){
            e.preventDefault();
            $('#submenu ul li a').removeClass("active");
            $(this).addClass("active");
            if ($(this).html() != "Todas") {
                app.filtercategory = $(this).html(); 
            } else {
                var aux = $('#submenu h5').html();
                app.filtercategory = aux.trim(); 
            }
            app.filterorderby = $('.filtroposts:checked').val();
            $("#artigos .artigo").fadeOut(200, function() {
                $(this).remove();
                var html = "<div class=\"loaderPage\"><img src=\"http://marisa/wp-content/themes/marisa/images/ajax-loader.gif\"></div>";
                if ( $('#artigos .loaderPage').length < 1 ) {
                    $('#artigos').append(html);
                    $('#artigos .loaderPage').slideDown(300);
                }
            });
            
            
            var pageLoaded = $('#pagenumber').val();
            var loadedAjaxPage = true;
            $.ajax({
                url: app.templateUrl+"/pagination.php?page=1&category="+app.filtercategory+"&loadeditems=0&order="+app.filterorderby,
                dataType: "text/html",
                beforeSend: function() {
                    $(".loaderPage").slideDown(200);
                },
                complete: function (data) {
                    var $temp = $($.parseHTML( data.responseText )).find('div.artigo');
                    var $totalposts = $.parseHTML( data.responseText );
                        $totalposts = ($($totalposts).find('.general').attr('rel'));

                    $('#artigos .loaderPage').remove();
                    
                    $temp.each(function( index ) {
                        $('#artigos').append(  $(this).delay(index*150).animate({opacity:1, top:0}, 200)  );
                    });

                    if (data.responseText != "nothing") { 
                        $('#pagenumber').val(++pageLoaded);
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
        });
        
        var postShare, countImageMarker = 1;
        $('.image_tag').each(function( index ) {
            postShare = '';
            postShare += '<div class="postshare">';
            postShare += '    <header class="hidemobile">';
            postShare += '    <ico class="sprite-share-author author-share hidemobile"></ico>';
            postShare += '        COMPARTILHE';
            postShare += '    </header>';
            postShare += '    <header class="mobile">';
            postShare += '        <ico class="sprite-share-mobile mobile"></ico>';
            postShare += '    </header>';
            postShare += '    <a href="http://www.facebook.com/sharer.php?u='+app.thisPageUrlEncoded+'#ImageMarker'+countImageMarker+'" target="_blank" title="Facebook do autor" class="sprite-facebook-author hidemobile">Facebook</a>';
            postShare += '    <a href="http://www.twitter.com/share?text=Li+e+gostei+no+Blog+da+Marisa&url='+app.thisPageUrlEncoded+'#ImageMarker'+countImageMarker+'" target="_blank" title="Twitter do autor" class="sprite-twitter-author hidemobile">Twitter</a>';
            postShare += '    <a href="http://plus.google.com/share?url='+app.thisPageUrlEncoded+'#ImageMarker'+countImageMarker+'" target="_blank" title="Google Plus do autor" class="sprite-gplus-author hidemobile">Google Plus</a>';
            postShare += '    <a href="http://www.facebook.com/sharer.php?u='+app.thisPageUrlEncoded+'#ImageMarker'+countImageMarker+'" target="_blank" title="Facebook do autor" class="sprite-facebook-author sprite-facebook-mobile mobile\">Facebook</a>';
            postShare += '    <a href="http://www.twitter.com/share?text=Li+e+gostei+no+Blog+da+Marisa&url='+app.thisPageUrlEncoded+'#ImageMarker'+countImageMarker+'" target="_blank" title="Twitter do autor" class="sprite-twitter-author sprite-twitter-mobile mobile">Twitter</a>';
            postShare += '    <a href="http://plus.google.com/share?url="'+app.thisPageUrlEncoded+'#ImageMarker'+countImageMarker+'" target="_blank" title="Google Plus do autor" class="sprite-gplus-author sprite-gplus-mobile mobile">Google Plus</a>';
            postShare += '</div>';
            $(this).after(postShare);
            $(this).before('<a name="ImageMarker'+countImageMarker+'"></a>');
            countImageMarker++;
        }); 
        
        
        window.ImageMarker && ImageMarker.format();
        
        if ( $('#relacionados .artigo').length < 1 ) {
            $('#relacionados').css('padding', 0);
            $('#relacionados').css('margin', 0);
        }
        
        //FIXED MENU ON SCROOL
        $(window).on( 'scroll', function(){
            scrolled = $('body').scrollTop();

            if ($(window).outerWidth() > 940) {
                if (scrolled >= 145) {
                    $('.fixed_menu').fadeIn(600);
                } else {
                    $('.fixed_menu').fadeOut(600);
                }
            
                if ( $('body.single').length > 0 ) {
                    if ( scrolled >= $('#artigos').position().top + 90 && scrolled + ( $('.author').outerHeight() ) <= $('#relacionados').position().top - 110 ) {
                        $('#sidebar .author').css('position','fixed');
                        $('#sidebar .author').css('top','30px');
                    } else if ( scrolled + $('.author').outerHeight() > $('#relacionados').position().top - 120 ) {
                        $('#sidebar .author').css('position','absolute');
                        $('#sidebar .author').css('top',($('#relacionados').position().top - $('#artigos').position().top - $('.author').outerHeight() - 80)+'px');
                    } else {
                        $('#sidebar .author').removeAttr('style');
                    }
                }
                
            } else {
                removeImageDimensions();
            }
            
            if ($('#socials:visible').length > 0) {
                if ( scrolled >= 10 ) {
                    
                    //TWITTER
                    if (ajax === true) {

                        ajax = false;
                        if ( $('#fb-root') ) {
                            var e = document.createElement('script'); e.async = true;
                            e.src = document.location.protocol + '//connect.facebook.net/pt_BR/all.js';
                            document.getElementById('fb-root').appendChild(e);

                            window.fbAsyncInit = function() {
                                FB.init({
                                    appId: '241686319233509',
                                    status: true,
                                    cookie: true,
                                    oauth : true
                                });

                                FB.api('/voudemarisa/posts?fields=id,message,picture,link&limit=3&access_token=CAADbzZCs0eeUBADCyq7ZBHy3s2d9rdZAqR4gEB94sLnF6FFoI7ebPFGyqgo6HW1YZArag5XjQL3nTNInKkviIozS5ph7aynuuqd7NgzzdQs4fNZBgcS1bzZCo3RBxyVBzDZBD2drZBpqVED3n6h3O2OucaRRZAxj0hrcKGuSSK9f7PQobU5Dkk1gk2fUsFsawLZBgZD', function(response) {
                                    var html = '';
                                    $('.box_facebook_lis img').remove();
                                    $.each(response.data, function(idx, p) {
                                        if (p.message && p.message != undefined && p.picture.length > 0) {
                                            
                                            html = '';
                                            html += '<li><a title="' + p.message + '" href="' + p.link + '" target="_blank">';
                                            html += '<img src="' + p.picture + '">';
                                            html += '' + p.message + '</a></li>';
                                            $('.box_facebook_lis').append(html);
                                        }
                                    });
                                });

                            };
                        }
                        
                        
                        
                        $.ajax({
                            url: app.templateUrl+"/inc/tweets.php",
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
                            url: app.templateUrl+"/inc/instagram.php",
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
                            url: app.templateUrl+"/inc/gplus.php",
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
            
            //ADJUSTING MENU LI's WIDTH
            adjustMenu();
            adjustCarrossel();
            
        });
        
        //INITIAL LIGHTBOX ENGINE
        $('.closelightbox').on('click', function() { 
            closelightbox(); 
        });
        
        if( $('.film:visible').length > 0 ) {
            lightboxtimer = window.setTimeout(function(){ $('.closelightbox').click(); }, 6000);
        }
        
        $('.formnewuser').mouseenter(function(){
            clearTimeout(lightboxtimer);
        }).mouseleave(function(){
            lightboxtimer = window.setTimeout(function(){ $('.closelightbox').click(); }, 6000);
        });
        
        $('.menumobile').on('click', function(event){
            event.preventDefault();
            $('#header nav ul').slideToggle(300);
        });

        /* Only to logged users */
        if(window.app.userLoggedIn) {
            appendAdminOptions();
        }
        
        
    });
    
    

})();