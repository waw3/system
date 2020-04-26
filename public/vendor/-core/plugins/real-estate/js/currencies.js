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
/******/ 	return __webpack_require__(__webpack_require__.s = 39);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./platform/plugins/real-estate/resources/assets/js/currencies.js":
/*!************************************************************************!*\
  !*** ./platform/plugins/real-estate/resources/assets/js/currencies.js ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Currencies = /*#__PURE__*/function () {
  function Currencies() {
    _classCallCheck(this, Currencies);

    this.template = $('#currency_template').html();
    this.totalItem = 0;
    this.deletedItems = [];
    this.initData();
    this.handleForm();
  }

  _createClass(Currencies, [{
    key: "initData",
    value: function initData() {
      var _self = this;

      var data = $.parseJSON($('#currencies').html());
      $.each(data, function (index, item) {
        var template = _self.template.replace(/__id__/gi, item.id).replace(/__position__/gi, item.order).replace(/__isPrefixSymbolChecked__/gi, item.is_prefix_symbol == 1 ? 'selected' : '').replace(/__notIsPrefixSymbolChecked__/gi, item.is_prefix_symbol == 0 ? 'selected' : '').replace(/__isDefaultChecked__/gi, item.is_default == 1 ? 'checked' : '').replace(/__title__/gi, item.title).replace(/__decimals__/gi, item.decimals).replace(/__exchangeRate__/gi, item.exchange_rate).replace(/__symbol__/gi, item.symbol);

        $('.swatches-container .swatches-list').append(template);
        _self.totalItem++;
      });
    }
  }, {
    key: "addNewAttribute",
    value: function addNewAttribute() {
      var _self = this;

      var template = _self.template.replace(/__id__/gi, 0).replace(/__position__/gi, _self.totalItem).replace(/__isPrefixSymbolChecked__/gi, '').replace(/__notIsPrefixSymbolChecked__/gi, '').replace(/__isDefaultChecked__/gi, _self.totalItem == 0 ? 'checked' : '').replace(/__title__/gi, '').replace(/__decimals__/gi, 0).replace(/__exchangeRate__/gi, 1).replace(/__symbol__/gi, '');

      $('.swatches-container .swatches-list').append(template);
      _self.totalItem++;
    }
  }, {
    key: "exportData",
    value: function exportData() {
      var data = [];
      $('.swatches-container .swatches-list li').each(function (index, item) {
        var $current = $(item);
        data.push({
          id: $current.data('id'),
          is_default: $current.find('[data-type=is_default] input[type=radio]').is(':checked') ? 1 : 0,
          order: $current.index(),
          title: $current.find('[data-type=title] input').val(),
          symbol: $current.find('[data-type=symbol] input').val(),
          decimals: $current.find('[data-type=decimals] input').val(),
          exchange_rate: $current.find('[data-type=exchange_rate] input').val(),
          is_prefix_symbol: $current.find('[data-type=is_prefix_symbol] select').val()
        });
      });
      return data;
    }
  }, {
    key: "handleForm",
    value: function handleForm() {
      var _self = this;

      $('.swatches-container .swatches-list').sortable();
      $('body').on('submit', '.main-setting-form', function () {
        var data = _self.exportData();

        $('#currencies').val(JSON.stringify(data));
        $('#deleted_currencies').val(JSON.stringify(_self.deletedItems));
      }).on('click', '.js-add-new-attribute', function (event) {
        event.preventDefault();

        _self.addNewAttribute();
      }).on('click', '.swatches-container .swatches-list li .remove-item a', function (event) {
        event.preventDefault();
        var $item = $(event.currentTarget).closest('li');

        _self.deletedItems.push($item.data('id'));

        $item.remove();
      });
    }
  }]);

  return Currencies;
}();

$(window).on('load', function () {
  new Currencies();
});

/***/ }),

/***/ 39:
/*!******************************************************************************!*\
  !*** multi ./platform/plugins/real-estate/resources/assets/js/currencies.js ***!
  \******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/odisoedim/webzone/islandhomes/platform/plugins/real-estate/resources/assets/js/currencies.js */"./platform/plugins/real-estate/resources/assets/js/currencies.js");


/***/ })

/******/ });