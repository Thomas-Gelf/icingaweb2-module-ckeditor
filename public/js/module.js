(function(window, $) {

    'use strict';

    var onRenderedContainer = function (event) {
        if (typeof CKEDITOR === 'undefined' || ! CKEDITOR.config.jqueryOverrideVal) {
            return;
        }
        // remove any instance that's no longer in the dom
        $.each(CKEDITOR.instances, function (idx, instance) {
            var $ref = instance.element.$;
            if ($(document.documentElement).find($ref).length === 0) {
                instance.destroy();
            }
        });

        // create new instances
        $(event.currentTarget).find('.editinline').ckeditor();
    };

    var lazyLoadVendorJs = function (icinga) {
        var webUrl = icinga.config.baseUrl.replace(/\/$/, '');
        var ckUrl = webUrl + '/ckeditor/vendor/';
        window.CKEDITOR_BASEPATH = ckUrl;
        $.getScript(ckUrl + '/ckeditor.js').done(function () {
            icinga.logger.info('CKEditor has been loaded');
            $.getScript(ckUrl + '/adapters/jquery.js').done(function () {
                $('.editinline').ckeditor();
            });
            // CKEDITOR.config.defaultLanguage = 'de';
        }).fail(function () {
            icinga.logger.info('Failed to load CKEditor');
        });
        $('#col1').on('rendered', onRenderedContainer);
        $('#col2').on('rendered', onRenderedContainer);
    };

    $(document).ready(function () {
        var icinga = window.icinga;
        lazyLoadVendorJs(icinga);
    });

})(window, jQuery);
