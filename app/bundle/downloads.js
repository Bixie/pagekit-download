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
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	
	window.BixieDownloads = module.exports = {

	    components: {
	        'download-section-data': __webpack_require__(11)
	    }

	};


/***/ },
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(12)

	if (module.exports.__esModule) module.exports = module.exports.default
	;(typeof module.exports === "function" ? module.exports.options : module.exports).template = __webpack_require__(13)
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "C:\\BixieProjects\\pagekit\\pagekit\\packages\\bixie\\download\\app\\components\\download-section-data.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
	  }
	})()}

/***/ },
/* 12 */
/***/ function(module, exports) {

	'use strict';

	// <template>

	//     <div class="uk-form-horizontal uk-margin">

	//         <div class="uk-form-row">

	//             <span class="uk-form-label">{{ 'Date' | trans }}</span>

	//             <div class="uk-form-controls">

	//                 <input-date :datetime.sync="file.date"></input-date>

	//             </div>

	//         </div>

	//         <div class="uk-form-row">

	//             <label for="form-demo_url" class="uk-form-label">{{ 'Demo url' | trans }}</label>

	//             <div class="uk-form-controls">

	//                 <input id="form-demo_url" class="uk-width-1-1" type="text" v-model="file.data.demo_url">

	//             </div>

	//         </div>

	//         <div class="uk-form-row">

	//             <label for="form-version" class="uk-form-label">{{ 'Version' | trans }}</label>

	//             <div class="uk-form-controls">

	//                 <input id="form-version" class="uk-width-1-1" type="text" v-model="file.data.version">

	//             </div>

	//         </div>

	//         <div v-for="datafield in config.datafields" class="uk-form-row">

	//             <datafieldvalue :datafield="datafield" :value.sync="file.data[datafield.name]"></datafieldvalue>

	//         </div>

	//     </div>

	// </template>

	// <script>

	module.exports = {

	    section: {
	        label: 'Data',
	        priority: 10
	    },

	    props: ['file', 'config', 'form'],

	    created: function created() {
	        this.$on('datafieldvalue.changed', function (name, value) {
	            this.file.data[name] = value;
	        });
	    },

	    components: {

	        datafieldvalue: {

	            props: ['datafield', 'value'],

	            template: '<label for="form-{{ datafield.name }}" class="uk-form-label">{{ datafield.label }}</label>\n<div class="uk-form-controls">\n    <input id="form-{{ datafield.name }}" class="uk-form-width-medium" type="text" name="{{ datafield.name }}"\n           v-model="value">\n</div>\n',

	            watch: {
	                value: function value(_value) {
	                    this.$dispatch('datafieldvalue.changed', this.datafield.name, _value);
	                }
	            }

	        }

	    }

	};

	// </script>

/***/ },
/* 13 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-form-horizontal uk-margin\">\r\n\r\n        <div class=\"uk-form-row\">\r\n            <span class=\"uk-form-label\">{{ 'Date' | trans }}</span>\r\n            <div class=\"uk-form-controls\">\r\n                <input-date :datetime.sync=\"file.date\"></input-date>\r\n            </div>\r\n        </div>\r\n\r\n        <div class=\"uk-form-row\">\r\n            <label for=\"form-demo_url\" class=\"uk-form-label\">{{ 'Demo url' | trans }}</label>\r\n\r\n            <div class=\"uk-form-controls\">\r\n                <input id=\"form-demo_url\" class=\"uk-width-1-1\" type=\"text\" v-model=\"file.data.demo_url\">\r\n            </div>\r\n        </div>\r\n\r\n        <div class=\"uk-form-row\">\r\n            <label for=\"form-version\" class=\"uk-form-label\">{{ 'Version' | trans }}</label>\r\n\r\n            <div class=\"uk-form-controls\">\r\n                <input id=\"form-version\" class=\"uk-width-1-1\" type=\"text\" v-model=\"file.data.version\">\r\n            </div>\r\n        </div>\r\n\r\n        <div v-for=\"datafield in config.datafields\" class=\"uk-form-row\">\r\n\r\n            <datafieldvalue :datafield=\"datafield\" :value.sync=\"file.data[datafield.name]\"></datafieldvalue>\r\n\r\n        </div>\r\n    </div>";

/***/ }
/******/ ]);