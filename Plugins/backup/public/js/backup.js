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
/******/ 	return __webpack_require__(__webpack_require__.s = 28);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/Plugins/backup/resources/assets/js/backup.js":
/*!***************************************************************!*\
  !*** ./Modules/Plugins/backup/resources/assets/js/backup.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var BackupManagement = /*#__PURE__*/function () {
  function BackupManagement() {
    _classCallCheck(this, BackupManagement);
  }

  _createClass(BackupManagement, [{
    key: "init",
    value: function init() {
      var table_backup = $('#table-backups');
      table_backup.on('click', '.deleteDialog', function (event) {
        event.preventDefault();
        $('.delete-crud-entry').data('section', $(event.currentTarget).data('section'));
        $('.modal-confirm-delete').modal('show');
      });
      table_backup.on('click', '.restoreBackup', function (event) {
        event.preventDefault();
        $('#restore-backup-button').data('section', $(event.currentTarget).data('section'));
        $('#restore-backup-modal').modal('show');
      });
      $('.delete-crud-entry').on('click', function (event) {
        event.preventDefault();
        $('.modal-confirm-delete').modal('hide');
        var deleteURL = $(event.currentTarget).data('section');
        $.ajax({
          url: deleteURL,
          type: 'DELETE',
          success: function success(data) {
            if (data.error) {
              Botble.showError(data.message);
            } else {
              table_backup.find('a[data-section="' + deleteURL + '"]').closest('tr').remove();
              Botble.showSuccess(data.message);
            }
          },
          error: function error(data) {
            Botble.handleError(data);
          }
        });
      });
      $('#restore-backup-button').on('click', function (event) {
        event.preventDefault();

        var _self = $(event.currentTarget);

        _self.addClass('button-loading');

        $.ajax({
          url: _self.data('section'),
          type: 'GET',
          success: function success(data) {
            _self.removeClass('button-loading');

            _self.closest('.modal').modal('hide');

            if (data.error) {
              Botble.showError(data.message);
            } else {
              Botble.showSuccess(data.message);
              window.location.reload();
            }
          },
          error: function error(data) {
            _self.removeClass('button-loading');

            Botble.handleError(data);
          }
        });
      });
      $(document).on('click', '#generate_backup', function (event) {
        event.preventDefault();
        $('#name').val('');
        $('#description').val('');
        $('#create-backup-modal').modal('show');
      });
      $('#create-backup-modal').on('click', '#create-backup-button', function (event) {
        event.preventDefault();

        var _self = $(event.currentTarget);

        _self.addClass('button-loading');

        var name = $('#name').val();
        var description = $('#description').val();
        var error = false;

        if (name === '' || name === null) {
          error = true;
          Botble.showError('Backup name is required!');
        }

        if (description === '' || description === null) {
          error = true;
          Botble.showError('Backup description is required!');
        }

        if (!error) {
          $.ajax({
            url: $('div[data-route-create]').data('route-create'),
            type: 'POST',
            data: {
              name: name,
              description: description
            },
            success: function success(data) {
              _self.removeClass('button-loading');

              _self.closest('.modal').modal('hide');

              if (data.error) {
                Botble.showError(data.message);
              } else {
                table_backup.find('.no-backup-row').remove();
                table_backup.find('tbody').append(data.data);
                Botble.showSuccess(data.message);
              }
            },
            error: function error(data) {
              _self.removeClass('button-loading');

              Botble.handleError(data);
            }
          });
        } else {
          _self.removeClass('button-loading');
        }
      });
    }
  }]);

  return BackupManagement;
}();

$(document).ready(function () {
  new BackupManagement().init();
});

/***/ }),

/***/ 28:
/*!*********************************************************************!*\
  !*** multi ./Modules/Plugins/backup/resources/assets/js/backup.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/willy/Sites/botble/Modules/Plugins/backup/resources/assets/js/backup.js */"./Modules/Plugins/backup/resources/assets/js/backup.js");


/***/ })

/******/ });