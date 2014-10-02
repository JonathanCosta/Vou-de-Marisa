(function(window, $) {

    // Helper funcions
    var getRelativeLeft = function(w, imW) {
        return w * 100 / imW;
    };

    var getRelativeTop = function(h, imH) {
        return h * 100 / imH;
    };

    var getAbsoluteLeft = function(w, imW) {
        return w * imW / 100;
    };

    var getAbsoluteTop = function(h, imH) {
        return h * imH / 100;
    };

    var flashMessage = function(el) {
        el.slideDown(200).delay(1500).slideUp(400);
    };

    /* Constructor */
    var ImageMarker = function(img, editor) {
        this.adminTitle = 'Gerenciador de etiquetas';
        this.$image = $(img);
        this.editor = editor;
        this.markers = [];
        //addFixtures(this.$image);
    };

    _.extend(ImageMarker.prototype, {

        // Fetch Markers from image
        fetchMarkers: function() {
            var c = 0;
            while(this.$image.data('marker-name-' + c)) {
                this.addMarker(c);
                c += 1;
            }
        },

        // Return boolean
        isMarked: function() {
            this.$image.hasClass('image-marker');
        },

        manageMarkers: function() {
            if($('#marker-manager-modal').length) {
                $('#marker-manager-modal').detach();
            }
            this.appendModalTemplate();
            this.onNextTick(function() {
                tb_show(this.adminTitle, '#TB_inline?width=600&height=550&inlineId=marker-manager-modal');

                this.onNextTick(function() {
                    this.parseManager();
                });
            });
        },

        getMarkerModalContent: function() {

            var content = $('<div id="marker-manager-wrapper"></div>'),
                formWrapper = '<div class="marker-form-wrapper">' +
                        '<button id="new-marker" class="add">+ Nova Etiqueta</button>' +
                        '<span id="success-message">Etiqueta salva</span>' +
                        '<div id="marker-form" class="marker-form">' +
                           '<input type="text" id="marker-form-name" placeholder="Título">' +
                           '<input type="text" id="marker-form-url" placeholder="http://">' +
                           '<button id="save-marker" class="save">Salvar</button>' +
                           '<button id="remove-marker" class="remove">Apagar</button>' +
                       '</div></div>',
                imageWrapper = '<div class="image-wrapper"><div id="image-canvas"><img src="' + this.$image.attr('src') + '"></div></div>';

            return content.append(formWrapper, imageWrapper);

        },

        appendModalTemplate: function() {
            $('body').append($('<div id="marker-manager-modal"></div>').append(this.getMarkerModalContent()));
        },

        parseManager: function() {
            this.$addBtn = $('#new-marker');
            this.$saveBtn = $('#save-marker');
            this.$deleteBtn = $('#remove-marker');
            this.$form = $('#marker-form');
            this.$fields = $('#marker-form-name, #marker-form-url');
            this.$fieldName = $('#marker-form-name');
            this.$fieldUrl = $('#marker-form-url');
            this.$canvasWrapper = $('.image-wrapper');
            this.$canvas = $('#image-canvas');
            this.$canvasImg = $('#image-canvas img');
            this.$successMsg = $('#success-message');

            this.imageWidth = this.$canvasImg.width();
            this.imageHeight = this.$canvasImg.height();

            this.$canvas.css({
                width: this.imageWidth,
                height: this.imageHeight
            });

            // Read and render old Markers
            this.fetchMarkers();

            this.bindEvents();
        },

        bindEvents: function() {
            var self = this;
            this.$addBtn.on('click', function(e) { self.addMarker(); });
            this.$deleteBtn.on('click', function(e) {
                if(!self.selectedMarker) return;
                self.removeMarker(self.selectedMarker);
            });
            this.$fields.on('input', function() { self.updateFields(); });
            this.$saveBtn.on('click', function() { self.saveMarker(); });
            this.$canvasWrapper.on('click', function(e) { self.deselectMarker(); });
        },

        bindMarkerEvents: function(marker) {
            var self = this, $marker = marker.$marker;
            $marker.on('click', function(e) { e.stopPropagation(); self.selectMarker(marker); });
            $marker.drags({
                boundaries: true,
                onRelease: function(pos) {
                    self.updatePosition(pos, marker);
                }
            });
        },

        addMarker: function(index) {
            var marker, $marker, isNewMarker = index === undefined;
            // If it is a new marker, fill it with default props
            if(isNewMarker) {
                index = this.markers.length;
                marker = {
                    name: '',
                    url: '',
                    top: this.imageHeight / 2,
                    left: this.imageWidth / 2,
                };
            // If not, just add the marker
            } else {
                marker = {
                    name: this.$image.data('marker-name-' + index),
                    url: this.$image.data('marker-url-' + index),
                    top: getAbsoluteTop(this.$image.data('marker-top-' + index), this.imageHeight),
                    left: getAbsoluteLeft(this.$image.data('marker-left-' + index), this.imageWidth)
                };
            }

            _.extend(marker, {
                id: _.uniqueId()
            });

            // Binds "this" on this event callbacks to the object itself
            //_.bindAll(buttonView, 'onClick');

            this.markers.push(marker);
            this.$canvas.append('<span data-id="' + marker.id + '" class="marker"></span>');

            this.onNextTick(function() {
                $marker = this.$canvas.find('[data-id=' + marker.id + ']');
                $marker.css({ top: marker.top, left: marker.left });
                marker.$marker = $marker;
                this.bindMarkerEvents(marker);

                // new markers are selected by default
                if(isNewMarker) this.selectMarker(marker);
            });
        },

        removeMarker: function(marker) {
            marker.$marker.detach();
            // Removing from array
            _.find(this.markers, function(obj, idx) {
                if(obj.id == marker.id) {
                    this.markers.splice(idx, 1);
                    return true;
                }
            }, this);

            this.dataRebind();
            this.deselectMarker();
        },

        saveMarker: function() {
            this.dataRebind();
            flashMessage(this.$successMsg);
            this.deselectMarker();
        },

        selectMarker: function(marker) {
            if(this.selectedMarker && this.selectedMarker.id == marker.id) return;
            this.selectedMarker = marker;

            this.$canvas.find('.marker').removeClass('selected');
            marker.$marker.addClass('selected');
            this.openEditor(marker);
        },

        deselectMarker: function() {
            this.selectedMarker = null;
            this.$canvas.find('.marker').removeClass('selected');
            this.closeEditor();
        },

        openEditor: function() {
            this.$fieldName.val(this.selectedMarker.name);
            this.$fieldUrl.val(this.selectedMarker.url);
            this.$addBtn.fadeOut(200);
            this.$form.fadeIn(200);
        },

        closeEditor: function() {
            this.$fieldName.val('');
            this.$fieldUrl.val('');
            this.$addBtn.fadeIn(200);
            this.$form.fadeOut(200);
        },

        updateFields: function() {
            if(!this.selectedMarker) return;
            this.selectedMarker.name = this.$fieldName.val();
            this.selectedMarker.url = this.$fieldUrl.val();
        },

        updatePosition: function(pos, marker) {
            marker = marker || this.selectedMarker;
            marker.top = pos.top;
            marker.left = pos.left;
        },

        dataRebind: function() {
            var c = 0, attr, attrs, attrTypes = ['name', 'url', 'top', 'left'];

            // Removing old data from element
            while(this.$image.data('marker-name-' + c)) {
                _.each(attrTypes, function(attr) {
                    attr = 'marker-' + attr + '-' + c;
                    this.$image.removeData(attr);
                    // TinyMCE content
                    this.editor.dom.setAttrib(this.$image, 'data-' + attr, '0');
                }, this);
                c++;
            };
            
            // Adding updated data to element
            _.each(this.markers, function(marker, i) {

                attrs = {};
                attrs['data-marker-name-' + i] = marker.name;
                attrs['data-marker-url-' + i]  = marker.url;
                attrs['data-marker-top-' + i]  = getRelativeTop(marker.top, this.imageHeight);
                attrs['data-marker-left-' + i] = getRelativeLeft(marker.left, this.imageWidth);

                _.each(attrs, function(val, key) {
                    this.$image.attr(key, val);
                }, this);

                // TinyMCE content
                this.editor.dom.setAttribs(this.$image, attrs);

                this.editor.nodeChanged();
                
            }, this);
        },

        /* HELPERS */ 
        onNextTick: function(cb) {
            var self = this;
            window.setTimeout(function() {
                cb.call(self);
            }, 0);
        },

    });

    /* Front end parsing */
    ImageMarker.format = function() {

        var markedImages = $('img[data-marker-name-0]');
        markedImages.each(function() {
            var $img = $(this), $wrapper = $(this).parent(), c = 0, 
                width = $img.width(), height = $img.height(),
                marker, name, url, top, left;
            $wrapper.css({
                display: 'inline-block',
                position: 'relative',
                width: width,
                height: height
            }).addClass('image-marker');

            while($img.data('marker-name-' + c)) {
                name = $img.data('marker-name-' + c);
                url  = $img.data('marker-url-' + c);
                top  = getAbsoluteTop($img.data('marker-top-' + c), height);
                left = getAbsoluteLeft($img.data('marker-left-' + c), width);               
                marker = '<a target="_blank" class="marker" title="' + name + '" href="' + url + '" ' +
                         'style="top: ' + top + 'px; left:' + left + 'px"></a>';
                $wrapper.append(marker);
                c += 1;
            }            
        });
    };

    window.ImageMarker = ImageMarker;

})(window, jQuery);


/* Draggable plugin */
(function($) {
    $.fn.drags = function(opt) {

        opt = $.extend( {
            handle: '',
            cursor: 'move',
            onRelease: function() {}
        }, opt);

        var $el = opt.handle === '' ? this : this.find(opt.handle);

        function updatePosition(event, info, parentInfo) {
            var pos = {
                top: event.pageY + info.y,
                left: event.pageX + info.x
            };
            if(opt.boundaries) {
                if(pos.top < parentInfo.top) pos.top = parentInfo.top;
                if(pos.top > parentInfo.bottom) pos.top = parentInfo.bottom;
                if(pos.left < parentInfo.left) pos.left = parentInfo.left;
                if(pos.left > parentInfo.right) pos.left = parentInfo.right;                
            }
            return pos;
        }

        return $el.css('cursor', opt.cursor).on('mousedown', function(e) {

            if(opt.handle === '') {
                var $drag = $(this).addClass('draggable');
            } else {
                var $drag = $(this).addClass('active-handle').parent().addClass('draggable');
            }

            var z_idx = $drag.css('z-index'),
                info = {
                    h: $drag.outerHeight(),
                    w: $drag.outerWidth(),
                    y: $drag.offset().top - e.pageY,
                    x: $drag.offset().left - e.pageX
                },
                $parent = $drag.parent(),
                parentInfo,
                pos;
                if(opt.boundaries) {
                    parentInfo = {
                        h: $parent.outerHeight(),
                        w: $parent.outerWidth(),
                        top: $parent.offset().top,
                        left: $parent.offset().left,
                        bottom: $parent.outerHeight() + $parent.offset().top - info.h,
                        right: $parent.outerWidth() + $parent.offset().left - info.w,
                    }
                }

            $drag.css('z-index', 1000).parents().on('mousemove', function(e) {

                pos = updatePosition(e, info, parentInfo);

                $('.draggable').offset({
                    top: pos.top,
                    left: pos.left
                }).on('mouseup', function() {
                    $(this).removeClass('draggable').css('z-index', z_idx);
                });
            });
            e.preventDefault(); // disable selection
        }).on('mouseup', function() {
            var el = $(this);
            if(opt.handle === '') {
                el.removeClass('draggable');
            } else {
                el.removeClass('active-handle').parent().removeClass('draggable');
            }
            opt.onRelease.call(el, el.position());
        });

    };
})(jQuery);