/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.l = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };

/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};

/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};

/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "./";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

$('.hamburger').click(function () {
	if ($('.nav-left').length) {
		if ($('.nav-left').css('display') === 'block') {
			$('.nav-left').css('display', '');
		} else {
			$('.nav-left').css('display', 'block');
		}
	}

	if ($('.nav-right').length) {
		if ($('.nav-right').css('display') === 'block') {
			$('.nav-right').css('display', '');
		} else {
			$('.nav-right').css('display', 'block');
		}
	}
});

$(window).on('resize', function () {
	if ($('.hamburger').is(':visible')) {
		if ($('.nav-left').length) $('.nav-left').css('display', '');
		if ($('.nav-right').length) $('.nav-right').css('display', '');
	}
});

$('[modal]').click(function () {
	$('#' + $(this).attr('modal')).fadeIn();
});

$('.close-modal').click(function () {
	$(this).parents('.modal').fadeOut();
});

$('.modal').on('click', function (e) {
	if (e.target !== this) return;
	$('.modal').hide();
});

$(document).on('click', '.close-alert', function () {
	$(this).parents('.alert').fadeOut(function () {
		$(this).remove();
	});
});

$(document).on('click', '.close-callout', function () {
	$(this).parents('.callout').fadeOut(function () {
		$(this).remove();
	});
});

/***/ }),
/* 1 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(0);
module.exports = __webpack_require__(1);


/***/ })
/******/ ]);