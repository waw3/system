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
/******/ 	return __webpack_require__(__webpack_require__.s = 42);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/Plugins/vendor/resources/assets/js/account-admin.js":
/*!**********************************************************************!*\
  !*** ./Modules/Plugins/vendor/resources/assets/js/account-admin.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $(document).on('click', '#is_change_password', function (event) {
    if ($(event.currentTarget).is(':checked')) {
      $('input[type=password]').closest('.form-group').removeClass('hidden').fadeIn();
    } else {
      $('input[type=password]').closest('.form-group').addClass('hidden').fadeOut();
    }
  });
  $(document).on('click', '.btn-trigger-add-credit', function (event) {
    event.preventDefault();
    $('#add-credit-modal').modal('show');
  });
  $(document).on('click', '#confirm-add-credit-button', function (event) {
    event.preventDefault();

    var _self = $(event.currentTarget);

    _self.addClass('button-loading');

    $.ajax({
      type: 'POST',
      cache: false,
      url: _self.closest('.modal-content').find('form').prop('action'),
      data: _self.closest('.modal-content').find('form').serialize(),
      success: function success(res) {
        if (!res.error) {
          Botble.showNotice('success', res.message);
          $('#add-credit-modal').modal('hide');
          $('#credit-histories').load($('.page-content form').prop('action') + ' #credit-histories > *');
        } else {
          Botble.showNotice('error', res.message);
        }

        _self.removeClass('button-loading');
      },
      error: function error(res) {
        Botble.handleError(res);

        _self.removeClass('button-loading');
      }
    });
  });
  $(document).on('click', '.show-timeline-dropdown', function (event) {
    event.preventDefault();
    $($(event.currentTarget).data('target')).slideToggle();
    $(event.currentTarget).closest('.comment-log-item').toggleClass('bg-white');
  });
});

/***/ }),

/***/ 42:
/*!****************************************************************************!*\
  !*** multi ./Modules/Plugins/vendor/resources/assets/js/account-admin.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/odisoedim/webzone/islandhomes/Modules/Plugins/vendor/resources/assets/js/account-admin.js */"./Modules/Plugins/vendor/resources/assets/js/account-admin.js");


/***/ })

/******/ });