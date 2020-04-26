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
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./platform/core/table/resources/assets/js/filter.js":
/*!***********************************************************!*\
  !*** ./platform/core/table/resources/assets/js/filter.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var TableFilter = /*#__PURE__*/function () {
  function TableFilter() {
    _classCallCheck(this, TableFilter);
  }

  _createClass(TableFilter, [{
    key: "loadData",
    value: function loadData($element) {
      $.ajax({
        type: 'GET',
        url: $('.filter-data-url').val(),
        data: {
          'class': $('.filter-data-class').val(),
          'key': $element.val(),
          'value': $element.closest('.filter-item').find('.filter-column-value').val()
        },
        success: function success(res) {
          var data = $.map(res.data, function (value, key) {
            return {
              id: key,
              name: value
            };
          });
          $element.closest('.filter-item').find('.filter-column-value-wrap').html(res.html);
          var $input = $element.closest('.filter-item').find('.filter-column-value');

          if ($input.length && $input.prop('type') === 'text') {
            $input.typeahead({
              source: data
            });
            $input.data('typeahead').source = data;
          }

          Botble.initResources();
        },
        error: function error(_error) {
          Botble.handleError(_error);
        }
      });
    }
  }, {
    key: "init",
    value: function init() {
      var that = this;
      $.each($('.filter-items-wrap .filter-column-key'), function (index, element) {
        if ($(element).val()) {
          that.loadData($(element));
        }
      });
      $(document).on('change', '.filter-column-key', function (event) {
        that.loadData($(event.currentTarget));
      });
      $(document).on('click', '.btn-reset-filter-item', function (event) {
        event.preventDefault();

        var _self = $(event.currentTarget);

        _self.closest('.filter-item').find('.filter-column-key').val('').trigger('change');

        _self.closest('.filter-item').find('.filter-column-operator').val('=');

        _self.closest('.filter-item').find('.filter-column-value').val('');
      });
      $(document).on('click', '.add-more-filter', function () {
        var $template = $(document).find('.sample-filter-item-wrap');
        var html = $template.html();
        $(document).find('.filter-items-wrap').append(html);
        Botble.initResources();
        var element = $(document).find('.filter-items-wrap .filter-item:last-child').find('.filter-column-key');

        if ($(element).val()) {
          that.loadData(element);
        }
      });
      $(document).on('click', '.btn-remove-filter-item', function (event) {
        event.preventDefault();
        $(event.currentTarget).closest('.filter-item').remove();
      });
    }
  }]);

  return TableFilter;
}();

$(document).ready(function () {
  new TableFilter().init();
});

/***/ }),

/***/ 8:
/*!*****************************************************************!*\
  !*** multi ./platform/core/table/resources/assets/js/filter.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/willy/Sites/botble/platform/core/table/resources/assets/js/filter.js */"./platform/core/table/resources/assets/js/filter.js");


/***/ })

/******/ });