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
/******/ 	return __webpack_require__(__webpack_require__.s = 26);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/Plugins/analytics/resources/assets/js/analytics.js":
/*!*********************************************************************!*\
  !*** ./Modules/Plugins/analytics/resources/assets/js/analytics.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var PluginAnalytics = /*#__PURE__*/function () {
  function PluginAnalytics() {
    _classCallCheck(this, PluginAnalytics);
  }

  _createClass(PluginAnalytics, null, [{
    key: "initCharts",
    value: function initCharts() {
      var stats = $('div[data-stats]').data('stats');
      var country_stats = $('div[data-country-stats]').data('country-stats');
      var lang_page_views = $('div[data-lang-pageviews]').data('lang-pageviews');
      var lang_visits = $('div[data-lang-visits]').data('lang-visits');
      var statArray = [];
      $.each(stats, function (index, el) {
        statArray.push({
          axis: el.axis,
          visitors: el.visitors,
          pageViews: el.pageViews
        });
      });
      new Morris.Area({
        element: 'stats-chart',
        resize: true,
        data: statArray,
        xkey: 'axis',
        ykeys: ['visitors', 'pageViews'],
        labels: [lang_visits, lang_page_views],
        lineColors: ['#DD4D37', '#3c8dbc'],
        hideHover: 'auto',
        parseTime: false
      });
      var visitorsData = {};
      $.each(country_stats, function (index, el) {
        visitorsData[el[0]] = el[1];
      });
      $(document).find('#world-map').vectorMap({
        map: 'world_mill_en',
        backgroundColor: 'transparent',
        regionStyle: {
          initial: {
            fill: '#e4e4e4',
            'fill-opacity': 1,
            stroke: 'none',
            'stroke-width': 0,
            'stroke-opacity': 1
          }
        },
        series: {
          regions: [{
            values: visitorsData,
            scale: ['#C64333', '#dd4b39'],
            normalizeFunction: 'polynomial'
          }]
        },
        onRegionLabelShow: function onRegionLabelShow(e, el, code) {
          if (typeof visitorsData[code] !== 'undefined') {
            el.html(el.html() + ': ' + visitorsData[code] + ' ' + lang_visits);
          }
        }
      });
    }
  }]);

  return PluginAnalytics;
}();

$(document).ready(function () {
  BDashboard.loadWidget($('#widget_analytics_general').find('.widget-content'), route('analytics.general'), null, function () {
    PluginAnalytics.initCharts();
  });
  $(document).on('click', '#widget_analytics_general .portlet > .portlet-title .tools > a.reload', function (event) {
    event.preventDefault();
    BDashboard.loadWidget($('#widget_analytics_general').find('.widget-content'), route('analytics.general'), null, function () {
      PluginAnalytics.initCharts();
    });
  });
  BDashboard.loadWidget($('#widget_analytics_page').find('.widget-content'), route('analytics.page'));
  BDashboard.loadWidget($('#widget_analytics_browser').find('.widget-content'), route('analytics.browser'));
  BDashboard.loadWidget($('#widget_analytics_referrer').find('.widget-content'), route('analytics.referrer'));
});

/***/ }),

/***/ 26:
/*!***************************************************************************!*\
  !*** multi ./Modules/Plugins/analytics/resources/assets/js/analytics.js ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/willy/Sites/botble/Modules/Plugins/analytics/resources/assets/js/analytics.js */"./Modules/Plugins/analytics/resources/assets/js/analytics.js");


/***/ })

/******/ });