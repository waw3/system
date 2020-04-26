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
/******/ 	return __webpack_require__(__webpack_require__.s = 33);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/Plugins/custom-field/resources/assets/js/import-field-group.js":
/*!*********************************************************************************!*\
  !*** ./Modules/Plugins/custom-field/resources/assets/js/import-field-group.js ***!
  \*********************************************************************************/
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

(function ($) {
  var $body = $('body');
  $body.on('click', 'form.import-field-group button.btn.btn-secondary.action-item:nth-child(2)', function (event) {
    event.preventDefault();
    event.stopPropagation();
    var $form = $(event.currentTarget).closest('form');
    $form.find('input[type=file]').val('').trigger('click');
  });
  $body.on('change', 'form.import-field-group input[type=file]', function (event) {
    var $form = $(event.currentTarget).closest('form');
    var file = event.currentTarget.files[0];

    if (file) {
      var reader = new FileReader();
      reader.readAsText(file);

      reader.onload = function (e) {
        var json = Helpers.jsonDecode(e.target.result);
        $.ajax({
          url: $form.attr('action'),
          type: 'POST',
          data: {
            json_data: json
          },
          dataType: 'json',
          beforeSend: function beforeSend() {
            Botble.blockUI();
          },
          success: function success(res) {
            Botble.showNotice(res.error ? 'error' : 'success', res.messages);

            if (!res.error) {
              if (window.LaravelDataTables['table-custom-fields']) {
                window.LaravelDataTables['table-custom-fields'].draw();
              }
            }

            Botble.unblockUI();
          },
          complete: function complete() {
            Botble.unblockUI();
          },
          error: function error() {
            Botble.showError('Some error occurred');
          }
        });
      };
    }
  });
})(jQuery);

/***/ }),

/***/ 33:
/*!***************************************************************************************!*\
  !*** multi ./Modules/Plugins/custom-field/resources/assets/js/import-field-group.js ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/willy/Sites/botble/Modules/Plugins/custom-field/resources/assets/js/import-field-group.js */"./Modules/Plugins/custom-field/resources/assets/js/import-field-group.js");


/***/ })

/******/ });