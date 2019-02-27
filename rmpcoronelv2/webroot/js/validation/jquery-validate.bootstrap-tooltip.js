/*!
 * jQuery Validation Bootstrap Tooltip extention v0.9.0
 *
 * https://github.com/Thrilleratplay/jQuery-Validation-Bootstrap-tooltip
 *
 * Copyright 2015 Tom Hiller
 * Released under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */
(function($) {
  $.extend(true, $.validator, {
    prototype: {
      defaultShowErrors: function() {
        var _this = this;
        var bsVersion = $.fn.tooltip.Constructor.VERSION;

        // Try to determine Bootstrap major and minor versions
        if (bsVersion) {
          bsVersion = bsVersion.split('.');
          bsMajorVer = parseInt(bsVersion[0]);
          bsMinorVer = parseInt(bsVersion[1]);
        }

        $.each(this.errorList, function(index, value) {
          //If Bootstrap 3.3 or greater

          var elementToApply = value.element;
          if ($(value.element).is('select')) {
            elementToApply = $(value.element).parents('.form-group')
                                             .find('.select2-container');
          } else if ($(value.element).is('input[type="file"]')) {
            elementToApply = $(value.element).parents('.form-group')
                                             .find('input[type="text"]');
          }

          if (bsMajorVer === 3 && bsMinorVer >= 3) {
            var $currentElement = $(elementToApply);
            if ($currentElement.data('bs.tooltip') !== undefined) {
              $currentElement.data('bs.tooltip').options.title = value.message;
            } else {
              $currentElement.tooltip(_this.applyTooltipOptions(elementToApply, value.message));
            }

            $(elementToApply).removeClass(_this.settings.validClass)
                            .addClass(_this.settings.errorClass)
                            .tooltip('show');
          } else {
            $(elementToApply).removeClass(_this.settings.validClass)
                            .addClass(_this.settings.errorClass)
                            .tooltip(bsMajorVer === 4 ? 'dispose' : 'destroy')
                            .tooltip(_this.applyTooltipOptions(elementToApply, value.message))
                            .tooltip('show');
          }

          if (_this.settings.highlight) {
            _this.settings.highlight.call(_this, elementToApply, _this.settings.errorClass, _this.settings.validClass);
          }
        });

        $.each(_this.validElements(), function(index, value) {
          var elementToApply = value;
          if ($(value).is('select')) {
            elementToApply = $(value).parents('.form-group')
                                     .find('.select2-container');
          } else if ($(value).is('input[type="file"]')) {
            elementToApply = $(value).parents('.form-group')
                                     .find('input[type="text"]');
          }

          $(elementToApply).removeClass(_this.settings.errorClass)
          .addClass(_this.settings.validClass)
          .tooltip(bsMajorVer === 4 ? 'dispose' : 'destroy');

          if (_this.settings.unhighlight) {
            _this.settings.unhighlight.call(_this, elementToApply, _this.settings.errorClass, _this.settings.validClass);
          }
        });
      },

      applyTooltipOptions: function(element, message) {
        var defaults;

        if (bsMajorVer === 4) {
          defaults = $.fn.tooltip.Constructor.Default;
        } else if (bsMajorVer === 3) {
          defaults = $.fn.tooltip.Constructor.DEFAULTS;
        } else {
          // Assuming BS version 2
          defaults = $.fn.tooltip.defaults;
        }

        var options = {
          /* Using Twitter Bootstrap Defaults if no settings are given */
          animation: $(element).data('animation') || defaults.animation,
          html: $(element).data('html') || defaults.html,
          placement: $(element).data('placement') || defaults.placement,
          selector: $(element).data('selector') || defaults.selector,
          title: $(element).attr('title') || message,
          trigger: $.trim('manual ' + ($(element).data('trigger') || '')),
          delay: $(element).data('delay') || defaults.delay,
          container: $(element).data('container') || defaults.container,
        };

        if (this.settings.tooltip_options && this.settings.tooltip_options[element.name]) {
          $.extend(options, this.settings.tooltip_options[element.name]);
        }
        /* jshint ignore:start */
        if (this.settings.tooltip_options && this.settings.tooltip_options['_all_']) {
          $.extend(options, this.settings.tooltip_options['_all_']);
        }
        /* jshint ignore:end */
        return options;
      }
    }
  });
}(jQuery));
