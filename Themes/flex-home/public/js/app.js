/******/
(function (modules) { // webpackBootstrap
    /******/ 	// The module cache
    /******/
    var installedModules = {};
    /******/
    /******/ 	// The require function
    /******/
    function __webpack_require__(moduleId) {
        /******/
        /******/ 		// Check if module is in cache
        /******/
        if (installedModules[moduleId]) {
            /******/
            return installedModules[moduleId].exports;
            /******/
        }
        /******/ 		// Create a new module (and put it into the cache)
        /******/
        var module = installedModules[moduleId] = {
            /******/            i: moduleId,
            /******/            l: false,
            /******/            exports: {}
            /******/
        };
        /******/
        /******/ 		// Execute the module function
        /******/
        modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
        /******/
        /******/ 		// Flag the module as loaded
        /******/
        module.l = true;
        /******/
        /******/ 		// Return the exports of the module
        /******/
        return module.exports;
        /******/
    }

    /******/
    /******/
    /******/ 	// expose the modules object (__webpack_modules__)
    /******/
    __webpack_require__.m = modules;
    /******/
    /******/ 	// expose the module cache
    /******/
    __webpack_require__.c = installedModules;
    /******/
    /******/ 	// define getter function for harmony exports
    /******/
    __webpack_require__.d = function (exports, name, getter) {
        /******/
        if (!__webpack_require__.o(exports, name)) {
            /******/
            Object.defineProperty(exports, name, {enumerable: true, get: getter});
            /******/
        }
        /******/
    };
    /******/
    /******/ 	// define __esModule on exports
    /******/
    __webpack_require__.r = function (exports) {
        /******/
        if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
            /******/
            Object.defineProperty(exports, Symbol.toStringTag, {value: 'Module'});
            /******/
        }
        /******/
        Object.defineProperty(exports, '__esModule', {value: true});
        /******/
    };
    /******/
    /******/ 	// create a fake namespace object
    /******/ 	// mode & 1: value is a module id, require it
    /******/ 	// mode & 2: merge all properties of value into the ns
    /******/ 	// mode & 4: return value when already ns object
    /******/ 	// mode & 8|1: behave like require
    /******/
    __webpack_require__.t = function (value, mode) {
        /******/
        if (mode & 1) value = __webpack_require__(value);
        /******/
        if (mode & 8) return value;
        /******/
        if ((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
        /******/
        var ns = Object.create(null);
        /******/
        __webpack_require__.r(ns);
        /******/
        Object.defineProperty(ns, 'default', {enumerable: true, value: value});
        /******/
        if (mode & 2 && typeof value != 'string') for (var key in value) __webpack_require__.d(ns, key, function (key) {
            return value[key];
        }.bind(null, key));
        /******/
        return ns;
        /******/
    };
    /******/
    /******/ 	// getDefaultExport function for compatibility with non-harmony modules
    /******/
    __webpack_require__.n = function (module) {
        /******/
        var getter = module && module.__esModule ?
            /******/            function getDefault() {
                return module['default'];
            } :
            /******/            function getModuleExports() {
                return module;
            };
        /******/
        __webpack_require__.d(getter, 'a', getter);
        /******/
        return getter;
        /******/
    };
    /******/
    /******/ 	// Object.prototype.hasOwnProperty.call
    /******/
    __webpack_require__.o = function (object, property) {
        return Object.prototype.hasOwnProperty.call(object, property);
    };
    /******/
    /******/ 	// __webpack_public_path__
    /******/
    __webpack_require__.p = "/";
    /******/
    /******/
    /******/ 	// Load entry module and return exports
    /******/
    return __webpack_require__(__webpack_require__.s = 25);
    /******/
})
    /************************************************************************/
    /******/ ({

    /***/ "./platform/themes/flex-home/assets/js/app.js":
    /*!****************************************************!*\
      !*** ./platform/themes/flex-home/assets/js/app.js ***!
      \****************************************************/
    /*! no static exports found */
    /***/ (function (module, exports) {

        (function ($) {
            "use strict";

            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(document).on('click', '.generic-form button[type=submit]', function (event) {
                    var _this = this;

                    event.preventDefault();
                    event.stopPropagation();
                    var buttonText = $(this).text();
                    $(this).prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                    $.ajax({
                        type: 'POST',
                        cache: false,
                        url: $(this).closest('form').prop('action'),
                        data: new FormData($(this).closest('form')[0]),
                        contentType: false,
                        processData: false,
                        success: function success(res) {
                            $(_this).closest('form').find('.text-success').html('').hide();
                            $(_this).closest('form').find('.text-danger').html('').hide();

                            if (!res.error) {
                                $(_this).closest('form').find('input[type=text]:not([readonly])').val('');
                                $(_this).closest('form').find('input[type=email]').val('');
                                $(_this).closest('form').find('input[type=url]').val('');
                                $(_this).closest('form').find('input[type=tel]').val('');
                                $(_this).closest('form').find('select').val('');
                                $(_this).closest('form').find('textarea').val('');
                                $(_this).closest('form').find('.text-success').html(res.message).show();

                                if (res.data && res.data.next_page) {
                                    window.location.href = res.data.next_page;
                                }

                                setTimeout(function () {
                                    $(this).closest('form').find('.text-success').html('').hide();
                                }, 5000);
                            } else {
                                $(_this).closest('form').find('.text-danger').html(res.message).show();
                                setTimeout(function () {
                                    $(this).closest('form').find('.text-danger').html('').hide();
                                }, 5000);
                            }

                            $(_this).prop('disabled', false).html(buttonText);
                        },
                        error: function error(res) {
                            $(_this).prop('disabled', false).html(buttonText);
                            handleError(res, $(_this).closest('form'));
                        }
                    });
                });

                var handleError = function handleError(data, form) {
                    if (typeof data.errors !== 'undefined' && !_.isArray(data.errors)) {
                        handleValidationError(data.errors, form);
                    } else {
                        if (typeof data.responseJSON !== 'undefined') {
                            if (typeof data.responseJSON.errors !== 'undefined') {
                                if (data.status === 422) {
                                    handleValidationError(data.responseJSON.errors, form);
                                }
                            } else if (typeof data.responseJSON.message !== 'undefined') {
                                $(form).find('.text-danger').html(data.responseJSON.message).show();
                            } else {
                                var message = '';
                                $.each(data.responseJSON, function (index, el) {
                                    $.each(el, function (key, item) {
                                        message += item + '<br />';
                                    });
                                });
                                $(form).find('.text-danger').html(message).show();
                            }
                        } else {
                            $(form).find('.text-danger').html(data.statusText).show();
                        }
                    }
                };

                var handleValidationError = function handleValidationError(errors, form) {
                    var message = '';
                    $.each(errors, function (index, item) {
                        message += item + '<br />';
                    });
                    $(form).find('.text-success').html('').hide();
                    $(form).find('.text-danger').html('').hide();
                    $(form).find('.text-danger').html(message).show();
                };

                $('#cityslide').owlCarousel({
                    margin: 20,
                    dots: false,
                    nav: true,
                    navText: [$('.am-prev'), $('.am-next')],
                    loop: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        400: {
                            items: 2
                        },
                        800: {
                            items: 3
                        },
                        1000: {
                            items: 4
                        },
                        1300: {
                            items: 5
                        }
                    }
                });
                $('#listcarousel').owlCarousel({
                    margin: 0,
                    loop: true,
                    autoplay: true,
                    lazyLoad: true,
                    dots: false,
                    nav: false,
                    center: true,
                    responsive: {
                        300: {
                            items: 1
                        },
                        900: {
                            items: 2
                        },
                        1100: {
                            items: 3
                        }
                    }
                });
                $('#listcarouselthumb').owlCarousel({
                    margin: 0,
                    dots: false,
                    loop: true,
                    autoplay: true,
                    lazyLoad: true,
                    nav: true,
                    navText: [$('.ar-prev'), $('.ar-next')],
                    responsive: {
                        300: {
                            items: 3
                        },
                        900: {
                            items: 6
                        },
                        1100: {
                            items: 8
                        }
                    }
                });
                $('.showfullimg').on('click', function () {
                    var idx = $(this).attr('rel');
                    var $gallery = $('#gallery');
                    $gallery.imagesGrid({
                        images: $gallery.data('images'),
                        align: true,
                        onModalClose: function onModalClose() {
                            $('#gallery').imagesGrid('destroy');
                        }
                    });
                    $gallery.imagesGrid('modal.open', idx);
                });
                var typeSearch = 'project';
                var txtKey = $('#txtkey');
                var homeTypeSearch = $('#hometypesearch');
                homeTypeSearch.find('a').on('click', function () {
                    $('.listsuggest').html('').hide();
                    txtKey.val('');
                    typeSearch = $(this).attr('rel');
                    homeTypeSearch.find('a').removeClass('active');
                    $(this).addClass('active');
                    $('#txttypesearch').val(typeSearch);
                    $('#frmhomesearch').prop('action', $(this).data('url'));
                });
                var timeout = null;
                txtKey.on('keydown', function () {
                    $('.listsuggest').html('').hide();
                });
                txtKey.on('keyup', function () {
                    var k = $(this).val();
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        // Do AJAX shit here
                        $.get($('#frmhomesearch').prop('action') + '?type=' + typeSearch + '&k=' + k, function (data) {
                            if (!data.error && data.data !== '') {
                                $('.listsuggest').html(data.data).show();
                            } else {
                                $('.listsuggest').html('').hide();
                            }
                        });
                    }, 500);
                });
                var lazyloadImages = document.querySelectorAll('img.lazy');
                var lazyloadThrottleTimeout;

                function lazyload() {
                    if (lazyloadThrottleTimeout) {
                        clearTimeout(lazyloadThrottleTimeout);
                    }

                    lazyloadThrottleTimeout = setTimeout(function () {
                        var scrollTop = window.pageYOffset;
                        lazyloadImages.forEach(function (img) {
                            if (img.offsetTop < window.innerHeight + scrollTop) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                            }
                        });

                        if (lazyloadImages.length == 0) {
                            document.removeEventListener('scroll', lazyload);
                            window.removeEventListener('resize', lazyload);
                            window.removeEventListener('orientationChange', lazyload);
                        }
                    }, 200);
                }

                lazyload();
                $(document).scroll(function () {
                    var scroll = window.pageYOffset;

                    if (scroll > 0) {
                        $('.cd-top').find('.fas').attr('class', 'fas fa-arrow-up');
                    } else {
                        $('.cd-top').find('.fas').attr('class', 'fas fa-arrow-down');
                    }
                });
                $('.pagination').addClass('pagination-sm');
                $('[data-toggle="tooltip"]').tooltip();
                $(document).on('click', '.cd-top', function (event) {
                    event.preventDefault();
                    var top = $('html').scrollTop();

                    if (top > 0) {
                        $('body,html').animate({
                            scrollTop: 0
                        }, 800);
                    } else {
                        $('body,html').animate({
                            scrollTop: $('html').height()
                        }, 800);
                    }

                    return false;
                });
            });
        })(jQuery);

        /***/
    }),

    /***/ 25:
    /*!**********************************************************!*\
      !*** multi ./platform/themes/flex-home/assets/js/app.js ***!
      \**********************************************************/
    /*! no static exports found */
    /***/ (function (module, exports, __webpack_require__) {

        module.exports = __webpack_require__(/*! /Users/odisoedim/webzone/islandhomes/platform/themes/flex-home/assets/js/app.js */"./platform/themes/flex-home/assets/js/app.js");


        /***/
    })

    /******/
});
