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
/******/ ({

/***/ 0:
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(7)

	if (module.exports.__esModule) module.exports = module.exports.default
	;(typeof module.exports === "function" ? module.exports.options : module.exports).template = __webpack_require__(8)
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "C:\\BixieProjects\\pagekit\\pagekit\\packages\\bixie\\download\\app\\components\\download-section-cart.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
	  }
	})()}

/***/ },

/***/ 7:
/***/ function(module, exports) {

	'use strict';

	// <template>

	//     <div class="uk-form-horizontal">

	//         <div class="uk-form-row">

	//             <span class="uk-form-label">{{ 'Shopping cart' | trans }}</span>

	//             <div class="uk-form-controls uk-form-controls-text">

	//                 <p v-show="file.id" class="uk-form-controls-condensed">

	//                     <label><input type="checkbox" v-model="file.data.cart_active"> {{ 'Enable cart' | trans }}</label>

	//                 </p>

	//                 <p v-show="!file.id" class="uk-form-help-block uk-text-warning">

	//                     {{ 'Save item to enable cart' | trans }}

	//                 </p>

	//             </div>

	//         </div>

	//         <div v-show="file.id && product.active" class="uk-margin">

	//             <div class="uk-form-row">

	//                 <label for="form-cart-price" class="uk-form-label">{{ 'Price' | trans }}</label>

	//                 <div class="uk-form-controls">

	//                     <div class="uk-form-icon">

	//                         <i class="{{ currencyIcon }}"></i>

	//                         <input type="number" step="0.01" v-model="product.price"

	//                                id="form-cart-price" class="uk-form-width-medium uk-text-right" number>

	//                     </div>

	//                 </div>

	//             </div>

	//             <div class="uk-form-row">

	//                 <label class="uk-form-label">{{ 'Price config' | trans }}</label>

	//                 <div class="uk-form-controls uk-form-controls-text">

	//                     <select name="file_cart_currency" class="uk-form-width-small"

	//                             v-model="product.currency">

	//                         <option value="EUR">{{ 'Euro' | trans }}</option>

	//                         <option value="USD">{{ 'Dollar' | trans }}</option>

	//                     </select>

	//                     <select name="file_cart_vat" class="uk-margin-small-left uk-form-width-small"

	//                             v-model="product.vat">

	//                         <option v-for="option in config.vatclasses" value="$key">{{ vatclass.name }}</option>

	//                     </select>

	//                 </div>

	//             </div>

	//             <div class="uk-form-row">

	//                 <label for="file_cart_validity_period" class="uk-form-label">{{ 'Validity period' | trans }}</label>

	//                 <div class="uk-form-controls uk-form-controls-text">

	//                     <select id="file_cart_validity_period" name="file_cart_validity_period" class="uk-form-width-small"

	//                             v-model="product.data.validity_period">

	//                         <option value="">{{ 'Infinite' | trans }}</option>

	//                         <option v-for="period in periods" value="{{ $key }}">{{ period | trans }}</option>

	//                     </select>

	//                 </div>

	//             </div>

	//             <div class="uk-form-row">

	//                 <label for="form-cart-product_identifier" class="uk-form-label">{{ 'Package name' | trans }}</label>

	//                 <div class="uk-form-controls">

	//                     <input type="text" v-model="product.data.product_identifier"

	//                           id="form-cart-product_identifier" class="uk-form-width-medium">

	//                 </div>

	//             </div>

	//         </div>

	//     </div>

	// </template>

	// <script>

	module.exports = {

	    section: {
	        label: 'Cart',
	        priority: 99

	    },

	    props: ['file', 'config', 'form'],

	    data: function data() {
	        return _.merge({
	            product: {
	                active: this.file.data.cart_active,
	                id: 0,
	                item_model: 'Bixie\\Download\\Model\\File',
	                item_id: this.file.id,
	                price: 0,
	                currency: window.$cart.config.currency,
	                vat: window.$cart.config.vat,
	                data: {
	                    validity_period: '',
	                    package_name: ''
	                }
	            },
	            config: {}
	        }, window.$cart);
	    },

	    events: {
	        'save': function save(data) {
	            if (this.file.data.cart_active && this.product.item_id) {
	                data.product = this.product;
	            }
	        },
	        'saved': function saved(data) {
	            if (data.file.data.cart_active && data.file.product) {
	                this.$set('product', data.file.product);
	            }
	            this.$set('product.item_id', data.file.id);
	        }
	    },

	    computed: {
	        currencyIcon: function currencyIcon() {
	            var icons = {
	                'EUR': 'uk-icon-euro',
	                'USD': 'uk-icon-dollar'
	            };
	            return icons[this.product.currency || this.config.currency];
	        }
	    },

	    watch: {
	        'file.data.cart_active': function fileDataCart_active(value) {
	            this.product.active = value;
	        }
	    }

	};

	window.BixieDownloads.components['download-section-cart'] = module.exports;

	// </script>

/***/ },

/***/ 8:
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-form-horizontal\">\r\n\r\n        <div class=\"uk-form-row\">\r\n            <span class=\"uk-form-label\">{{ 'Shopping cart' | trans }}</span>\r\n\r\n            <div class=\"uk-form-controls uk-form-controls-text\">\r\n                <p v-show=\"file.id\" class=\"uk-form-controls-condensed\">\r\n                    <label><input type=\"checkbox\" v-model=\"file.data.cart_active\"> {{ 'Enable cart' | trans }}</label>\r\n                </p>\r\n                <p v-show=\"!file.id\" class=\"uk-form-help-block uk-text-warning\">\r\n                    {{ 'Save item to enable cart' | trans }}\r\n                </p>\r\n            </div>\r\n        </div>\r\n\r\n        <div v-show=\"file.id && product.active\" class=\"uk-margin\">\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"form-cart-price\" class=\"uk-form-label\">{{ 'Price' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls\">\r\n                    <div class=\"uk-form-icon\">\r\n                        <i class=\"{{ currencyIcon }}\"></i>\r\n                        <input type=\"number\" step=\"0.01\" v-model=\"product.price\"\r\n                               id=\"form-cart-price\" class=\"uk-form-width-medium uk-text-right\" number>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label class=\"uk-form-label\">{{ 'Price config' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls uk-form-controls-text\">\r\n                    <select name=\"file_cart_currency\" class=\"uk-form-width-small\"\r\n                            v-model=\"product.currency\">\r\n                        <option value=\"EUR\">{{ 'Euro' | trans }}</option>\r\n                        <option value=\"USD\">{{ 'Dollar' | trans }}</option>\r\n                    </select>\r\n                    <select name=\"file_cart_vat\" class=\"uk-margin-small-left uk-form-width-small\"\r\n                            v-model=\"product.vat\">\r\n                        <option v-for=\"option in config.vatclasses\" value=\"$key\">{{ vatclass.name }}</option>\r\n                    </select>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"file_cart_validity_period\" class=\"uk-form-label\">{{ 'Validity period' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls uk-form-controls-text\">\r\n                    <select id=\"file_cart_validity_period\" name=\"file_cart_validity_period\" class=\"uk-form-width-small\"\r\n                            v-model=\"product.data.validity_period\">\r\n                        <option value=\"\">{{ 'Infinite' | trans }}</option>\r\n                        <option v-for=\"period in periods\" value=\"{{ $key }}\">{{ period | trans }}</option>\r\n                    </select>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"form-cart-product_identifier\" class=\"uk-form-label\">{{ 'Package name' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls\">\r\n                    <input type=\"text\" v-model=\"product.data.product_identifier\"\r\n                          id=\"form-cart-product_identifier\" class=\"uk-form-width-medium\">\r\n                </div>\r\n            </div>\r\n\r\n\r\n        </div>\r\n    </div>";

/***/ }

/******/ });