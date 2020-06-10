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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Resources/assets/js/app.js":
/*!************************************!*\
  !*** ./Resources/assets/js/app.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var resetTabs = function resetTabs(container) {
  var activeLink = getActiveTabLink(container);
  var activePanel = $(activeLink.attr('href'));
  activeLink.removeClass('active'); // Fire utility event indicating that we are going
  // to hide the tab panel

  activePanel.trigger('curate.tabs.hide');
  activePanel.hide(function () {
    $(this).removeClass('show'); // Trigger event to indicate that the
    // tab panel is hidden

    $(this).trigger('curate.tabs.hidden');
  });
};

var showTab = function showTab(link) {
  var panel = $(link.attr('href'));
  link.addClass('active'); // Fire utility event indicating that we are going
  // to show the tab panel

  panel.trigger('curate.tabs.show');
  panel.show(function () {
    $(this).addClass('show'); // Trigger event to indicate that the
    // tab panel is shown

    $(this).trigger('curate.tabs.shown');
  });
};

var getActiveTabLink = function getActiveTabLink(container) {
  return container.find('.tab-link.active').first();
};

$(function () {
  $('a[aria-controls="tab"].tab-link').on('click', function (e) {
    e.preventDefault();
    var button = $(this);
    var link = button.closest('.tabs.tabs-nav');
    window.location.hash = '';
    resetTabs(link);
    showTab(button);
  }); // Listen to all tabs "show" events on tab panels

  $('.tab-panel').on('curate.tabs.show', function () {
    var id = $(this).attr('id');
    var panel = $('#' + id); // Make an AJAX request to get randomly generated text

    $.ajax({
      url: '/admins/text/random',
      data: {
        id: id
      },
      beforeSend: function beforeSend() {
        // Display the loading spinner
        panel.html('<div class="width-100% text-center icon-container">' + '<i class="fa fa-circle-notch spin color-primary"></i>' + '</div>');
      }
    }).done(function (response) {
      // Fill the tab panel with the text from the response
      panel.html(response.text);
    }).always(function () {
      panel.find('div.icon-container').remove();
    });
  }); // On page load, we want to show all of the "active" tab panels
  // Active panels can be determined by adding the "active" class
  // to the .tab-link

  $('a[aria-controls="tab"].tab-link.active').each(function () {
    $(this).trigger('click');
  });
});

/***/ }),

/***/ "./Resources/assets/sass/app.scss":
/*!****************************************!*\
  !*** ./Resources/assets/sass/app.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!***************************************************************************!*\
  !*** multi ./Resources/assets/js/app.js ./Resources/assets/sass/app.scss ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Projects\curateship\Modules\Admin\Resources\assets\js\app.js */"./Resources/assets/js/app.js");
module.exports = __webpack_require__(/*! C:\Projects\curateship\Modules\Admin\Resources\assets\sass\app.scss */"./Resources/assets/sass/app.scss");


/***/ })

/******/ });