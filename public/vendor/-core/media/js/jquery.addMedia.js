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
/******/ 	return __webpack_require__(__webpack_require__.s = 14);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./platform/core/media/resources/assets/js/jquery.addMedia.js":
/*!********************************************************************!*\
  !*** ./platform/core/media/resources/assets/js/jquery.addMedia.js ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/* ========================================================================
 * AddMedia.js v1.0
 * Requires Botble Media
 * ======================================================================== */
+function ($) {
  'use strict';
  /**
   * @param element
   * @param options
   * @constructor
   */

  var AddMedia = function AddMedia(element, options) {
    this.options = options;
    $(element).rvMedia({
      multiple: true,
      onSelectFiles: function onSelectFiles(files, $el) {
        if (typeof files !== 'undefined') {
          switch ($el.data('editor')) {
            case 'summernote':
              handleInsertImagesForSummerNote($el, files);
              break;

            case 'wysihtml5':
              var editor = $(options.target).data('wysihtml5').editor;
              handleInsertImagesForWysihtml5Editor(editor, files);
              break;

            case 'ckeditor':
              handleForCkeditor($el, files);
              break;

            case 'tinymce':
              handleForTinyMce(files);
              break;
          }
        }
      }
    });
  };

  AddMedia.VERSION = '1.1.0';
  /**
   * Insert images to summernote editor
   * @param $el
   * @param files
   */

  function handleInsertImagesForSummerNote($el, files) {
    if (files.length === 0) {
      return;
    }

    var instance = $el.data('target');

    for (var i = 0; i < files.length; i++) {
      if (files[i].type === 'youtube' || files[i].type === 'video') {
        var link = files[i].full_url;
        link = link.replace('watch?v=', 'embed/');
        $(instance).summernote('pasteHTML', '<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe>');
      } else if (files[i].type === 'image') {
        $(instance).summernote('insertImage', files[i].full_url, files[i].basename);
      } else {
        $(instance).summernote('pasteHTML', '<a href="' + files[i].full_url + '">' + files[i].full_url + '</a>');
      }
    }
  }
  /**
   * Insert images to Wysihtml5 editor
   * @param editor
   * @param files
   */


  function handleInsertImagesForWysihtml5Editor(editor, files) {
    if (files.length === 0) {
      return;
    } // insert images for the wysihtml5 editor


    var s = '';

    for (var i = 0; i < files.length; i++) {
      if (files[i].type === 'youtube' || files[i].type === 'video') {
        var link = files[i].full_url;
        link = link.replace('watch?v=', 'embed/');
        s += '<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe>';
      } else if (files[i].type === 'image') {
        s += '<img src="' + files[i].full_url + '">';
      } else {
        s += '<a href="' + files[i].full_url + '">' + files[i].full_url + '</a>';
      }
    }

    if (editor.getValue().length > 0) {
      var length = editor.getValue();
      editor.composer.commands.exec('insertHTML', s);

      if (editor.getValue() === length) {
        editor.setValue(editor.getValue() + s);
      }
    } else {
      editor.setValue(editor.getValue() + s);
    }
  }
  /**
   * @param $el
   * @param files
   */


  function handleForCkeditor($el, files) {
    $.each(files, function (index, file) {
      var link = file.full_url;
      var instance = $el.data('target').replace('#', '');

      if (file.type === 'youtube' || file.type === 'video') {
        link = link.replace('watch?v=', 'embed/');
        CKEDITOR.instances[instance].insertHtml('<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe>');
      } else if (file.type === 'image') {
        CKEDITOR.instances[instance].insertHtml('<img src="' + link + '" alt="' + file.name + '" />');
      } else {
        CKEDITOR.instances[instance].insertHtml('<a href="' + link + '">' + file.name + '</a>');
      }
    });
  }
  /**
   * @param files
   */


  function handleForTinyMce(files) {
    $.each(files, function (index, file) {
      var link = file.full_url;
      var html = '';

      if (file.type === 'youtube' || file.type === 'video') {
        link = link.replace('watch?v=', 'embed/');
        html = '<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe>';
      } else if (file.type === 'image') {
        html = '<img src="' + link + '" alt="' + file.name + '" />';
      } else {
        html = '<a href="' + link + '">' + file.name + '</a>';
      }

      tinymce.activeEditor.execCommand('mceInsertContent', false, html);
    });
  }
  /**
   * @param option
   */


  function callAction(option) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('bs.media');
      var options = $.extend({}, $this.data(), _typeof(option) === 'object' && option);
      if (!data) $this.data('bs.media', data = new AddMedia(this, options));
    });
  }

  $.fn.addMedia = callAction;
  $.fn.addMedia.Constructor = AddMedia;
  $(window).on('load', function () {
    $('[data-type="rv-media"]').each(function () {
      var $addMedia = $(this);
      callAction.call($addMedia, $addMedia.data());
    });
  });
}(jQuery);

/***/ }),

/***/ 14:
/*!**************************************************************************!*\
  !*** multi ./platform/core/media/resources/assets/js/jquery.addMedia.js ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/willy/Sites/botble/platform/core/media/resources/assets/js/jquery.addMedia.js */"./platform/core/media/resources/assets/js/jquery.addMedia.js");


/***/ })

/******/ });