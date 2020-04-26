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
/******/ 	return __webpack_require__(__webpack_require__.s = 31);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./platform/plugins/custom-field/resources/assets/js/edit-field-group.js":
/*!*******************************************************************************!*\
  !*** ./platform/plugins/custom-field/resources/assets/js/edit-field-group.js ***!
  \*******************************************************************************/
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
    key: "arrayGet",
    value: function arrayGet(array, key) {
      var defaultValue = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
      var result;

      try {
        result = array[key];
      } catch (err) {
        return defaultValue;
      }

      if (result === null || typeof result == 'undefined') {
        result = defaultValue;
      }

      return result;
    }
  }, {
    key: "stringToSlug",
    value: function stringToSlug(text, separator) {
      separator = separator || '-';
      return text.toString()
      /*To lower case*/
      .toLowerCase()
      /*Vietnamese string*/
      .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a').replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e').replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i').replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o').replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u').replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y').replace(/đ/gi, 'd')
      /*Replace spaces with -*/
      .replace(/\s+/g, separator)
      /*Remove all non-word chars*/
      .replace(/[^\w\-]+/g, '')
      /*Replace multiple - with single -*/
      .replace(/\-\-+/g, separator)
      /*Trim - from start of text*/
      .replace(/^-+/, '')
      /*Trim - from end of text*/
      .replace(/-+$/, '');
    }
  }]);

  return Helpers;
}();

var ManageCustomFields = /*#__PURE__*/function () {
  function ManageCustomFields() {
    _classCallCheck(this, ManageCustomFields);

    this.$body = $('body');
    this.RULES_GROUP_TEMPLATE_HTML = $('#rules_group_template').html();

    var _self = this;
    /**
     * Pass data to form when submit
     */


    this.$body.on('submit', '.form-update-field-group', function () {
      var dataRules = JSON.stringify(_self.exportRulesToJson());
      var dataFields = JSON.stringify(_self.exportFieldsToJson());
      $('#custom_fields_rules').html(dataRules).val(dataRules);
      $('#custom_fields').html(dataFields).val(dataFields);
    });

    if ($('#custom_fields_rules').length > 0) {
      this.handleRules();
      this.handleFieldGroups();
    }
  }

  _createClass(ManageCustomFields, [{
    key: "handleRules",
    value: function handleRules() {
      var _self = this;

      var CURRENT_RULES = $.parseJSON($('#custom_fields_rules').val());
      var $_GLOBAL_TEMPLATE = $(_self.RULES_GROUP_TEMPLATE_HTML),
          LINE_GROUP_TEMPLATE = $('#rules_line_group_template').html(),
          $_GROUP_CONTAINER = $('.line-group-container');
      /**
       * Add new rule
       */

      _self.$body.on('click', '.location-add-rule', function (event) {
        event.preventDefault();
        var $current = $(event.currentTarget);
        var $template = $_GLOBAL_TEMPLATE.clone();

        if ($current.hasClass('location-add-rule-and')) {
          $current.closest('.line-group').append($template);
        } else {
          var $group = $(LINE_GROUP_TEMPLATE);
          $group.append($template);
          $_GROUP_CONTAINER.append($group);
        }

        $template.find('.rule-a').trigger('change');
      });
      /**
       * Change the rule-a
       */


      _self.$body.on('change', '.rule-a', function (event) {
        event.preventDefault();
        var $current = $(event.currentTarget);
        var $parent = $current.closest('.rule-line');
        $parent.find('.rules-b-group select').addClass('hidden');
        $parent.find('.rules-b-group select[data-rel="' + $current.val() + '"]').removeClass('hidden');
      });
      /**
       * Remove rule
       */


      _self.$body.on('click', '.remove-rule-line', function (event) {
        event.preventDefault();
        var $current = $(event.currentTarget);
        var $parent = $current.closest('.rule-line');
        var $lineGroup = $current.closest('.line-group');

        if ($lineGroup.find('.rule-line').length < 2) {
          $lineGroup.remove();
        } else {
          $parent.remove();
        }
      });
      /**
       * Init data when page loaded
       */


      if (CURRENT_RULES.length < 1) {
        $('.location-add-rule').trigger('click');
      } else {
        CURRENT_RULES.forEach(function (rules) {
          var $group = $(LINE_GROUP_TEMPLATE);
          rules.forEach(function (item) {
            var $template = $_GLOBAL_TEMPLATE.clone();
            $template.find('.rule-a').val(item.name);
            $template.find('.rule-type').val(item.type);
            $template.find('.rule-b:not([data-rel="' + item.name + '"])').addClass('hidden');
            $template.find('.rule-b[data-rel="' + item.name + '"]').val(item.value);
            $group.append($template);
          });
          $_GROUP_CONTAINER.append($group);
        });
      }
    }
  }, {
    key: "handleFieldGroups",
    value: function handleFieldGroups() {
      var _self = this;

      var totalAdded = 0;
      var CUSTOM_FIELDS_DATA = $.parseJSON($('#custom_fields').val());
      /**
       * Deleted fields
       * @type {Array}
       */

      var DELETED_FIELDS = [];
      /**
       * Template of new field item
       * @type {any}
       */

      var NEW_FIELD_TEMPLATE = $('#_new-field-source_template').html();
      /**
       * Get all option templates
       * @type {{repeater: (any), defaultValue: (any), defaultValueTextarea: (any), placeholderText: (any), wysiwygToolbar: (any), selectChoices: (any), buttonLabel: (any)}}
       */

      var FIELD_OPTIONS = {
        repeater: $('#_options-repeater_template').html(),
        defaultValue: $('#_options-defaultvalue_template').html(),
        defaultValueTextarea: $('#_options-defaultvaluetextarea_template').html(),
        placeholderText: $('#_options-placeholdertext_template').html(),
        wysiwygToolbar: $('#_options-wysiwygtoolbar_template').html(),
        selectChoices: $('#_options-selectchoices_template').html(),
        buttonLabel: $('#_options-buttonlabel_template').html(),
        rows: $('#_options-rows_template').html()
      };
      /**
       * Get related options of current field type
       * @param value
       * @returns {string}
       */

      var getOptions = function getOptions(value) {
        var htmlSrc = '';

        switch (value) {
          case 'text':
          case 'email':
          case 'password':
          case 'number':
            htmlSrc += FIELD_OPTIONS.defaultValue + FIELD_OPTIONS.placeholderText;
            break;

          case 'image':
          case 'file':
            htmlSrc += '';
            break;

          case 'textarea':
            htmlSrc += FIELD_OPTIONS.defaultValueTextarea + FIELD_OPTIONS.placeholderText + FIELD_OPTIONS.rows;
            break;

          case 'wysiwyg':
            htmlSrc += FIELD_OPTIONS.defaultValueTextarea + FIELD_OPTIONS.wysiwygToolbar;
            break;

          case 'select':
            htmlSrc += FIELD_OPTIONS.selectChoices + FIELD_OPTIONS.defaultValue;
            break;

          case 'checkbox':
            htmlSrc += FIELD_OPTIONS.selectChoices;
            break;

          case 'radio':
            htmlSrc += FIELD_OPTIONS.selectChoices;
            break;

          case 'repeater':
            htmlSrc += FIELD_OPTIONS.repeater + FIELD_OPTIONS.buttonLabel;
            break;
        }

        return htmlSrc;
      };
      /**
       * @param target
       */


      var reloadOrderNumber = function reloadOrderNumber(target) {
        target.each(function (index, el) {
          var current = $(el);
          var index_css = index + 1;
          current.attr('data-position', index_css);
        });
      };

      var setOrderNumber = function setOrderNumber(target, number) {
        target.attr('data-position', number || target.index() + 1);
      };

      var getNewFieldTemplate = function getNewFieldTemplate(optionType) {
        return NEW_FIELD_TEMPLATE.replace(/___options___/gi, getOptions(optionType || 'text'));
      };
      /**
       * Toggle show/hide content
       */


      _self.$body.on('click', '.show-item-details', function (event) {
        event.preventDefault();
        var parent = $(event.currentTarget).closest('li');
        $(event.currentTarget).toggleClass('active');
        parent.toggleClass('active');
      });

      _self.$body.on('click', '.btn-close-field', function (event) {
        event.preventDefault();
        var parent = $(event.currentTarget).closest('li');
        parent.toggleClass('active');
        parent.find('> .field-column .show-item-details').toggleClass('active');
      });
      /**
       * Add field
       */


      _self.$body.on('click', '.btn-add-field', function (event) {
        event.preventDefault();
        var $current = $(event.currentTarget);
        totalAdded++;
        var target = $current.closest('.add-new-field').find('> .sortable-wrapper');
        var $template = $(getNewFieldTemplate());
        target.append($template);
        $template.find('.line[data-option=title] input[type=text]').focus();
        setOrderNumber($template);
        $template.find('.sortable-wrapper').sortable();
      });
      /**
       * Change field type
       */


      _self.$body.on('change', '.change-field-type', function (event) {
        event.preventDefault();
        var $current = $(event.currentTarget);
        var parent = $current.closest('.item-details');
        var target = parent.find('> .options');
        target.html(getOptions($current.val()));
      });
      /**
       * Change the related columns title
       */


      _self.$body.on('change blur', '.line[data-option=slug] input[type=text]', function (event) {
        var $current = $(event.currentTarget);
        var text = Helpers.stringToSlug($current.val(), '_');
        var $parent = $current.closest('.line');
        $parent.closest('.ui-sortable-handle').find('> .field-column .field-slug').text(text);
        $current.val(text);
      });

      _self.$body.on('change blur', '.line[data-option=type] select', function (event) {
        var $current = $(event.currentTarget);
        var text = Helpers.stringToSlug($current.val(), '_');
        var $parent = $current.closest('.line');
        $parent.closest('.ui-sortable-handle').find('> .field-column .field-type').text($current.find('option[value="' + text + '"]').text());
        $current.val(text);
      });

      _self.$body.on('change blur', '.line[data-option=title] input[type=text]', function (event) {
        var $current = $(event.currentTarget);
        var $parent = $current.closest('.line');
        var $nameSlugField = $parent.find('~ .line[data-option=slug] input[type=text]');
        var text = $current.val();
        /**
         * Change the line title
         */

        $parent.closest('.ui-sortable-handle').find('> .field-column .field-label').text(text);
        /**
         * Change field name
         */

        if (!$nameSlugField.val()) {
          $nameSlugField.val(Helpers.stringToSlug(text, '_')).trigger('change');
        }
      });
      /**
       * Delete field
       */


      $('#deleted_items').val('');

      _self.$body.on('click', '.btn-remove', function (event) {
        event.preventDefault();
        var $parent = $(event.currentTarget).closest('.ui-sortable-handle');
        var $grandParent = $parent.parent();
        DELETED_FIELDS.push($parent.data('id'));
        $parent.animate({
          top: -60,
          left: 60,
          opacity: 0.3
        }, 300, function () {
          $parent.remove();
          reloadOrderNumber($grandParent.find('> li'));
        });
        $('#deleted_items').val(JSON.stringify(DELETED_FIELDS));
      });
      /**
       *
       * @param fields
       * @param $appendTo
       */


      var initFields = function initFields(fields, $appendTo) {
        /**
         * Enable sortable
         */
        $appendTo.sortable();
        fields.forEach(function (field, indexField) {
          var $template = $(getNewFieldTemplate(field.type || 'text'));
          $template.data('id', field.id || 0);
          $template.find('.line[data-option=type] select').val(Helpers.arrayGet(field, 'type', 'text'));
          $template.find('.line[data-option=title] input').val(Helpers.arrayGet(field, 'title', ''));
          $template.find('.line[data-option=slug] input').val(Helpers.arrayGet(field, 'slug', ''));
          $template.find('.line[data-option=instructions] textarea').val(Helpers.arrayGet(field, 'instructions', ''));
          $template.find('.line[data-option=defaultvalue] input').val(Helpers.arrayGet(field.options, 'defaultValue', ''));
          $template.find('.line[data-option=defaultvaluetextarea] textarea').val(Helpers.arrayGet(field.options, 'defaultValueTextarea', ''));
          $template.find('.line[data-option=placeholdertext] input').val(Helpers.arrayGet(field.options, 'placeholderText', ''));
          $template.find('.line[data-option=wysiwygtoolbar] select').val(Helpers.arrayGet(field.options, 'wysiwygToolbar', 'basic'));
          $template.find('.line[data-option=selectchoices] textarea').val(Helpers.arrayGet(field.options, 'selectChoices', ''));
          $template.find('.line[data-option=buttonlabel] input').val(Helpers.arrayGet(field.options, 'buttonLabel', ''));
          $template.find('.line[data-option=rows] input').val(Helpers.arrayGet(field.options, 'rows', ''));
          $template.find('.field-label').html(Helpers.arrayGet(field, 'title', 'Text'));
          $template.find('.field-slug').html(Helpers.arrayGet(field, 'slug', 'text'));
          $template.find('.field-type').html(Helpers.arrayGet(field, 'type', 'text'));
          $template.removeClass('active');
          $template.attr('data-position', indexField + 1);
          initFields(field.items, $template.find('.sortable-wrapper'));
          $appendTo.append($template);
        });
      };

      initFields(CUSTOM_FIELDS_DATA, $('.sortable-wrapper'));
    }
  }, {
    key: "exportRulesToJson",
    value: function exportRulesToJson() {
      var result = [];
      $('.custom-fields-rules .line-group-container .line-group').each(function (key, el) {
        var $current = $(el);
        var lineGroupData = [];
        $current.find('.rule-line').each(function (index, element) {
          var $currentLine = $(element);
          var data = {
            name: $currentLine.find('.rule-a').val(),
            type: $currentLine.find('.rule-type').val(),
            value: $currentLine.find('.rule-b:not(.hidden)').val()
          };
          lineGroupData.push(data);
        });

        if (lineGroupData.length > 0) {
          result.push(lineGroupData);
        }
      });
      return result;
    }
  }, {
    key: "exportFieldsToJson",
    value: function exportFieldsToJson() {
      var result = [];

      var getAllFields = function getAllFields($from, $pushTo) {
        $from.each(function (index, element) {
          var object = {};
          var $current = $(element);
          object.id = $current.data('id') || 0;
          object.title = $current.find('> .item-details > .line[data-option=title] input[type=text]').val() || null;
          object.slug = $current.find('> .item-details > .line[data-option=slug] input[type=text]').val() || null;
          object.instructions = $current.find('> .item-details > .line[data-option=instructions] textarea').val() || null;
          object.type = $current.find('> .item-details > .line[data-option=type] select').val() || null;
          object.options = {
            defaultValue: $current.find('> .item-details > .options > .line[data-option=defaultvalue] input[type=text]').val() || null,
            defaultValueTextarea: $current.find('> .item-details > .options > .line[data-option=defaultvaluetextarea] textarea').val() || null,
            placeholderText: $current.find('> .item-details > .options > .line[data-option=placeholdertext] input[type=text]').val() || null,
            wysiwygToolbar: $current.find('> .item-details > .options > .line[data-option=wysiwygtoolbar] select').val() || null,
            selectChoices: $current.find('> .item-details > .options > .line[data-option=selectchoices] textarea').val() || null,
            buttonLabel: $current.find('> .item-details > .options > .line[data-option=buttonlabel] input[type=text]').val() || null,
            rows: $current.find('> .item-details > .options > .line[data-option=rows] input[type=number]').val() || null
          };
          object.items = [];
          getAllFields($current.find('> .item-details > .options > .line[data-option=repeater] > .col-9 > .add-new-field > .sortable-wrapper > .ui-sortable-handle'), object.items);
          $pushTo.push(object);
        });
      };

      getAllFields($('#custom_field_group_items > .ui-sortable-handle'), result);
      return result;
    }
  }]);

  return ManageCustomFields;
}();

(function ($) {
  $(window).on('load', function () {
    new ManageCustomFields();
  });
})(jQuery);

/***/ }),

/***/ 31:
/*!*************************************************************************************!*\
  !*** multi ./platform/plugins/custom-field/resources/assets/js/edit-field-group.js ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/willy/Sites/botble/platform/plugins/custom-field/resources/assets/js/edit-field-group.js */"./platform/plugins/custom-field/resources/assets/js/edit-field-group.js");


/***/ })

/******/ });