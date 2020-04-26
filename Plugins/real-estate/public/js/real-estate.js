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
/******/ 	return __webpack_require__(__webpack_require__.s = 38);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/Plugins/real-estate/resources/assets/js/real-estate.js":
/*!*************************************************************************!*\
  !*** ./Modules/Plugins/real-estate/resources/assets/js/real-estate.js ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var RealEstate = {
  init: function init() {
    new RvMediaStandAlone('.js-btn-trigger-add-image', {
      onSelectFiles: function onSelectFiles(files, $el) {
        var $currentBoxList = $el.closest('.object-images-wrapper').find('.images-wrapper .list-gallery-media-images');
        $currentBoxList.removeClass('hidden');
        $('.default-placeholder-object-image').addClass('hidden');

        _.forEach(files, function (file) {
          var template = $(document).find('#object_select_image_template').html();
          var imageBox = template.replace(/__name__/gi, $el.attr('data-name'));
          var $template = $('<li class="object-image-item-handler">' + imageBox + '</li>');
          $template.find('.image-data').val(file.url);
          $template.find('.preview_image').attr('src', file.thumb).show();
          $currentBoxList.append($template);
        });
      }
    });
    new RvMediaStandAlone('.images-wrapper .btn-trigger-edit-object-image', {
      onSelectFiles: function onSelectFiles(files, $el) {
        var firstItem = _.first(files);

        var $currentBox = $el.closest('.object-image-item-handler').find('.image-box');
        var $currentBoxList = $el.closest('.list-gallery-media-images');
        $currentBox.find('.image-data').val(firstItem.url);
        $currentBox.find('.preview_image').attr('src', firstItem.thumb).show();

        _.forEach(files, function (file, index) {
          if (!index) {
            return;
          }

          var template = $(document).find('#object_select_image_template').html();
          var imageBox = template.replace(/__name__/gi, $currentBox.find('.image-data').attr('name'));
          var $template = $('<li class="object-image-item-handler">' + imageBox + '</li>');
          $template.find('.image-data').val(file.url);
          $template.find('.preview_image').attr('src', file.thumb).show();
          $currentBoxList.append($template);
        });
      }
    });
  }
};
$(document).ready(function () {
  RealEstate.init();
  $('body').on('click', '.list-gallery-media-images .btn_remove_image', function (event) {
    event.preventDefault();
    $(this).closest('li').remove();
  });
  $(document).on('click', '.btn-trigger-remove-object-image', function (event) {
    event.preventDefault();
    $(this).closest('.object-image-item-handler').remove();

    if ($('.list-gallery-media-images').find('.object-image-item-handler').length === 0) {
      $('.default-placeholder-object-image').removeClass('hidden');
    }
  });
  $(document).on('change', '#type', function (event) {
    if ($(event.currentTarget).val() === 'rent') {
      $('#period').closest('.form-group').removeClass('hidden').fadeIn();
    } else {
      $('#period').closest('.form-group').addClass('hidden').fadeOut();
    }
  });
});

/***/ }),

/***/ 38:
/*!*******************************************************************************!*\
  !*** multi ./Modules/Plugins/real-estate/resources/assets/js/real-estate.js ***!
  \*******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/odisoedim/webzone/islandhomes/Modules/Plugins/real-estate/resources/assets/js/real-estate.js */"./Modules/Plugins/real-estate/resources/assets/js/real-estate.js");


/***/ })

/******/ });