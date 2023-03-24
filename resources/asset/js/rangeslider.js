/*! rangeslider.js - v2.3.0 | (c) 2016 @andreruffert | MIT license | https://github.com/andreruffert/rangeslider.js */



(function(factory) {
    'use strict';

    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }}

(function($) {
    'use strict';

    // Polyfill Number.isNaN(value)
    // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isNaN
    Number.isNaN = Number.isNaN || function(value) {
        return typeof value === 'number' && value !== value;
    };

    /**
     * Range feature detection
     * @return {Boolean}
     */
    function supportsRange() {
        var input = document.createElement('input');
        input.setAttribute('type', 'range');
        return input.type !== 'text';
    }

    var pluginName = 'rangeslider',
        pluginIdentifier = 0,
        hasInputRangeSupport = supportsRange(),
        defaults = {
            polyfill: true,
            orientation: 'horizontal',
            isRTL: true,
            rangeClass: 'rangeslider',
            disabledClass: 'rangeslider--disabled',
            activeClass: 'rangeslider--active',
            horizontalClass: 'rangeslider--horizontal',
            verticalClass: 'rangeslider--vertical',
            fillClass: 'rangeslider__fill',
            handleClass: 'rangeslider__handle',
            startEvent: ['mousedown', 'touchstart', 'pointerdown'],
            moveEvent: ['mousemove', 'touchmove', 'pointermove'],
            endEvent: ['mouseup', 'touchend', 'pointerup']
        },
        constants = {
            orientation: {
                horizontal: {
                    dimension: 'width',
                    direction: 'left',
                    directionStyle: 'left',
                    coordinate: 'x'
                },
                vertical: {
                    dimension: 'height',
                    direction: 'top',
                    directionStyle: 'bottom',
                    coordinate: 'y'
                }
            }
        };

    /**
     * Delays a function for the given number of milliseconds, and then calls
     * it with the arguments supplied.
     *
     * @param  {Function} fn   [description]
     * @param  {Number}   wait [description]
     * @return {Function}
     */
    function delay(fn, wait) {
        var args = Array.prototype.slice.call(arguments, 2);
        return setTimeout(function(){ return fn.apply(null, args); }, wait);
    }

    /**
     * Returns a debounced function that will make sure the given
     * function is not triggered too much.
     *
     * @param  {Function} fn Function to debounce.
     * @param  {Number}   debounceDuration OPTIONAL. The amount of time in milliseconds for which we will debounce the function. (defaults to 100ms)
     * @return {Function}
     */
    function debounce(fn, debounceDuration) {
        debounceDuration = debounceDuration || 100;
        return function() {
            if (!fn.debouncing) {
                var args = Array.prototype.slice.apply(arguments);
                fn.lastReturnVal = fn.apply(window, args);
                fn.debouncing = true;
            }
            clearTimeout(fn.debounceTimeout);
            fn.debounceTimeout = setTimeout(function(){
                fn.debouncing = false;
            }, debounceDuration);
            return fn.lastReturnVal;
        };
    }

    /**
     * Check if a `element` is visible in the DOM
     *
     * @param  {Element}  element
     * @return {Boolean}
     */
    function isHidden(element) {
        return (
            element && (
                element.offsetWidth === 0 ||
                element.offsetHeight === 0 ||
                // Also Consider native `<details>` elements.
                element.open === false
            )
        );
    }

    /**
     * Get hidden parentNodes of an `element`
     *
     * @param  {Element} element
     * @return {[type]}
     */
    function getHiddenParentNodes(element) {
        var parents = [],
            node    = element.parentNode;

        while (isHidden(node)) {
            parents.push(node);
            node = node.parentNode;
        }
        return parents;
    }

    /**
     * Returns dimensions for an element even if it is not visible in the DOM.
     *
     * @param  {Element} element
     * @param  {String}  key     (e.g. offsetWidth …)
     * @return {Number}
     */
    function getDimension(element, key) {
        var hiddenParentNodes       = getHiddenParentNodes(element),
            hiddenParentNodesLength = hiddenParentNodes.length,
            inlineStyle             = [],
            dimension               = element[key];

        // Used for native `<details>` elements
        function toggleOpenProperty(element) {
            if (typeof element.open !== 'undefined') {
                element.open = (element.open) ? false : true;
            }
        }

        if (hiddenParentNodesLength) {
            for (var i = 0; i < hiddenParentNodesLength; i++) {

                // Cache style attribute to restore it later.
                inlineStyle[i] = hiddenParentNodes[i].style.cssText;

                // visually hide
                if (hiddenParentNodes[i].style.setProperty) {
                    hiddenParentNodes[i].style.setProperty('display', 'block', 'important');
                } else {
                    hiddenParentNodes[i].style.cssText += ';display: block !important';
                }
                hiddenParentNodes[i].style.height = '0';
                hiddenParentNodes[i].style.overflow = 'hidden';
                hiddenParentNodes[i].style.visibility = 'hidden';
                toggleOpenProperty(hiddenParentNodes[i]);
            }

            // Update dimension
            dimension = element[key];

            for (var j = 0; j < hiddenParentNodesLength; j++) {

                // Restore the style attribute
                hiddenParentNodes[j].style.cssText = inlineStyle[j];
                toggleOpenProperty(hiddenParentNodes[j]);
            }
        }
        return dimension;
    }

    /**
     * Returns the parsed float or the default if it failed.
     *
     * @param  {String}  str
     * @param  {Number}  defaultValue
     * @return {Number}
     */
    function tryParseFloat(str, defaultValue) {
        var value = parseFloat(str);
        return Number.isNaN(value) ? defaultValue : value;
    }

    /**
     * Capitalize the first letter of string
     *
     * @param  {String} str
     * @return {String}
     */
    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.substr(1);
    }

    /**
     * Plugin
     * @param {String} element
     * @param {Object} options
     */
    function Plugin(element, options) {
        this.$window            = $(window);
        this.$document          = $(document);
        this.$element           = $(element);
        this.options            = $.extend( {}, defaults, options );
        this.polyfill           = this.options.polyfill;
        this.orientation        = this.$element[0].getAttribute('data-orientation') || this.options.orientation;
        this.onInit             = this.options.onInit;
        this.onSlide            = this.options.onSlide;
        this.onSlideEnd         = this.options.onSlideEnd;
        this.DIMENSION          = constants.orientation[this.orientation].dimension;
        this.DIRECTION          = constants.orientation[this.orientation].direction;
        this.DIRECTION_STYLE    = constants.orientation[this.orientation].directionStyle;
        this.COORDINATE         = constants.orientation[this.orientation].coordinate;

        // Plugin should only be used as a polyfill
        if (this.polyfill) {
            // Input range support?
            if (hasInputRangeSupport) { return false; }
        }

        this.identifier = 'js-' + pluginName + '-' +(pluginIdentifier++);
        this.startEvent = this.options.startEvent.join('.' + this.identifier + ' ') + '.' + this.identifier;
        this.moveEvent  = this.options.moveEvent.join('.' + this.identifier + ' ') + '.' + this.identifier;
        this.endEvent   = this.options.endEvent.join('.' + this.identifier + ' ') + '.' + this.identifier;
        this.toFixed    = (this.step + '').replace('.', '').length - 1;
        this.$fill      = $('<div class="' + this.options.fillClass + '" />');
        this.$handle    = $('<div class="' + this.options.handleClass + '" />');
        this.$range     = $('<div class="' + this.options.rangeClass + ' ' + this.options[this.orientation + 'Class'] + '" id="' + this.identifier + '" />').insertAfter(this.$element).prepend(this.$fill, this.$handle);

        // visually hide the input
        this.$element.css({
            'position': 'absolute',
            'width': '1px',
            'height': '1px',
            'overflow': 'hidden',
            'opacity': '0'
        });

        // Store context
        this.handleDown = $.proxy(this.handleDown, this);
        this.handleMove = $.proxy(this.handleMove, this);
        this.handleEnd  = $.proxy(this.handleEnd, this);

        this.init();

        // Attach Events
        var _this = this;
        this.$window.on('resize.' + this.identifier, debounce(function() {
            // Simulate resizeEnd event.
            delay(function() { _this.update(false, false); }, 300);
        }, 20));

        this.$document.on(this.startEvent, '#' + this.identifier + ':not(.' + this.options.disabledClass + ')', this.handleDown);

        // Listen to programmatic value changes
        this.$element.on('change.' + this.identifier, function(e, data) {
            if (data && data.origin === _this.identifier) {
                return;
            }

            var value = e.target.value,
                pos = _this.getPositionFromValue(value);
            _this.setPosition(pos);
        });
    }

    Plugin.prototype.init = function() {
        this.update(true, false);

        if (this.onInit && typeof this.onInit === 'function') {
            this.onInit();
        }
    };

    Plugin.prototype.update = function(updateAttributes, triggerSlide) {
        updateAttributes = updateAttributes || false;

        if (updateAttributes) {
            this.min    = tryParseFloat(this.$element[0].getAttribute('min'), 0);
            this.max    = tryParseFloat(this.$element[0].getAttribute('max'), 100);
            this.value  = tryParseFloat(this.$element[0].value, Math.round(this.min + (this.max-this.min)/2));
            this.step   = tryParseFloat(this.$element[0].getAttribute('step'), 1);
        }

        this.handleDimension    = getDimension(this.$handle[0], 'offset' + ucfirst(this.DIMENSION));
        this.rangeDimension     = getDimension(this.$range[0], 'offset' + ucfirst(this.DIMENSION));
        this.maxHandlePos       = this.rangeDimension - this.handleDimension;
        this.grabPos            = this.handleDimension / 2;
        this.position           = this.getPositionFromValue(this.value);

        // Consider disabled state
        if (this.$element[0].disabled) {
            this.$range.addClass(this.options.disabledClass);
        } else {
            this.$range.removeClass(this.options.disabledClass);
        }

        this.setPosition(this.position, triggerSlide);
    };

    Plugin.prototype.handleDown = function(e) {
        e.preventDefault();
        this.$document.on(this.moveEvent, this.handleMove);
        this.$document.on(this.endEvent, this.handleEnd);

        // add active class because Firefox is ignoring
        // the handle:active pseudo selector because of `e.preventDefault();`
        this.$range.addClass(this.options.activeClass);

        // If we click on the handle don't set the new position
        if ((' ' + e.target.className + ' ').replace(/[\n\t]/g, ' ').indexOf(this.options.handleClass) > -1) {
            return;
        }

        var pos         = this.getRelativePosition(e),
            rangePos    = this.$range[0].getBoundingClientRect()[this.DIRECTION],
            handlePos   = this.getPositionFromNode(this.$handle[0]) - rangePos,
            setPos      = (this.orientation === 'vertical') ? (this.maxHandlePos - (pos - this.grabPos)) : (pos - this.grabPos);

        this.setPosition(setPos);

        if (pos >= handlePos && pos < handlePos + this.handleDimension) {
            this.grabPos = pos - handlePos;
        }
    };

    Plugin.prototype.handleMove = function(e) {
        e.preventDefault();
        var pos = this.getRelativePosition(e);
        var setPos = (this.orientation === 'vertical') ? (this.maxHandlePos - (pos - this.grabPos)) : (pos - this.grabPos);
        this.setPosition(setPos);
    };

    Plugin.prototype.handleEnd = function(e) {
        e.preventDefault();
        this.$document.off(this.moveEvent, this.handleMove);
        this.$document.off(this.endEvent, this.handleEnd);

        this.$range.removeClass(this.options.activeClass);

        // Ok we're done fire the change event
        this.$element.trigger('change', { origin: this.identifier });

        if (this.onSlideEnd && typeof this.onSlideEnd === 'function') {
            this.onSlideEnd(this.position, this.value);
        }
    };

    Plugin.prototype.cap = function(pos, min, max) {
        if (pos < min) { return min; }
        if (pos > max) { return max; }
        return pos;
    };

    Plugin.prototype.setPosition = function(pos, triggerSlide) {
        var value, newPos;

        if (triggerSlide === undefined) {
            triggerSlide = true;
        }

        // Snapping steps
        value = this.getValueFromPosition(this.cap(pos, 0, this.maxHandlePos));
        newPos = this.getPositionFromValue(value);

        // Update ui
        this.$fill[0].style[this.DIMENSION] = (newPos + this.grabPos) + 'px';
        this.$handle[0].style[this.DIRECTION_STYLE] = newPos + 'px';
        this.setValue(value);

        // Update globals
        this.position = newPos;
        this.value = value;

        if (triggerSlide && this.onSlide && typeof this.onSlide === 'function') {
            this.onSlide(newPos, value);
        }
    };

    // Returns element position relative to the parent
    Plugin.prototype.getPositionFromNode = function(node) {
        var i = 0;
        while (node !== null) {
            i += node.offsetLeft;
            node = node.offsetParent;
        }
        return i;
    };

    Plugin.prototype.getRelativePosition = function(e) {
        // Get the offset DIRECTION relative to the viewport
        var ucCoordinate = ucfirst(this.COORDINATE),
            rangePos = this.$range[0].getBoundingClientRect()[this.DIRECTION],
            pageCoordinate = 0;

        if (typeof e.originalEvent['client' + ucCoordinate] !== 'undefined') {
            pageCoordinate = e.originalEvent['client' + ucCoordinate];
        }
        else if (
          e.originalEvent.touches &&
          e.originalEvent.touches[0] &&
          typeof e.originalEvent.touches[0]['client' + ucCoordinate] !== 'undefined'
        ) {
            pageCoordinate = e.originalEvent.touches[0]['client' + ucCoordinate];
        }
        else if(e.currentPoint && typeof e.currentPoint[this.COORDINATE] !== 'undefined') {
            pageCoordinate = e.currentPoint[this.COORDINATE];
        }

        return pageCoordinate - rangePos;
    };

    Plugin.prototype.getPositionFromValue = function(value) {
        var percentage, pos;
        percentage = (value - this.min)/(this.max - this.min);
        pos = (!Number.isNaN(percentage)) ? percentage * this.maxHandlePos : 0;
        return pos;
    };

    Plugin.prototype.getValueFromPosition = function(pos) {
        var percentage, value;
        percentage = ((pos) / (this.maxHandlePos || 1));
        value = this.step * Math.round(percentage * (this.max - this.min) / this.step) + this.min;
        return Number((value).toFixed(this.toFixed));
    };

    Plugin.prototype.setValue = function(value) {
        if (value === this.value && this.$element[0].value !== '') {
            return;
        }

        // Set the new value and fire the `input` event
        this.$element
            .val(value)
            .trigger('input', { origin: this.identifier });
    };

    Plugin.prototype.destroy = function() {
        this.$document.off('.' + this.identifier);
        this.$window.off('.' + this.identifier);

        this.$element
            .off('.' + this.identifier)
            .removeAttr('style')
            .removeData('plugin_' + pluginName);

        // Remove the generated markup
        if (this.$range && this.$range.length) {
            this.$range[0].parentNode.removeChild(this.$range[0]);
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function(options) {
        var args = Array.prototype.slice.call(arguments, 1);

        return this.each(function() {
            var $this = $(this),
                data  = $this.data('plugin_' + pluginName);

            // Create a new instance.
            if (!data) {
                $this.data('plugin_' + pluginName, (data = new Plugin(this, options)));
            }

            // Make it possible to access methods from public.
            // e.g `$element.rangeslider('method');`
            if (typeof options === 'string') {
                data[options].apply(data, args);
            }
        });
    };

    return 'rangeslider.js is available in jQuery context e.g $(selector).rangeslider(options);';

}));

!(function (t) {
    "use strict";
    "function" == typeof define && define.amd
      ? define(["jquery"], t)
      : "object" == typeof exports
      ? (module.exports = t(require("jquery")))
      : t(jQuery);
  })(function (o) {
    "use strict";
    Number.isNaN =
      Number.isNaN ||
      function (t) {
        return "number" == typeof t && t != t;
      };
    var t,
      r = "rangeslider",
      h = 0,
      a =
        ((t = document.createElement("input")).setAttribute("type", "range"),
        "text" !== t.type),
      l = {
        polyfill: !0,
        orientation: "horizontal",
        isRTL: true,
        rangeClass: "rangeslider",
        disabledClass: "rangeslider--disabled",
        activeClass: "rangeslider--active",
        horizontalClass: "rangeslider--horizontal",
        verticalClass: "rangeslider--vertical",
        fillClass: "rangeslider__fill",
        handleClass: "rangeslider__handle",
        startEvent: ["mousedown", "touchstart", "pointerdown"],
        moveEvent: ["mousemove", "touchmove", "pointermove"],
        endEvent: ["mouseup", "touchend", "pointerup"],
      },
      d = {
        orientation: {
          horizontal: {
            dimension: "width",
            direction: "left",
            directionStyle: "left",
            coordinate: "x",
          },
          vertical: {
            dimension: "height",
            direction: "top",
            directionStyle: "bottom",
            coordinate: "y",
          },
        },
      };
    function e(t, i) {
      var e = (function (t) {
          for (
            var i, e = [], n = t.parentNode;
            (i = n) &&
            (0 === i.offsetWidth || 0 === i.offsetHeight || !1 === i.open);
  
          )
            e.push(n), (n = n.parentNode);
          return e;
        })(t),
        n = e.length,
        s = [],
        o = t[i];
      function r(t) {
        void 0 !== t.open && (t.open = !t.open);
      }
      if (n) {
        for (var h = 0; h < n; h++)
          (s[h] = e[h].style.cssText),
            e[h].style.setProperty
              ? e[h].style.setProperty("display", "block", "important")
              : (e[h].style.cssText += ";display: block !important"),
            (e[h].style.height = "0"),
            (e[h].style.overflow = "hidden"),
            (e[h].style.visibility = "hidden"),
            r(e[h]);
        o = t[i];
        for (var a = 0; a < n; a++) (e[a].style.cssText = s[a]), r(e[a]);
      }
      return o;
    }
    function n(t, i) {
      var e = parseFloat(t);
      return Number.isNaN(e) ? i : e;
    }
    function s(t) {
      return t.charAt(0).toUpperCase() + t.substr(1);
    }
    function u(t, i) {
      if (
        ((this.$window = o(window)),
        (this.$document = o(document)),
        (this.$element = o(t)),
        (this.options = o.extend({}, l, i)),
        (this.polyfill = this.options.polyfill),
        (this.orientation =
          this.$element[0].getAttribute("data-orientation") ||
          this.options.orientation),
        (this.onInit = this.options.onInit),
        (this.onSlide = this.options.onSlide),
        (this.onSlideEnd = this.options.onSlideEnd),
        (this.DIMENSION = d.orientation[this.orientation].dimension),
        (this.DIRECTION = this.options.isRTL ? "right" : "left"),
        (this.DIRECTION_STYLE = this.options.isRTL ? "right" : "left"),
        (this.COORDINATE = d.orientation[this.orientation].coordinate),
        this.polyfill && a)
      )
        return !1;
      (this.identifier = "js-" + r + "-" + h++),
        (this.startEvent =
          this.options.startEvent.join("." + this.identifier + " ") +
          "." +
          this.identifier),
        (this.moveEvent =
          this.options.moveEvent.join("." + this.identifier + " ") +
          "." +
          this.identifier),
        (this.endEvent =
          this.options.endEvent.join("." + this.identifier + " ") +
          "." +
          this.identifier),
        (this.toFixed = (this.step + "").replace(".", "").length - 1),
        (this.$fill = o('<div class="' + this.options.fillClass + '" />')),
        (this.$handle = o('<div class="' + this.options.handleClass + '" />')),
        (this.$range = o(
          '<div class="' +
            this.options.rangeClass +
            (this.options.isRTL ? " rangeslider-rtl " : "") +
            " " +
            this.options[this.orientation + "Class"] +
            '" id="' +
            this.identifier +
            '" />'
        )
          .insertAfter(this.$element)
          .prepend(this.$fill, this.$handle)),
        this.$element.css({
          position: "absolute",
          width: "1px",
          height: "1px",
          overflow: "hidden",
          opacity: "0",
        }),
        (this.handleDown = o.proxy(this.handleDown, this)),
        (this.handleMove = o.proxy(this.handleMove, this)),
        (this.handleEnd = o.proxy(this.handleEnd, this)),
        this.init();
      var e,
        n,
        s = this;
      this.$window.on(
        "resize." + this.identifier,
        ((e = function () {
          !(function (t, i) {
            var e = Array.prototype.slice.call(arguments, 2);
            setTimeout(function () {
              return t.apply(null, e);
            }, i);
          })(function () {
            s.update(!1, !1);
          }, 300);
        }),
        (n = (n = 20) || 100),
        function () {
          if (!e.debouncing) {
            var t = Array.prototype.slice.apply(arguments);
            (e.lastReturnVal = e.apply(window, t)), (e.debouncing = !0);
          }
          return (
            clearTimeout(e.debounceTimeout),
            (e.debounceTimeout = setTimeout(function () {
              e.debouncing = !1;
            }, n)),
            e.lastReturnVal
          );
        })
      ),
        this.$document.on(
          this.startEvent,
          "#" + this.identifier + ":not(." + this.options.disabledClass + ")",
          this.handleDown
        ),
        this.$element.on("change." + this.identifier, function (t, i) {
          if (!i || i.origin !== s.identifier) {
            var e = t.target.value,
              n = s.getPositionFromValue(e);
            s.setPosition(n);
          }
        });
    }
    return (
      (u.prototype.init = function () {
        this.update(!0, !1),
          this.onInit && "function" == typeof this.onInit && this.onInit();
      }),
      (u.prototype.update = function (t, i) {
        (t = t || !1) &&
          ((this.min = n(this.$element[0].getAttribute("min"), 0)),
          (this.max = n(this.$element[0].getAttribute("max"), 100)),
          (this.value = n(
            this.$element[0].value,
            Math.round(this.min + (this.max - this.min) / 2)
          )),
          (this.step = n(this.$element[0].getAttribute("step"), 1))),
          (this.handleDimension = e(
            this.$handle[0],
            "offset" + s(this.DIMENSION)
          )),
          (this.rangeDimension = e(this.$range[0], "offset" + s(this.DIMENSION))),
          (this.maxHandlePos = this.rangeDimension - this.handleDimension),
          (this.grabPos = this.handleDimension / 2),
          (this.position = this.getPositionFromValue(this.value)),
          this.$element[0].disabled
            ? this.$range.addClass(this.options.disabledClass)
            : this.$range.removeClass(this.options.disabledClass),
          this.setPosition(this.position, i);
      }),
      (u.prototype.handleDown = function (t) {
        if (
          (t.preventDefault(),
          this.$document.on(this.moveEvent, this.handleMove),
          this.$document.on(this.endEvent, this.handleEnd),
          this.$range.addClass(this.options.activeClass),
          !(
            -1 <
            (" " + t.target.className + " ")
              .replace(/[\n\t]/g, " ")
              .indexOf(this.options.handleClass)
          ))
        ) {
          var i = this.getRelativePosition(t),
            e = this.$range[0].getBoundingClientRect()[this.DIRECTION],
            n = this.getPositionFromNode(this.$handle[0]) - e,
            s =
              "vertical" === this.orientation
                ? this.maxHandlePos - (i - this.grabPos)
                : i - this.grabPos;
          this.setPosition(s),
            n <= i && i < n + this.handleDimension && (this.grabPos = i - n);
        }
      }),
      (u.prototype.handleMove = function (t) {
        t.preventDefault();
        var i = this.getRelativePosition(t),
          e =
            "vertical" === this.orientation
              ? this.maxHandlePos - (i - this.grabPos)
              : i - this.grabPos;
        this.setPosition(e);
      }),
      (u.prototype.handleEnd = function (t) {
        t.preventDefault(),
          this.$document.off(this.moveEvent, this.handleMove),
          this.$document.off(this.endEvent, this.handleEnd),
          this.$range.removeClass(this.options.activeClass),
          this.$element.trigger("change", { origin: this.identifier }),
          this.onSlideEnd &&
            "function" == typeof this.onSlideEnd &&
            this.onSlideEnd(this.position, this.value);
      }),
      (u.prototype.cap = function (t, i, e) {
        return t < i ? i : e < t ? e : t;
      }),
      (u.prototype.setPosition = function (t, i) {
        var e, n;
        void 0 === i && (i = !0),
          (e = this.getValueFromPosition(this.cap(t, 0, this.maxHandlePos))),
          (n = this.getPositionFromValue(e)),
          (this.$fill[0].style[this.DIMENSION] = n + this.grabPos + "px"),
          (this.$handle[0].style[this.DIRECTION_STYLE] = n + "px"),
          this.setValue(e),
          (this.position = n),
          (this.value = e),
          i &&
            this.onSlide &&
            "function" == typeof this.onSlide &&
            this.onSlide(n, e);
      }),
      (u.prototype.getPositionFromNode = function (t) {
        for (var i = 0; null !== t; ) (i += t.offsetLeft), (t = t.offsetParent);
        return i;
      }),
      (u.prototype.getRelativePosition = function (t) {
        var i = s(this.COORDINATE),
          e = this.$range[0].getBoundingClientRect()[this.DIRECTION],
          n = 0;
        return (
          void 0 !== t.originalEvent["client" + i]
            ? (n = t.originalEvent["client" + i])
            : t.originalEvent.touches &&
              t.originalEvent.touches[0] &&
              void 0 !== t.originalEvent.touches[0]["client" + i]
            ? (n = t.originalEvent.touches[0]["client" + i])
            : t.currentPoint &&
              void 0 !== t.currentPoint[this.COORDINATE] &&
              (n = t.currentPoint[this.COORDINATE]),
          this.options.isRTL ? e - n : n - e
        );
      }),
      (u.prototype.getPositionFromValue = function (t) {
        var i;
        return (
          (i = (t - this.min) / (this.max - this.min)),
          Number.isNaN(i) ? 0 : i * this.maxHandlePos
        );
      }),
      (u.prototype.getValueFromPosition = function (t) {
        var i, e;
        return (
          (i = t / (this.maxHandlePos || 1)),
          (e =
            this.step * Math.round((i * (this.max - this.min)) / this.step) +
            this.min),
          Number(e.toFixed(this.toFixed))
        );
      }),
      (u.prototype.setValue = function (t) {
        (t === this.value && "" !== this.$element[0].value) ||
          this.$element.val(t).trigger("input", { origin: this.identifier });
      }),
      (u.prototype.destroy = function () {
        this.$document.off("." + this.identifier),
          this.$window.off("." + this.identifier),
          this.$element
            .off("." + this.identifier)
            .removeAttr("style")
            .removeData("plugin_" + r),
          this.$range &&
            this.$range.length &&
            this.$range[0].parentNode.removeChild(this.$range[0]);
      }),
      (o.fn[r] = function (e) {
        var n = Array.prototype.slice.call(arguments, 1);
        return this.each(function () {
          var t = o(this),
            i = t.data("plugin_" + r);
          i || t.data("plugin_" + r, (i = new u(this, e))),
            "string" == typeof e && i[e].apply(i, n);
        });
      }),
      "rangeslider.js is available in jQuery context e.g $(selector).rangeslider(options);"
    );
  });

// Range slider
$("#food_quality").rangeslider({
    polyfill: false,
    onInit: function () {
      this.output = $(".food_quality_val").html(this.$element.val());
    },
    onSlide: function (position, value) {
      this.output.html(value);
    },
  });
  
  $("#service").rangeslider({
    polyfill: false,
    onInit: function () {
      this.output = $(".service_val").html(this.$element.val());
    },
    onSlide: function (position, value) {
      this.output.html(value);
    },
  });
  
  $("#location").rangeslider({
    polyfill: false,
    onInit: function () {
      this.output = $(".location_val").html(this.$element.val());
    },
    onSlide: function (position, value) {
      this.output.html(value);
    },
  });
  
  $("#price").rangeslider({
    polyfill: false,
    onInit: function () {
      this.output = $(".price_val").html(this.$element.val());
    },
    onSlide: function (position, value) {
      this.output.html(value);
    },
  });
  