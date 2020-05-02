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
/******/ 	return __webpack_require__(__webpack_require__.s = 35);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/Plugins/gallery/resources/assets/js/object-gallery.js":
/*!************************************************************************!*\
  !*** ./Modules/Plugins/gallery/resources/assets/js/object-gallery.js ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var ObjectGalleryManagement = /*#__PURE__*/function () {
  function ObjectGalleryManagement() {
    _classCallCheck(this, ObjectGalleryManagement);
  }

  _createClass(ObjectGalleryManagement, [{
    key: "init",
    value: function init() {
      $('[data-slider="owl"] .owl-carousel').each(function (index, el) {
        var parent = $(el).parent();
        var items;
        var itemsDesktop;
        var itemsDesktopSmall;
        var itemsTablet;
        var itemsTabletSmall;
        var itemsMobile;

        if (parent.data('single-item') === 'true') {
          items = 1;
          itemsDesktop = 1;
          itemsDesktopSmall = 1;
          itemsTablet = 1;
          itemsTabletSmall = 1;
          itemsMobile = 1;
        } else {
          items = parent.data('items');
          itemsDesktop = [1199, parent.data('desktop-items') ? parent.data('desktop-items') : items];
          itemsDesktopSmall = [979, parent.data('desktop-small-items') ? parent.data('desktop-small-items') : 3];
          itemsTablet = [768, parent.data('tablet-items') ? parent.data('tablet-items') : 2];
          itemsMobile = [479, parent.data('mobile-items') ? parent.data('mobile-items') : 1];
        }

        $(el).owlCarousel({
          items: items,
          itemsDesktop: itemsDesktop,
          itemsDesktopSmall: itemsDesktopSmall,
          itemsTablet: itemsTablet,
          itemsTabletSmall: itemsTabletSmall,
          itemsMobile: itemsMobile,
          navigation: !!parent.data('navigation'),
          navigationText: false,
          slideSpeed: parent.data('slide-speed'),
          paginationSpeed: parent.data('pagination-speed'),
          singleItem: !!parent.data('single-item'),
          autoPlay: parent.data('auto-play')
        });
      });
    }
  }]);

  return ObjectGalleryManagement;
}();

$(document).ready(function () {
  new ObjectGalleryManagement().init();
});

/***/ }),

/***/ 35:
/*!******************************************************************************!*\
  !*** multi ./Modules/Plugins/gallery/resources/assets/js/object-gallery.js ***!
  \******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/willy/Sites/botble/Modules/Plugins/gallery/resources/assets/js/object-gallery.js */"./Modules/Plugins/gallery/resources/assets/js/object-gallery.js");


/***/ })

/******/ });