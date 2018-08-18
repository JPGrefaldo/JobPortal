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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/scripts.js":
/***/ (function(module, exports) {

eval("jQuery(document).ready(function ($) {\n\n\t//Animate scroll\n\t$('.btn-skip').click(function () {\n\t\t$('html, body').animate({\n\t\t\tscrollTop: $(\"#content\").offset().top - 15\n\t\t}, 800);\n\t});\n\n\t//Toggle Mobile Navigation\n\t$('.btn-nav').on('click', function (e) {\n\t\t$('body').toggleClass('nav-open');\n\t\te.preventDefault();\n\t});\n\n\t//Toggle Menu\n\t$('.has-menu').click(function (e) {\n\t\t$(this).toggleClass('is-open');\n\t\te.preventDefault();\n\t});\n\n\t//Testimonial slider\n\t$('.testimonial-slider').slick({\n\t\tdots: true,\n\t\tinfinite: true,\n\t\tspeed: 800,\n\t\tslidesToShow: 3,\n\t\tslidesToScroll: 3,\n\t\tswipeToSlide: true,\n\t\tresponsive: [{\n\t\t\tbreakpoint: 560,\n\t\t\tsettings: {\n\t\t\t\tslidesToShow: 1,\n\t\t\t\tslidesToScroll: 1\n\t\t\t}\n\t\t}]\n\t});\n\n\t// Scroll Reveal\n\twindow.sr = ScrollReveal({\n\t\treset: false, //inverse animation for testing\n\t\tscale: 1,\n\t\teasing: 'cubic-bezier(0.6, 0.2, 0.1, 1)',\n\t\tmobile: true,\n\t\tviewFactor: 0.2,\n\t\tdistance: '60px',\n\t\tduration: 800,\n\t\torigin: 'bottom',\n\t\tviewOffset: { top: 0, right: 0, bottom: 0, left: 0 }\n\t});\n\n\t// Custom Settings\n\tsr.reveal('.fade-up', {\n\t\tdelay: 0,\n\t\treset: false\n\t});\n\n\tsr.reveal('.fade-up-1', {\n\t\tdelay: 200,\n\t\treset: false\n\t});\n\n\tsr.reveal('.fade-up-2', {\n\t\tdelay: 400,\n\t\treset: false\n\t});\n\n\tsr.reveal('.fade-up-3', {\n\t\tdelay: 600,\n\t\treset: false\n\t});\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3NjcmlwdHMuanM/NjBmNiJdLCJuYW1lcyI6WyJqUXVlcnkiLCJkb2N1bWVudCIsInJlYWR5IiwiJCIsImNsaWNrIiwiYW5pbWF0ZSIsInNjcm9sbFRvcCIsIm9mZnNldCIsInRvcCIsIm9uIiwiZSIsInRvZ2dsZUNsYXNzIiwicHJldmVudERlZmF1bHQiLCJzbGljayIsImRvdHMiLCJpbmZpbml0ZSIsInNwZWVkIiwic2xpZGVzVG9TaG93Iiwic2xpZGVzVG9TY3JvbGwiLCJzd2lwZVRvU2xpZGUiLCJyZXNwb25zaXZlIiwiYnJlYWtwb2ludCIsInNldHRpbmdzIiwid2luZG93Iiwic3IiLCJTY3JvbGxSZXZlYWwiLCJyZXNldCIsInNjYWxlIiwiZWFzaW5nIiwibW9iaWxlIiwidmlld0ZhY3RvciIsImRpc3RhbmNlIiwiZHVyYXRpb24iLCJvcmlnaW4iLCJ2aWV3T2Zmc2V0IiwicmlnaHQiLCJib3R0b20iLCJsZWZ0IiwicmV2ZWFsIiwiZGVsYXkiXSwibWFwcGluZ3MiOiJBQUFBQSxPQUFPQyxRQUFQLEVBQWlCQyxLQUFqQixDQUF1QixVQUFVQyxDQUFWLEVBQWE7O0FBRW5DO0FBQ0FBLEdBQUUsV0FBRixFQUFlQyxLQUFmLENBQXFCLFlBQVk7QUFDaENELElBQUUsWUFBRixFQUFnQkUsT0FBaEIsQ0FBd0I7QUFDdkJDLGNBQVdILEVBQUUsVUFBRixFQUFjSSxNQUFkLEdBQXVCQyxHQUF2QixHQUE2QjtBQURqQixHQUF4QixFQUVHLEdBRkg7QUFHQSxFQUpEOztBQU1BO0FBQ0FMLEdBQUUsVUFBRixFQUFjTSxFQUFkLENBQWlCLE9BQWpCLEVBQTBCLFVBQVVDLENBQVYsRUFBYTtBQUN0Q1AsSUFBRSxNQUFGLEVBQVVRLFdBQVYsQ0FBc0IsVUFBdEI7QUFDQUQsSUFBRUUsY0FBRjtBQUNBLEVBSEQ7O0FBS0E7QUFDQVQsR0FBRSxXQUFGLEVBQWVDLEtBQWYsQ0FBcUIsVUFBVU0sQ0FBVixFQUFhO0FBQ2pDUCxJQUFFLElBQUYsRUFBUVEsV0FBUixDQUFvQixTQUFwQjtBQUNBRCxJQUFFRSxjQUFGO0FBQ0EsRUFIRDs7QUFLQTtBQUNBVCxHQUFFLHFCQUFGLEVBQXlCVSxLQUF6QixDQUErQjtBQUM5QkMsUUFBTSxJQUR3QjtBQUU5QkMsWUFBVSxJQUZvQjtBQUc5QkMsU0FBTyxHQUh1QjtBQUk5QkMsZ0JBQWMsQ0FKZ0I7QUFLOUJDLGtCQUFnQixDQUxjO0FBTTlCQyxnQkFBYyxJQU5nQjtBQU85QkMsY0FBWSxDQUFDO0FBQ1pDLGVBQVksR0FEQTtBQUVaQyxhQUFVO0FBQ1RMLGtCQUFjLENBREw7QUFFVEMsb0JBQWdCO0FBRlA7QUFGRSxHQUFEO0FBUGtCLEVBQS9COztBQWdCQTtBQUNBSyxRQUFPQyxFQUFQLEdBQVlDLGFBQWE7QUFDeEJDLFNBQU8sS0FEaUIsRUFDVjtBQUNkQyxTQUFPLENBRmlCO0FBR3hCQyxVQUFRLGdDQUhnQjtBQUl4QkMsVUFBUSxJQUpnQjtBQUt4QkMsY0FBWSxHQUxZO0FBTXhCQyxZQUFVLE1BTmM7QUFPeEJDLFlBQVUsR0FQYztBQVF4QkMsVUFBUSxRQVJnQjtBQVN4QkMsY0FBWSxFQUFFMUIsS0FBSyxDQUFQLEVBQVUyQixPQUFPLENBQWpCLEVBQW9CQyxRQUFRLENBQTVCLEVBQStCQyxNQUFNLENBQXJDO0FBVFksRUFBYixDQUFaOztBQVlBO0FBQ0FiLElBQUdjLE1BQUgsQ0FBVSxVQUFWLEVBQXNCO0FBQ3JCQyxTQUFPLENBRGM7QUFFckJiLFNBQU87QUFGYyxFQUF0Qjs7QUFLQUYsSUFBR2MsTUFBSCxDQUFVLFlBQVYsRUFBd0I7QUFDdkJDLFNBQU8sR0FEZ0I7QUFFdkJiLFNBQU87QUFGZ0IsRUFBeEI7O0FBS0FGLElBQUdjLE1BQUgsQ0FBVSxZQUFWLEVBQXdCO0FBQ3ZCQyxTQUFPLEdBRGdCO0FBRXZCYixTQUFPO0FBRmdCLEVBQXhCOztBQUtBRixJQUFHYyxNQUFILENBQVUsWUFBVixFQUF3QjtBQUN2QkMsU0FBTyxHQURnQjtBQUV2QmIsU0FBTztBQUZnQixFQUF4QjtBQUtBLENBeEVEIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzLmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsialF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbiAoJCkge1xyXG5cclxuXHQvL0FuaW1hdGUgc2Nyb2xsXHJcblx0JCgnLmJ0bi1za2lwJykuY2xpY2soZnVuY3Rpb24gKCkge1xyXG5cdFx0JCgnaHRtbCwgYm9keScpLmFuaW1hdGUoe1xyXG5cdFx0XHRzY3JvbGxUb3A6ICQoXCIjY29udGVudFwiKS5vZmZzZXQoKS50b3AgLSAxNVxyXG5cdFx0fSwgODAwKTtcclxuXHR9KVxyXG5cclxuXHQvL1RvZ2dsZSBNb2JpbGUgTmF2aWdhdGlvblxyXG5cdCQoJy5idG4tbmF2Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKGUpIHtcclxuXHRcdCQoJ2JvZHknKS50b2dnbGVDbGFzcygnbmF2LW9wZW4nKTtcclxuXHRcdGUucHJldmVudERlZmF1bHQoKTtcclxuXHR9KVxyXG5cclxuXHQvL1RvZ2dsZSBNZW51XHJcblx0JCgnLmhhcy1tZW51JykuY2xpY2soZnVuY3Rpb24gKGUpIHtcclxuXHRcdCQodGhpcykudG9nZ2xlQ2xhc3MoJ2lzLW9wZW4nKTtcclxuXHRcdGUucHJldmVudERlZmF1bHQoKTtcclxuXHR9KVxyXG5cclxuXHQvL1Rlc3RpbW9uaWFsIHNsaWRlclxyXG5cdCQoJy50ZXN0aW1vbmlhbC1zbGlkZXInKS5zbGljayh7XHJcblx0XHRkb3RzOiB0cnVlLFxyXG5cdFx0aW5maW5pdGU6IHRydWUsXHJcblx0XHRzcGVlZDogODAwLFxyXG5cdFx0c2xpZGVzVG9TaG93OiAzLFxyXG5cdFx0c2xpZGVzVG9TY3JvbGw6IDMsXHJcblx0XHRzd2lwZVRvU2xpZGU6IHRydWUsXHJcblx0XHRyZXNwb25zaXZlOiBbe1xyXG5cdFx0XHRicmVha3BvaW50OiA1NjAsXHJcblx0XHRcdHNldHRpbmdzOiB7XHJcblx0XHRcdFx0c2xpZGVzVG9TaG93OiAxLFxyXG5cdFx0XHRcdHNsaWRlc1RvU2Nyb2xsOiAxXHJcblx0XHRcdH1cclxuXHRcdH1dXHJcblx0fSk7XHJcblxyXG5cdC8vIFNjcm9sbCBSZXZlYWxcclxuXHR3aW5kb3cuc3IgPSBTY3JvbGxSZXZlYWwoeyBcclxuXHRcdHJlc2V0OiBmYWxzZSwgLy9pbnZlcnNlIGFuaW1hdGlvbiBmb3IgdGVzdGluZ1xyXG5cdFx0c2NhbGU6IDEsXHJcblx0XHRlYXNpbmc6ICdjdWJpYy1iZXppZXIoMC42LCAwLjIsIDAuMSwgMSknLFxyXG5cdFx0bW9iaWxlOiB0cnVlLFxyXG5cdFx0dmlld0ZhY3RvcjogMC4yLFxyXG5cdFx0ZGlzdGFuY2U6ICc2MHB4JyxcclxuXHRcdGR1cmF0aW9uOiA4MDAsXHJcblx0XHRvcmlnaW46ICdib3R0b20nLFxyXG5cdFx0dmlld09mZnNldDogeyB0b3A6IDAsIHJpZ2h0OiAwLCBib3R0b206IDAsIGxlZnQ6IDAgfVxyXG5cdH0pO1xyXG5cclxuXHQvLyBDdXN0b20gU2V0dGluZ3NcclxuXHRzci5yZXZlYWwoJy5mYWRlLXVwJywgeyBcdFx0XHJcblx0XHRkZWxheTogMCxcclxuXHRcdHJlc2V0OiBmYWxzZVx0XHJcblx0fSk7XHJcblxyXG5cdHNyLnJldmVhbCgnLmZhZGUtdXAtMScsIHsgXHRcdFxyXG5cdFx0ZGVsYXk6IDIwMCxcdFxyXG5cdFx0cmVzZXQ6IGZhbHNlXHJcblx0fSk7XHJcblxyXG5cdHNyLnJldmVhbCgnLmZhZGUtdXAtMicsIHsgXHRcdFxyXG5cdFx0ZGVsYXk6IDQwMCxcdFxyXG5cdFx0cmVzZXQ6IGZhbHNlXHJcblx0fSk7XHJcblxyXG5cdHNyLnJldmVhbCgnLmZhZGUtdXAtMycsIHsgXHRcdFxyXG5cdFx0ZGVsYXk6IDYwMCxcdFxyXG5cdFx0cmVzZXQ6IGZhbHNlXHJcblx0fSk7XHJcblxyXG59KTtcclxuXHJcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy5qcyJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/assets/js/scripts.js\n");

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/scripts.js");


/***/ })

/******/ });