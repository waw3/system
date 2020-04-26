/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 32);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./platform/plugins/custom-field/resources/assets/js/use-custom-fields.js":
/*!********************************************************************************!*\
  !*** ./platform/plugins/custom-field/resources/assets/js/use-custom-fields.js ***!
  \********************************************************************************/
/*! exports provided: Helpers */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Helpers", function() { return Helpers; });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Helpers = /*#__PURE__*/function () {
  function Helpers() {
    _classCallCheck(this, Helpers);
  }

  _createClass(Helpers, null, [{
    key: "wysiwyg",

    /**
     * Render a WYSIWYG editor
     * @param $elements
     * @param config
     */
    value: function wysiwyg($elements, config) {
      window.initializedEditor = window.initializedEditor || 0;
      $elements.each(function (index, el) {
        var $_self = $(el);
        $_self.attr('id', 'editor_initialized_' + window.initializedEditor);
        window.initializedEditor++;
        setTimeout(function () {
          config = $.extend(true, {
            forcePasteAsPlainText: true,
            allowedContent: true,
            htmlEncodeOutput: false,
            protectedSource: [/<\?[\s\S]*?\?>/g, /<%[\s\S]*?%>/g, /(<asp:[^\>]+>[\s|\S]*?<\/asp:[^\>]+>)|(<asp:[^\>]+\/>)/gi],
            filebrowserImageBrowseUrl: RV_MEDIA_URL.base + '?media-action=select-files&method=ckeditor&type=image',
            filebrowserImageUploadUrl: RV_MEDIA_URL.media_upload_from_editor + '?method=ckeditor&type=image&_token=' + $('meta[name="csrf-token"]').attr('content'),
            filebrowserWindowWidth: '768',
            filebrowserWindowHeight: '500',
            height: $_self.data('height') || '400px',
            toolbar: $_self.data('toolbar') || 'full'
          }, config);
          config = $.extend(true, config, $_self.data());

          if (config.toolbar === 'basic') {
            config.toolbar = [['mode', 'Source', 'Image', 'TextColor', 'BGColor', 'Styles', 'Format', 'Font', 'FontSize', 'CreateDiv', 'PageBreak', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'RemoveFormat']];
          }

          CKEDITOR.replace($_self.attr('id'), config);
        }, 100);
      });
    }
  }, {
    key: "wysiwygGetContent",
    value: function wysiwygGetContent($element) {
      return CKEDITOR.instances[$element.attr('id')].getData();
    }
  }, {
    key: "arrayGet",
    value: function arrayGet(array, key) {
      var defaultValue = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
      var result;

      try {
        result = array[key];
      } catch (err) {
        return defaultValue;
      }

      if (result === null || typeof result === 'undefined') {
        result = defaultValue;
      }

      return result;
    }
  }, {
    key: "jsonEncode",
    value: function jsonEncode(object) {
      if (typeof object === 'undefined') {
        object = null;
      }

      return JSON.stringify(object);
    }
  }, {
    key: "jsonDecode",
    value: function jsonDecode(jsonString, defaultValue) {
      if (typeof jsonString === 'string') {
        var result;

        try {
          result = $.parseJSON(jsonString);
        } catch (err) {
          result = defaultValue;
        }

        return result;
      }

      return null;
    }
  }]);

  return Helpers;
}();

var UseCustomFields = /*#__PURE__*/function () {
  function UseCustomFields() {
    _classCallCheck(this, UseCustomFields);

    this.$body = $('body');
    /**
     * Where to show the custom field elements
     */

    this.$_UPDATE_TO = $('#custom_fields_container');
    /**
     * Where to export json data when submit form
     */

    this.$_EXPORT_TO = $('#custom_fields_json');
    this.CURRENT_DATA = Helpers.jsonDecode(this.base64Helper().decode(this.$_EXPORT_TO.text()), []);

    if (this.CURRENT_DATA) {
      this.handleCustomFields();
      this.exportData();
    }
  }

  _createClass(UseCustomFields, [{
    key: "base64Helper",
    value: function base64Helper() {
      if (!this.base64) {
        var Base64 = {
          _keyStr: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=',
          encode: function encode(e) {
            var t = '';
            var n, r, i, s, o, u, a;
            var f = 0;
            e = Base64._utf8_encode(e);

            while (f < e.length) {
              n = e.charCodeAt(f++);
              r = e.charCodeAt(f++);
              i = e.charCodeAt(f++);
              s = n >> 2;
              o = (n & 3) << 4 | r >> 4;
              u = (r & 15) << 2 | i >> 6;
              a = i & 63;

              if (isNaN(r)) {
                u = a = 64;
              } else if (isNaN(i)) {
                a = 64;
              }

              t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a);
            }

            return t;
          },
          decode: function decode(e) {
            var t = '';
            var n, r, i;
            var s, o, u, a;
            var f = 0;
            e = e.replace(/[^A-Za-z0-9+/=]/g, '');

            while (f < e.length) {
              s = this._keyStr.indexOf(e.charAt(f++));
              o = this._keyStr.indexOf(e.charAt(f++));
              u = this._keyStr.indexOf(e.charAt(f++));
              a = this._keyStr.indexOf(e.charAt(f++));
              n = s << 2 | o >> 4;
              r = (o & 15) << 4 | u >> 2;
              i = (u & 3) << 6 | a;
              t = t + String.fromCharCode(n);

              if (u != 64) {
                t = t + String.fromCharCode(r);
              }

              if (a != 64) {
                t = t + String.fromCharCode(i);
              }
            }

            t = Base64._utf8_decode(t);
            return t;
          },
          _utf8_encode: function _utf8_encode(e) {
            e = e.replace(/rn/g, 'n');
            var t = '';

            for (var n = 0; n < e.length; n++) {
              var r = e.charCodeAt(n);

              if (r < 128) {
                t += String.fromCharCode(r);
              } else if (r > 127 && r < 2048) {
                t += String.fromCharCode(r >> 6 | 192);
                t += String.fromCharCode(r & 63 | 128);
              } else {
                t += String.fromCharCode(r >> 12 | 224);
                t += String.fromCharCode(r >> 6 & 63 | 128);
                t += String.fromCharCode(r & 63 | 128);
              }
            }

            return t;
          },
          _utf8_decode: function _utf8_decode(e) {
            var t = '';
            var n = 0;
            var r = 0,
                c2 = 0;

            while (n < e.length) {
              r = e.charCodeAt(n);

              if (r < 128) {
                t += String.fromCharCode(r);
                n++;
              } else if (r > 191 && r < 224) {
                c2 = e.charCodeAt(n + 1);
                t += String.fromCharCode((r & 31) << 6 | c2 & 63);
                n += 2;
              } else {
                c2 = e.charCodeAt(n + 1);
                var c3 = e.charCodeAt(n + 2);
                t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63);
                n += 3;
              }
            }

            return t;
          }
        };
        this.base64 = Base64;
      }
      /**
       * @doc
       * There are 2 methods: encode & decode
       */


      return this.base64;
    }
  }, {
    key: "handleCustomFields",
    value: function handleCustomFields() {
      var _self = this;

      var repeaterFieldAdded = 0;
      /**
       * The html template of custom fields
       */

      var FIELD_TEMPLATE = {
        fieldGroup: $('#_render_custom_field_field_group_template').html(),
        globalSkeleton: $('#_render_custom_field_global_skeleton_template').html(),
        text: $('#_render_custom_field_text_template').html(),
        number: $('#_render_custom_field_number_template').html(),
        email: $('#_render_custom_field_email_template').html(),
        password: $('#_render_custom_field_password_template').html(),
        textarea: $('#_render_custom_field_textarea_template').html(),
        checkbox: $('#_render_custom_field_checkbox_template').html(),
        radio: $('#_render_custom_field_radio_template').html(),
        select: $('#_render_custom_field_select_template').html(),
        image: $('#_render_custom_field_image_template').html(),
        file: $('#_render_custom_field_file_template').html(),
        wysiwyg: $('#_render_custom_field_wysiswg_template').html(),
        repeater: $('#_render_custom_field_repeater_template').html(),
        repeaterItem: $('#_render_custom_field_repeater_item_template').html(),
        repeaterFieldLine: $('#_render_custom_field_repeater_line_template').html()
      };

      var initWYSIWYG = function initWYSIWYG($element, type) {
        Helpers.wysiwyg($element, {
          toolbar: type
        });
        return $element;
      };

      var initCustomFieldsBoxes = function initCustomFieldsBoxes(boxes, $appendTo) {
        boxes.forEach(function (box) {
          var skeleton = FIELD_TEMPLATE.globalSkeleton;
          skeleton = skeleton.replace(/__type__/gi, box.type || '');
          skeleton = skeleton.replace(/__title__/gi, box.title || '');
          skeleton = skeleton.replace(/__instructions__/gi, box.instructions || '');
          var $skeleton = $(skeleton);
          var $data = registerLine(box);
          $skeleton.find('.meta-box-wrap').append($data);
          $skeleton.data('lcf-registered-data', box);
          $appendTo.append($skeleton);

          if (box.type === 'wysiwyg') {
            initWYSIWYG($skeleton.find('.meta-box-wrap .wysiwyg-editor'), box.options.wysiwygToolbar || 'basic');
          }
        });
      };

      var registerLine = function registerLine(box) {
        var result = FIELD_TEMPLATE[box.type],
            $wrapper = $('<div class="lcf-' + box.type + '-wrapper"></div>');
        $wrapper.data('lcf-registered-data', box);
        var choices = null;
        var $result = null;

        switch (box.type) {
          case 'text':
          case 'number':
          case 'email':
          case 'password':
            result = result.replace(/__placeholderText__/gi, box.options.placeholderText || '');
            result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
            break;

          case 'textarea':
            result = result.replace(/__rows__/gi, box.options.rows || 3);
            result = result.replace(/__placeholderText__/gi, box.options.placeholderText || '');
            result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
            break;

          case 'image':
            result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');

            if (!box.value) {
              var defaultImage = $(result).find('img').attr('data-default');
              result = result.replace(/__image__/gi, defaultImage || box.options.defaultValue || '');
            } else {
              result = result.replace(/__image__/gi, box.thumb || box.options.defaultValue || '');
            }

            break;

          case 'file':
            result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
            result = result.replace(/__url__/gi, box.full_url || box.options.defaultValue || '');
            break;

          case 'select':
            $result = $(result);
            choices = parseChoices(box.options.selectChoices);
            choices.forEach(function (choice) {
              $result.append('<option value="' + choice[0] + '">' + choice[1] + '</option>');
            });
            $result.val(Helpers.arrayGet(box, 'value', box.options.defaultValue));
            $wrapper.append($result);
            return $wrapper;

          case 'checkbox':
            choices = parseChoices(box.options.selectChoices);
            var boxValue = Helpers.jsonDecode(box.value);
            choices.forEach(function (choice) {
              var template = result.replace(/__value__/gi, choice[0] || '');
              template = template.replace(/__title__/gi, choice[1] || '');
              template = template.replace(/__checked__/gi, $.inArray(choice[0], boxValue) != -1 ? 'checked' : '');
              $wrapper.append($(template));
            });
            return $wrapper;

          case 'radio':
            choices = parseChoices(box.options.selectChoices);
            var isChecked = false;
            choices.forEach(function (choice) {
              var template = result.replace(/__value__/gi, choice[0] || '');
              template = template.replace(/__id__/gi, box.id + box.slug + repeaterFieldAdded);
              template = template.replace(/__title__/gi, choice[1] || '');
              template = template.replace(/__checked__/gi, box.value === choice[0] ? 'checked' : '');
              $wrapper.append($(template));

              if (box.value === choice[0]) {
                isChecked = true;
              }
            });

            if (isChecked === false) {
              $wrapper.find('input[type=radio]:first').prop('checked', true);
            }

            return $wrapper;

          case 'repeater':
            $result = $(result);
            $result.data('lcf-registered-data', box);
            $result.find('> .repeater-add-new-field').html(box.options.buttonLabel || 'Add new item');
            $result.find('> .sortable-wrapper').sortable();
            registerRepeaterItem(box.items, box.value || [], $result.find('> .field-group-items'));
            return $result;

          case 'wysiwyg':
            result = result.replace(/__value__/gi, box.value || '');
            $(result).attr('data-toolbar', box.options.wysiwygToolbar || 'basic');
            break;
        }

        $wrapper.append($(result));
        return $wrapper;
      };

      var registerRepeaterItem = function registerRepeaterItem(items, data, $appendTo) {
        $appendTo.data('lcf-registered-data', items);
        data.forEach(function (dataItem) {
          var indexCss = $appendTo.find('> .ui-sortable-handle').length + 1;
          var result = FIELD_TEMPLATE.repeaterItem;
          result = result.replace(/__position__/gi, indexCss);
          var $result = $(result);
          $result.data('lcf-registered-data', items);
          registerRepeaterFieldLine(items, dataItem, $result.find('> .field-line-wrapper > .field-group'));
          $appendTo.append($result);
        });
        return $appendTo;
      };

      var registerRepeaterFieldLine = function registerRepeaterFieldLine(items, data, $appendTo) {
        data.forEach(function (item) {
          repeaterFieldAdded++;
          var result = FIELD_TEMPLATE.repeaterFieldLine;
          result = result.replace(/__title__/gi, item.title || '');
          result = result.replace(/__instructions__/gi, item.instructions || '');
          var $result = $(result);
          var $data = registerLine(item);
          $result.data('lcf-registered-data', item);
          $result.find('> .repeater-item-input').append($data);
          $appendTo.append($result);

          if (item.type === 'wysiwyg') {
            initWYSIWYG($result.find('> .repeater-item-input .wysiwyg-editor'), item.options.wysiwygToolbar || 'basic');
          }
        });
        return $appendTo;
      };

      var parseChoices = function parseChoices(choiceString) {
        var choices = [];
        choiceString.split('\n').forEach(function (item) {
          var currentChoice = item.split(':');

          if (currentChoice[0] && currentChoice[1]) {
            currentChoice[0] = currentChoice[0].trim();
            currentChoice[1] = currentChoice[1].trim();
          }

          choices.push(currentChoice);
        });
        return choices;
      };
      /**
       * Remove field item
       */


      this.$body.on('click', '.remove-field-line', function (event) {
        event.preventDefault();
        var current = $(event.currentTarget);
        current.parent().animate({
          opacity: 0.1
        }, 300, function () {
          current.parent().remove();
        });
      });
      /**
       * Collapse field item
       */

      this.$body.on('click', '.collapse-field-line', function (event) {
        event.preventDefault();
        var current = $(event.currentTarget);
        current.toggleClass('collapsed-line');
      });
      /**
       * Add new repeater line
       */

      this.$body.on('click', '.repeater-add-new-field', function (event) {
        event.preventDefault();
        var $groupWrapper = $.extend(true, {}, $(event.currentTarget).prev('.field-group-items'));
        var registeredData = $groupWrapper.data('lcf-registered-data');
        repeaterFieldAdded++;
        registerRepeaterItem(registeredData, [registeredData], $groupWrapper);
        Botble.initMediaIntegrate();
      });
      /**
       * Init data when page loaded
       */

      this.CURRENT_DATA.forEach(function (group) {
        var groupTemplate = FIELD_TEMPLATE.fieldGroup;
        groupTemplate = groupTemplate.replace(/__title__/gi, group.title || '');
        var $groupTemplate = $(groupTemplate);
        initCustomFieldsBoxes(group.items, $groupTemplate.find('.meta-boxes-body'));
        $groupTemplate.data('lcf-field-group', group);

        _self.$_UPDATE_TO.append($groupTemplate);
      });
      Botble.initMediaIntegrate();
    }
  }, {
    key: "exportData",
    value: function exportData() {
      var _self = this;

      var getFieldGroups = function getFieldGroups() {
        var fieldGroups = [];
        $('#custom_fields_container').find('> .meta-boxes').each(function (index, el) {
          var $current = $(el);
          var currentData = $current.data('lcf-field-group');
          var $items = $current.find('> .meta-boxes-body > .meta-box');
          currentData.items = getFieldItems($items);
          fieldGroups.push(currentData);
        });
        return fieldGroups;
      };

      var getFieldItems = function getFieldItems($items) {
        var items = [];
        $items.each(function (index, el) {
          items.push(getFieldItemValue($(el)));
        });
        return items;
      };

      var getFieldItemValue = function getFieldItemValue($item) {
        var customFieldData = $.extend(true, {}, $item.data('lcf-registered-data'));

        switch (customFieldData.type) {
          case 'text':
          case 'number':
          case 'email':
          case 'password':
          case 'image':
          case 'file':
            customFieldData.value = $item.find('> .meta-box-wrap input').val();
            break;

          case 'wysiwyg':
            customFieldData.value = Helpers.wysiwygGetContent($item.find('> .meta-box-wrap textarea'));
            break;

          case 'textarea':
            customFieldData.value = $item.find('> .meta-box-wrap textarea').val();
            break;

          case 'checkbox':
            customFieldData.value = [];
            $item.find('> .meta-box-wrap input:checked').each(function (index, el) {
              customFieldData.value.push($(el).val());
            });
            break;

          case 'radio':
            customFieldData.value = $item.find('> .meta-box-wrap input:checked').val();
            break;

          case 'select':
            customFieldData.value = $item.find('> .meta-box-wrap select').val();
            break;

          case 'repeater':
            customFieldData.value = [];
            var $repeaterItems = $item.find('> .meta-box-wrap > .lcf-repeater > .field-group-items > li');
            $repeaterItems.each(function (index, el) {
              var $current = $(el);
              var fieldGroup = $current.find('> .field-line-wrapper > .field-group');
              customFieldData.value.push(getRepeaterItemData(fieldGroup.find('> li')));
            });
            break;

          default:
            customFieldData = null;
            break;
        }

        return customFieldData;
      };

      var getRepeaterItemData = function getRepeaterItemData($where) {
        var data = [];
        $where.each(function (index, el) {
          var $current = $(el);
          data.push(getRepeaterItemValue($current));
        });
        return data;
      };

      var getRepeaterItemValue = function getRepeaterItemValue($item) {
        var customFieldData = $.extend(true, {}, $item.data('lcf-registered-data'));

        switch (customFieldData.type) {
          case 'text':
          case 'number':
          case 'email':
          case 'password':
          case 'image':
          case 'file':
            customFieldData.value = $item.find('> .repeater-item-input input').val();
            break;

          case 'wysiwyg':
            customFieldData.value = Helpers.wysiwygGetContent($item.find('> .repeater-item-input > .lcf-wysiwyg-wrapper > .wysiwyg-editor'));
            break;

          case 'textarea':
            customFieldData.value = $item.find('> .repeater-item-input textarea').val();
            break;

          case 'checkbox':
            customFieldData.value = [];
            $item.find('> .repeater-item-input input:checked').each(function (index, el) {
              customFieldData.value.push($(el).val());
            });
            break;

          case 'radio':
            customFieldData.value = $item.find('> .repeater-item-input input:checked').val();
            break;

          case 'select':
            customFieldData.value = $item.find('> .repeater-item-input select').val();
            break;

          case 'repeater':
            customFieldData.value = [];
            var $repeaterItems = $item.find('> .repeater-item-input > .lcf-repeater > .field-group-items > li');
            $repeaterItems.each(function (index, el) {
              var $current = $(el);
              var fieldGroup = $current.find('> .field-line-wrapper > .field-group');
              customFieldData.value.push(getRepeaterItemData(fieldGroup.find('> li')));
            });
            break;

          default:
            customFieldData = null;
            break;
        }

        return customFieldData;
      };

      _self.$_EXPORT_TO.closest('form').on('submit', function () {
        _self.$_EXPORT_TO.val(Helpers.jsonEncode(getFieldGroups()));
      });
    }
  }]);

  return UseCustomFields;
}();

(function ($) {
  $(document).ready(function () {
    new UseCustomFields();
  });
})(jQuery);

/***/ }),

/***/ 32:
/*!**************************************************************************************!*\
  !*** multi ./platform/plugins/custom-field/resources/assets/js/use-custom-fields.js ***!
  \**************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/willy/Sites/botble/platform/plugins/custom-field/resources/assets/js/use-custom-fields.js */"./platform/plugins/custom-field/resources/assets/js/use-custom-fields.js");


/***/ })

/******/ });