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

eval("jQuery(document).ready(function ($) {\n\n\t//Animate scroll\n\t$('.btn-skip').click(function () {\n\t\t$('html, body').animate({\n\t\t\tscrollTop: $(\"#content\").offset().top - 15\n\t\t}, 800);\n\t});\n\n\t//Toggle Mobile Navigation\n\t$('.btn-nav').on('click', function (e) {\n\t\t$('body').toggleClass('nav-open');\n\t\te.preventDefault();\n\t});\n\n\t//Toggle Menu\n\t$('.has-menu').click(function (e) {\n\t\t$(this).toggleClass('is-open');\n\t\te.preventDefault();\n\t});\n\n\t//Testimonial slider\n\t$('.testimonial-slider').slick({\n\t\tdots: true,\n\t\tinfinite: true,\n\t\tspeed: 800,\n\t\tslidesToShow: 3,\n\t\tslidesToScroll: 3,\n\t\tswipeToSlide: true,\n\t\tresponsive: [{\n\t\t\tbreakpoint: 560,\n\t\t\tsettings: {\n\t\t\t\tslidesToShow: 1,\n\t\t\t\tslidesToScroll: 1\n\t\t\t}\n\t\t}]\n\t});\n\n\t// Scroll Reveal\n\twindow.sr = ScrollReveal({\n\t\treset: false, //inverse animation for testing\n\t\tscale: 1,\n\t\teasing: 'cubic-bezier(0.6, 0.2, 0.1, 1)',\n\t\tmobile: true,\n\t\tviewFactor: 0.2,\n\t\tdistance: '60px',\n\t\tduration: 800,\n\t\torigin: 'bottom',\n\t\tviewOffset: { top: 0, right: 0, bottom: 0, left: 0 }\n\t});\n\n\t// Custom Settings\n\tsr.reveal('.fade-up', {\n\t\tdelay: 0,\n\t\treset: false\n\t});\n\n\tsr.reveal('.fade-up-1', {\n\t\tdelay: 200,\n\t\treset: false\n\t});\n\n\tsr.reveal('.fade-up-2', {\n\t\tdelay: 400,\n\t\treset: false\n\t});\n\n\tsr.reveal('.fade-up-3', {\n\t\tdelay: 600,\n\t\treset: false\n\t});\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3NjcmlwdHMuanM/NjBmNiJdLCJuYW1lcyI6WyJqUXVlcnkiLCJkb2N1bWVudCIsInJlYWR5IiwiJCIsImNsaWNrIiwiYW5pbWF0ZSIsInNjcm9sbFRvcCIsIm9mZnNldCIsInRvcCIsIm9uIiwiZSIsInRvZ2dsZUNsYXNzIiwicHJldmVudERlZmF1bHQiLCJzbGljayIsImRvdHMiLCJpbmZpbml0ZSIsInNwZWVkIiwic2xpZGVzVG9TaG93Iiwic2xpZGVzVG9TY3JvbGwiLCJzd2lwZVRvU2xpZGUiLCJyZXNwb25zaXZlIiwiYnJlYWtwb2ludCIsInNldHRpbmdzIiwid2luZG93Iiwic3IiLCJTY3JvbGxSZXZlYWwiLCJyZXNldCIsInNjYWxlIiwiZWFzaW5nIiwibW9iaWxlIiwidmlld0ZhY3RvciIsImRpc3RhbmNlIiwiZHVyYXRpb24iLCJvcmlnaW4iLCJ2aWV3T2Zmc2V0IiwicmlnaHQiLCJib3R0b20iLCJsZWZ0IiwicmV2ZWFsIiwiZGVsYXkiXSwibWFwcGluZ3MiOiJBQUFBQSxPQUFPQyxRQUFQLEVBQWlCQyxLQUFqQixDQUF1QixVQUFVQyxDQUFWLEVBQWE7O0FBRW5DO0FBQ0FBLEdBQUUsV0FBRixFQUFlQyxLQUFmLENBQXFCLFlBQVk7QUFDaENELElBQUUsWUFBRixFQUFnQkUsT0FBaEIsQ0FBd0I7QUFDdkJDLGNBQVdILEVBQUUsVUFBRixFQUFjSSxNQUFkLEdBQXVCQyxHQUF2QixHQUE2QjtBQURqQixHQUF4QixFQUVHLEdBRkg7QUFHQSxFQUpEOztBQU1BO0FBQ0FMLEdBQUUsVUFBRixFQUFjTSxFQUFkLENBQWlCLE9BQWpCLEVBQTBCLFVBQVVDLENBQVYsRUFBYTtBQUN0Q1AsSUFBRSxNQUFGLEVBQVVRLFdBQVYsQ0FBc0IsVUFBdEI7QUFDQUQsSUFBRUUsY0FBRjtBQUNBLEVBSEQ7O0FBS0E7QUFDQVQsR0FBRSxXQUFGLEVBQWVDLEtBQWYsQ0FBcUIsVUFBVU0sQ0FBVixFQUFhO0FBQ2pDUCxJQUFFLElBQUYsRUFBUVEsV0FBUixDQUFvQixTQUFwQjtBQUNBRCxJQUFFRSxjQUFGO0FBQ0EsRUFIRDs7QUFLQTtBQUNBVCxHQUFFLHFCQUFGLEVBQXlCVSxLQUF6QixDQUErQjtBQUM5QkMsUUFBTSxJQUR3QjtBQUU5QkMsWUFBVSxJQUZvQjtBQUc5QkMsU0FBTyxHQUh1QjtBQUk5QkMsZ0JBQWMsQ0FKZ0I7QUFLOUJDLGtCQUFnQixDQUxjO0FBTTlCQyxnQkFBYyxJQU5nQjtBQU85QkMsY0FBWSxDQUFDO0FBQ1pDLGVBQVksR0FEQTtBQUVaQyxhQUFVO0FBQ1RMLGtCQUFjLENBREw7QUFFVEMsb0JBQWdCO0FBRlA7QUFGRSxHQUFEO0FBUGtCLEVBQS9COztBQWdCQTtBQUNBSyxRQUFPQyxFQUFQLEdBQVlDLGFBQWE7QUFDeEJDLFNBQU8sS0FEaUIsRUFDVjtBQUNkQyxTQUFPLENBRmlCO0FBR3hCQyxVQUFRLGdDQUhnQjtBQUl4QkMsVUFBUSxJQUpnQjtBQUt4QkMsY0FBWSxHQUxZO0FBTXhCQyxZQUFVLE1BTmM7QUFPeEJDLFlBQVUsR0FQYztBQVF4QkMsVUFBUSxRQVJnQjtBQVN4QkMsY0FBWSxFQUFFMUIsS0FBSyxDQUFQLEVBQVUyQixPQUFPLENBQWpCLEVBQW9CQyxRQUFRLENBQTVCLEVBQStCQyxNQUFNLENBQXJDO0FBVFksRUFBYixDQUFaOztBQVlBO0FBQ0FiLElBQUdjLE1BQUgsQ0FBVSxVQUFWLEVBQXNCO0FBQ3JCQyxTQUFPLENBRGM7QUFFckJiLFNBQU87QUFGYyxFQUF0Qjs7QUFLQUYsSUFBR2MsTUFBSCxDQUFVLFlBQVYsRUFBd0I7QUFDdkJDLFNBQU8sR0FEZ0I7QUFFdkJiLFNBQU87QUFGZ0IsRUFBeEI7O0FBS0FGLElBQUdjLE1BQUgsQ0FBVSxZQUFWLEVBQXdCO0FBQ3ZCQyxTQUFPLEdBRGdCO0FBRXZCYixTQUFPO0FBRmdCLEVBQXhCOztBQUtBRixJQUFHYyxNQUFILENBQVUsWUFBVixFQUF3QjtBQUN2QkMsU0FBTyxHQURnQjtBQUV2QmIsU0FBTztBQUZnQixFQUF4QjtBQUtBLENBeEVEIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzLmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsialF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbiAoJCkge1xuXG5cdC8vQW5pbWF0ZSBzY3JvbGxcblx0JCgnLmJ0bi1za2lwJykuY2xpY2soZnVuY3Rpb24gKCkge1xuXHRcdCQoJ2h0bWwsIGJvZHknKS5hbmltYXRlKHtcblx0XHRcdHNjcm9sbFRvcDogJChcIiNjb250ZW50XCIpLm9mZnNldCgpLnRvcCAtIDE1XG5cdFx0fSwgODAwKTtcblx0fSlcblxuXHQvL1RvZ2dsZSBNb2JpbGUgTmF2aWdhdGlvblxuXHQkKCcuYnRuLW5hdicpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG5cdFx0JCgnYm9keScpLnRvZ2dsZUNsYXNzKCduYXYtb3BlbicpO1xuXHRcdGUucHJldmVudERlZmF1bHQoKTtcblx0fSlcblxuXHQvL1RvZ2dsZSBNZW51XG5cdCQoJy5oYXMtbWVudScpLmNsaWNrKGZ1bmN0aW9uIChlKSB7XG5cdFx0JCh0aGlzKS50b2dnbGVDbGFzcygnaXMtb3BlbicpO1xuXHRcdGUucHJldmVudERlZmF1bHQoKTtcblx0fSlcblxuXHQvL1Rlc3RpbW9uaWFsIHNsaWRlclxuXHQkKCcudGVzdGltb25pYWwtc2xpZGVyJykuc2xpY2soe1xuXHRcdGRvdHM6IHRydWUsXG5cdFx0aW5maW5pdGU6IHRydWUsXG5cdFx0c3BlZWQ6IDgwMCxcblx0XHRzbGlkZXNUb1Nob3c6IDMsXG5cdFx0c2xpZGVzVG9TY3JvbGw6IDMsXG5cdFx0c3dpcGVUb1NsaWRlOiB0cnVlLFxuXHRcdHJlc3BvbnNpdmU6IFt7XG5cdFx0XHRicmVha3BvaW50OiA1NjAsXG5cdFx0XHRzZXR0aW5nczoge1xuXHRcdFx0XHRzbGlkZXNUb1Nob3c6IDEsXG5cdFx0XHRcdHNsaWRlc1RvU2Nyb2xsOiAxXG5cdFx0XHR9XG5cdFx0fV1cblx0fSk7XG5cblx0Ly8gU2Nyb2xsIFJldmVhbFxuXHR3aW5kb3cuc3IgPSBTY3JvbGxSZXZlYWwoeyBcblx0XHRyZXNldDogZmFsc2UsIC8vaW52ZXJzZSBhbmltYXRpb24gZm9yIHRlc3Rpbmdcblx0XHRzY2FsZTogMSxcblx0XHRlYXNpbmc6ICdjdWJpYy1iZXppZXIoMC42LCAwLjIsIDAuMSwgMSknLFxuXHRcdG1vYmlsZTogdHJ1ZSxcblx0XHR2aWV3RmFjdG9yOiAwLjIsXG5cdFx0ZGlzdGFuY2U6ICc2MHB4Jyxcblx0XHRkdXJhdGlvbjogODAwLFxuXHRcdG9yaWdpbjogJ2JvdHRvbScsXG5cdFx0dmlld09mZnNldDogeyB0b3A6IDAsIHJpZ2h0OiAwLCBib3R0b206IDAsIGxlZnQ6IDAgfVxuXHR9KTtcblxuXHQvLyBDdXN0b20gU2V0dGluZ3Ncblx0c3IucmV2ZWFsKCcuZmFkZS11cCcsIHsgXHRcdFxuXHRcdGRlbGF5OiAwLFxuXHRcdHJlc2V0OiBmYWxzZVx0XG5cdH0pO1xuXG5cdHNyLnJldmVhbCgnLmZhZGUtdXAtMScsIHsgXHRcdFxuXHRcdGRlbGF5OiAyMDAsXHRcblx0XHRyZXNldDogZmFsc2Vcblx0fSk7XG5cblx0c3IucmV2ZWFsKCcuZmFkZS11cC0yJywgeyBcdFx0XG5cdFx0ZGVsYXk6IDQwMCxcdFxuXHRcdHJlc2V0OiBmYWxzZVxuXHR9KTtcblxuXHRzci5yZXZlYWwoJy5mYWRlLXVwLTMnLCB7IFx0XHRcblx0XHRkZWxheTogNjAwLFx0XG5cdFx0cmVzZXQ6IGZhbHNlXG5cdH0pO1xuXG59KTtcblxuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzLmpzIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/assets/js/scripts.js\n");

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/scripts.js");


/***/ })

/******/ });