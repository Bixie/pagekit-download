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
	        'input-category': __webpack_require__(19),
	        'input-tags': __webpack_require__(14),
	        'download-section-edit': __webpack_require__(22),
	        'download-section-data': __webpack_require__(25)
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
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(15)

	if (module.exports.__esModule) module.exports = module.exports.default
	;(typeof module.exports === "function" ? module.exports.options : module.exports).template = __webpack_require__(16)
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "C:\\BixieProjects\\pagekit\\pagekit\\packages\\bixie\\download\\app\\components\\input-tags.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
	  }
	})()}

/***/ },
/* 15 */
/***/ function(module, exports) {

	'use strict';

	// <template>

	//     <div class="uk-flex uk-flex-wrap" data-uk-margin="">

	//         <div v-repeat="tag: tags" class="uk-badge uk-margin-small-right">

	//             <a class="uk-float-right uk-close" v-on="click: removeTag($event, $index)"></a>

	//             {{ tag }}

	//         </div>

	//     </div>

	//     <div class="uk-flex uk-flex-middle uk-margin">

	//         <div>

	//             <div class="uk-position-relative" data-uk-dropdown="">

	//                 <button type="button" class="uk-button uk-button-small">{{ 'Existing' | trans }}</button>

	//                 <div class="uk-dropdown uk-dropdown-small">

	//                     <ul class="uk-nav uk-nav-dropdown">

	//                         <li v-repeat="tag: existing"><a

	//                                 v-on="click: addTag($event, tag)">{{ tag }}</a></li>

	//                     </ul>

	//                 </div>

	//             </div>

	//         </div>

	//         <div class="uk-flex-item-1 uk-margin-small-left">

	//             <div class="uk-form-password">

	//                 <input type="text" class="uk-width-1-1" v-model="newtag" v-on="keyup:addTag | key 'enter'">

	//                 <a class="uk-form-password-toggle" v-on="click: addTag()"><i class="uk-icon-check uk-icon-hover"></i></a>

	//             </div>

	//         </div>

	//     </div>

	// </template>

	// <script>

	module.exports = {

	    props: ['tags', 'existing'],

	    data: function data() {
	        return {
	            'newtag': '',
	            'tags': '',
	            'existing': ''
	        };
	    },

	    methods: {

	        addTag: function addTag(e, tag) {
	            if (e) {
	                e.stopPropagation();
	                e.preventDefault();
	            }
	            this.tags.push(tag || this.newtag);
	            this.$nextTick(function () {
	                UIkit.$html.trigger('resize'); //todo why no check.display or changed.dom???
	            });
	            this.newtag = '';
	        },

	        removeTag: function removeTag(e, idx) {
	            if (e) {
	                e.preventDefault();
	            }
	            this.tags.$remove(idx);
	        }

	    }

	};

	// </script>

/***/ },
/* 16 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-flex uk-flex-wrap\" data-uk-margin=\"\">\r\n        <div v-repeat=\"tag: tags\" class=\"uk-badge uk-margin-small-right\">\r\n            <a class=\"uk-float-right uk-close\" v-on=\"click: removeTag($event, $index)\"></a>\r\n            {{ tag }}\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"uk-flex uk-flex-middle uk-margin\">\r\n        <div>\r\n            <div class=\"uk-position-relative\" data-uk-dropdown=\"\">\r\n                <button type=\"button\" class=\"uk-button uk-button-small\">{{ 'Existing' | trans }}</button>\r\n\r\n                <div class=\"uk-dropdown uk-dropdown-small\">\r\n                    <ul class=\"uk-nav uk-nav-dropdown\">\r\n                        <li v-repeat=\"tag: existing\"><a\r\n                                v-on=\"click: addTag($event, tag)\">{{ tag }}</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div>\r\n\r\n        </div>\r\n        <div class=\"uk-flex-item-1 uk-margin-small-left\">\r\n            <div class=\"uk-form-password\">\r\n                <input type=\"text\" class=\"uk-width-1-1\" v-model=\"newtag\" v-on=\"keyup:addTag | key 'enter'\">\r\n                <a class=\"uk-form-password-toggle\" v-on=\"click: addTag()\"><i class=\"uk-icon-check uk-icon-hover\"></i></a>\r\n            </div>\r\n        </div>\r\n\r\n    </div>";

/***/ },
/* 17 */,
/* 18 */,
/* 19 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(20)

	if (module.exports.__esModule) module.exports = module.exports.default
	;(typeof module.exports === "function" ? module.exports.options : module.exports).template = __webpack_require__(21)
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "C:\\BixieProjects\\pagekit\\pagekit\\packages\\bixie\\download\\app\\components\\input-category.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
	  }
	})()}

/***/ },
/* 20 */
/***/ function(module, exports) {

	'use strict';

	// <template>

	//     <ul class="uk-list">

	//         <li v-repeat="values">

	//             <div class="uk-nestable-panel uk-visible-hover uk-flex uk-flex-middle">

	//                 <div class="uk-flex-item-1">

	//                     {{ getText($value) }}

	//                 </div>

	//                 <div class="">

	//                     <ul class="uk-subnav pk-subnav-icon">

	//                         <li><a class="pk-icon-star"

	//                                data-uk-tooltip="{delay: 300}" title="{{ 'Make primary category' | trans }}"

	//                                v-class="uk-invisible: primary !== $value"

	//                                v-on="click: primary = $value"></a></li>

	//                         <li><a class="pk-icon-delete pk-icon-hover uk-invisible" v-on="click: removeCategory($index)"></a></li>

	//                     </ul>

	//                 </div>

	//             </div>

	//         </li>

	//     </ul>

	//     <div id="select-category" class="uk-flex uk-flex-middle uk-margin">

	//         <div>

	//             <div class="uk-position-relative" data-uk-dropdown="{justify:'#select-category'}">

	//                 <button type="button" class="uk-button uk-button-small">{{ 'Please select' | trans }}</button>

	//                 <div class="uk-dropdown uk-dropdown-small">

	//                     <ul class="uk-nav uk-nav-dropdown">

	//                         <category-item v-repeat="category: tree[0]"></category-item>

	//                     </ul>

	//                 </div>

	//             </div>

	//         </div>

	//     </div>

	// </template>

	// <script>

	module.exports = {

	    props: ['values', 'primary', 'categories'],

	    data: function data() {
	        return {
	            'tree': {},
	            'primary': '',
	            'values': [],
	            'categories': {}
	        };
	    },

	    created: function created() {
	        this.tree = _(this.categories).sortBy('priority').groupBy('parent_id').value();
	    },

	    computed: {
	        categorieOptions: function categorieOptions() {
	            var options = [];
	            _.forIn(this.categories, function (category) {
	                options.push({ value: category.id, text: category.title });
	            });
	            return options;
	        }
	    },

	    methods: {

	        addCategory: function addCategory(value) {
	            if (!this.isSelected(value)) {
	                this.values.push(value);
	                this.checkPrimary();
	            }
	        },

	        removeCategory: function removeCategory(idx) {
	            this.values.$remove(idx);
	            this.checkPrimary();
	        },

	        isSelected: function isSelected(value) {
	            return this.values.indexOf(value) > -1;
	        },

	        getText: function getText(value) {
	            return _.find(this.categories, 'id', value).title;
	        },

	        checkPrimary: function checkPrimary() {
	            if (this.values.length && this.values.indexOf(this.primary) == -1) {
	                this.primary = this.values[0];
	            }
	        }

	    },

	    components: {

	        categoryItem: {

	            template: '<li v-class="uk-parent: tree[category.id]">\n    <a v-on="click: addCategory(category.id)" v-class="uk-text-primary: isSelected(category.id)">{{ category.title }}</a>\n    <ul class="uk-nav-sub" v-if="tree[category.id]">\n        <category-item v-repeat="category: tree[category.id]"></category-item>\n    </ul>\n</li>',

	            inherit: true
	        }

	    }

	};

	// </script>

/***/ },
/* 21 */
/***/ function(module, exports) {

	module.exports = "<ul class=\"uk-list\">\r\n        <li v-repeat=\"values\">\r\n            <div class=\"uk-nestable-panel uk-visible-hover uk-flex uk-flex-middle\">\r\n                <div class=\"uk-flex-item-1\">\r\n                    {{ getText($value) }}\r\n                </div>\r\n                <div class=\"\">\r\n                    <ul class=\"uk-subnav pk-subnav-icon\">\r\n                        <li><a class=\"pk-icon-star\"\r\n                               data-uk-tooltip=\"{delay: 300}\" title=\"{{ 'Make primary category' | trans }}\"\r\n                               v-class=\"uk-invisible: primary !== $value\"\r\n                               v-on=\"click: primary = $value\"></a></li>\r\n                        <li><a class=\"pk-icon-delete pk-icon-hover uk-invisible\" v-on=\"click: removeCategory($index)\"></a></li>\r\n                    </ul>\r\n                </div>\r\n            </div>\r\n        </li>\r\n    </ul>\r\n\r\n    <div id=\"select-category\" class=\"uk-flex uk-flex-middle uk-margin\">\r\n        <div>\r\n            <div class=\"uk-position-relative\" data-uk-dropdown=\"{justify:'#select-category'}\">\r\n                <button type=\"button\" class=\"uk-button uk-button-small\">{{ 'Please select' | trans }}</button>\r\n\r\n                <div class=\"uk-dropdown uk-dropdown-small\">\r\n                    <ul class=\"uk-nav uk-nav-dropdown\">\r\n                        <category-item v-repeat=\"category: tree[0]\"></category-item>\r\n                    </ul>\r\n                </div>\r\n            </div>\r\n\r\n        </div>\r\n    </div>";

/***/ },
/* 22 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(23)

	if (module.exports.__esModule) module.exports = module.exports.default
	;(typeof module.exports === "function" ? module.exports.options : module.exports).template = __webpack_require__(24)
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "C:\\BixieProjects\\pagekit\\pagekit\\packages\\bixie\\download\\app\\components\\download-section-edit.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
	  }
	})()}

/***/ },
/* 23 */
/***/ function(module, exports) {

	'use strict';

	// <template>

	//     <div class="uk-grid pk-grid-large" data-uk-grid-margin>

	//         <div class="uk-flex-item-1">

	//             <div class="uk-form-horizontal uk-margin">

	//                 <div class="uk-form-row">

	//                     <label for="form-title" class="uk-form-label">{{ 'Title' | trans }}</label>

	//                     <div class="uk-form-controls">

	//                         <input id="form-title" class="uk-width-1-1 uk-form-large" type="text" name="title"

	//                                v-model="file.title" v-validate="required">

	//                     </div>

	//                     <p class="uk-form-help-block uk-text-danger" v-show="form.title.invalid">

	//                         {{ 'Please enter a title' | trans }}</p>

	//                 </div>

	//                 <div class="uk-form-row">

	//                     <label for="form-subtitle" class="uk-form-label">{{ 'Subitle' | trans }}</label>

	//                     <div class="uk-form-controls">

	//                         <input id="form-subtitle" class="uk-width-1-1" type="text" name="subtitle"

	//                                v-model="file.subtitle">

	//                     </div>

	//                 </div>

	//             </div>

	//             <div class="uk-form-stacked uk-margin">

	//                 <div class="uk-form-row">

	//                     <span class="uk-form-label">{{ 'Content' | trans }}</span>

	//                     <div class="uk-form-controls">

	//                         <v-editor id="form-content" value="{{@ file.content }}"

	//                                   options="{{ {markdown : file.data.markdown} }}"></v-editor>

	//                     </div>

	//                     <p class="uk-form-controls-condensed">

	//                         <label><input type="checkbox" v-model="file.data.markdown"> {{ 'Enable

	//                             Markdown' | trans }}</label>

	//                     </p>

	//                 </div>

	//              </div>

	//             <div class="uk-grid uk-margin uk-grid-width-medium-1-2 uk-form-stacked" data-uk-grid-margin="">

	//                 <div>

	//                     <div class="uk-form-row">

	//                         <label class="uk-form-label">{{ 'Image' | trans }}</label>

	//                         <div class="uk-form-controls">

	//                             <input-image-meta image="{{@ file.image.main }}" class="pk-image-max-height"></input-image-meta>

	//                         </div>

	//                     </div>

	//                 </div>

	//                 <div>

	//                     <div class="uk-form-row">

	//                         <label class="uk-form-label">{{ 'Icon' | trans }}</label>

	//                         <div class="uk-form-controls">

	//                             <input-image-meta image="{{@ file.image.icon }}" class="pk-image-max-height"></input-image-meta>

	//                         </div>

	//                     </div>

	//                 </div>

	//             </div>

	//         </div>

	//         <div class="pk-width-sidebar pk-width-sidebar-large uk-form-stacked">

	//             <div class="uk-form-row">

	//                 <label class="uk-form-label">{{ 'File' | trans }}</label>

	//                 <div class="uk-form-controls">

	//                     <input-file file="{{@ file.path }}" ext="{{ config.file_extensions }}"></input-file>

	//                     <input type="hidden" name="path" v-model="file.path" v-validate="required">

	//                 </div>

	//                 <p class="uk-form-help-block uk-text-danger" v-show="form.path.invalid">

	//                     {{ 'Please select a file' | trans }}</p>

	//             </div>

	//             <div class="uk-form-row">

	//                 <label for="form-slug" class="uk-form-label">{{ 'Slug' | trans }}</label>

	//                 <div class="uk-form-controls">

	//                     <input id="form-slug" class="uk-width-1-1" type="text" v-model="file.slug">

	//                 </div>

	//             </div>

	//             <div class="uk-form-row">

	//                 <label for="form-status" class="uk-form-label">{{ 'Status' | trans }}</label>

	//                 <div class="uk-form-controls">

	//                     <select id="form-status" class="uk-width-1-1" v-model="file.status" options="statusOptions"></select>

	//                 </div>

	//             </div>

	//             <div class="uk-form-row">

	//                 <label for="form-status" class="uk-form-label">{{ 'Downloads' | trans }}</label>

	//                 <div class="uk-form-controls uk-form-controls-text uk-flex uk-flex-middle uk-flex-space-between">

	//                     <strong class="uk-h4">{{ file.downloads }}</strong>

	//                     <button type="button" class="uk-button uk-button-small" v-on="click: resetDownloads"

	//                             v-confirm="'Reset download counter?' | trans">{{ 'Reset' | trans }}</button>

	//                 </div>

	//             </div>

	//             <div class="uk-form-row">

	//                 <span class="uk-form-label">{{ 'Restrict Access' | trans }}</span>

	//                 <div class="uk-form-controls uk-form-controls-text">

	//                     <p v-repeat="role: roles" class="uk-form-controls-condensed">

	//                         <label><input type="checkbox" value="{{ role.id }}" v-checkbox="file.roles" number> {{ role.name }}</label>

	//                     </p>

	//                 </div>

	//             </div>

	//             <div class="uk-form-row">

	//                 <span class="uk-form-label">{{ 'Categories' | trans }}</span>

	//                 <div class="uk-form-controls">

	//                     <input-category values="{{@ file.category_ids}}" primary="{{@ file.data.primary_category}}" categories="{{ categories }}"></input-category>

	//                 </div>

	//             </div>

	//             <div class="uk-form-row">

	//                 <span class="uk-form-label">{{ 'Tags' | trans }}</span>

	//                 <div class="uk-form-controls">

	//                     <input-tags tags="{{@ file.tags}}" existing="{{ tags }}"></input-tags>

	//                 </div>

	//             </div>

	//         </div>

	//     </div>

	// </template>

	// <script>

	module.exports = {

	    section: {
	        label: 'General',
	        priority: -99
	    },

	    inherit: true

	};

	// </script>

/***/ },
/* 24 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-grid pk-grid-large\" data-uk-grid-margin>\r\n        <div class=\"uk-flex-item-1\">\r\n            <div class=\"uk-form-horizontal uk-margin\">\r\n                <div class=\"uk-form-row\">\r\n                    <label for=\"form-title\" class=\"uk-form-label\">{{ 'Title' | trans }}</label>\r\n\r\n                    <div class=\"uk-form-controls\">\r\n                        <input id=\"form-title\" class=\"uk-width-1-1 uk-form-large\" type=\"text\" name=\"title\"\r\n                               v-model=\"file.title\" v-validate=\"required\">\r\n                    </div>\r\n                    <p class=\"uk-form-help-block uk-text-danger\" v-show=\"form.title.invalid\">\r\n                        {{ 'Please enter a title' | trans }}</p>\r\n                </div>\r\n\r\n                <div class=\"uk-form-row\">\r\n                    <label for=\"form-subtitle\" class=\"uk-form-label\">{{ 'Subitle' | trans }}</label>\r\n\r\n                    <div class=\"uk-form-controls\">\r\n                        <input id=\"form-subtitle\" class=\"uk-width-1-1\" type=\"text\" name=\"subtitle\"\r\n                               v-model=\"file.subtitle\">\r\n                    </div>\r\n                </div>\r\n\r\n            </div>\r\n\r\n\r\n            <div class=\"uk-form-stacked uk-margin\">\r\n                <div class=\"uk-form-row\">\r\n                    <span class=\"uk-form-label\">{{ 'Content' | trans }}</span>\r\n\r\n                    <div class=\"uk-form-controls\">\r\n                        <v-editor id=\"form-content\" value=\"{{@ file.content }}\"\r\n                                  options=\"{{ {markdown : file.data.markdown} }}\"></v-editor>\r\n                    </div>\r\n                    <p class=\"uk-form-controls-condensed\">\r\n                        <label><input type=\"checkbox\" v-model=\"file.data.markdown\"> {{ 'Enable\r\n                            Markdown' | trans }}</label>\r\n                    </p>\r\n                </div>\r\n             </div>\r\n\r\n            <div class=\"uk-grid uk-margin uk-grid-width-medium-1-2 uk-form-stacked\" data-uk-grid-margin=\"\">\r\n                <div>\r\n\r\n                    <div class=\"uk-form-row\">\r\n                        <label class=\"uk-form-label\">{{ 'Image' | trans }}</label>\r\n                        <div class=\"uk-form-controls\">\r\n                            <input-image-meta image=\"{{@ file.image.main }}\" class=\"pk-image-max-height\"></input-image-meta>\r\n                        </div>\r\n                    </div>\r\n\r\n                </div>\r\n                <div>\r\n\r\n                    <div class=\"uk-form-row\">\r\n                        <label class=\"uk-form-label\">{{ 'Icon' | trans }}</label>\r\n                        <div class=\"uk-form-controls\">\r\n                            <input-image-meta image=\"{{@ file.image.icon }}\" class=\"pk-image-max-height\"></input-image-meta>\r\n                        </div>\r\n                    </div>\r\n\r\n                </div>\r\n            </div>\r\n\r\n        </div>\r\n        <div class=\"pk-width-sidebar pk-width-sidebar-large uk-form-stacked\">\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label class=\"uk-form-label\">{{ 'File' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls\">\r\n                    <input-file file=\"{{@ file.path }}\" ext=\"{{ config.file_extensions }}\"></input-file>\r\n                    <input type=\"hidden\" name=\"path\" v-model=\"file.path\" v-validate=\"required\">\r\n                </div>\r\n                <p class=\"uk-form-help-block uk-text-danger\" v-show=\"form.path.invalid\">\r\n                    {{ 'Please select a file' | trans }}</p>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"form-slug\" class=\"uk-form-label\">{{ 'Slug' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls\">\r\n                    <input id=\"form-slug\" class=\"uk-width-1-1\" type=\"text\" v-model=\"file.slug\">\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"form-status\" class=\"uk-form-label\">{{ 'Status' | trans }}</label>\r\n                <div class=\"uk-form-controls\">\r\n                    <select id=\"form-status\" class=\"uk-width-1-1\" v-model=\"file.status\" options=\"statusOptions\"></select>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"form-status\" class=\"uk-form-label\">{{ 'Downloads' | trans }}</label>\r\n                <div class=\"uk-form-controls uk-form-controls-text uk-flex uk-flex-middle uk-flex-space-between\">\r\n                    <strong class=\"uk-h4\">{{ file.downloads }}</strong>\r\n                    <button type=\"button\" class=\"uk-button uk-button-small\" v-on=\"click: resetDownloads\"\r\n                            v-confirm=\"'Reset download counter?' | trans\">{{ 'Reset' | trans }}</button>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <span class=\"uk-form-label\">{{ 'Restrict Access' | trans }}</span>\r\n                <div class=\"uk-form-controls uk-form-controls-text\">\r\n                    <p v-repeat=\"role: roles\" class=\"uk-form-controls-condensed\">\r\n                        <label><input type=\"checkbox\" value=\"{{ role.id }}\" v-checkbox=\"file.roles\" number> {{ role.name }}</label>\r\n                    </p>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <span class=\"uk-form-label\">{{ 'Categories' | trans }}</span>\r\n                <div class=\"uk-form-controls\">\r\n                    <input-category values=\"{{@ file.category_ids}}\" primary=\"{{@ file.data.primary_category}}\" categories=\"{{ categories }}\"></input-category>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <span class=\"uk-form-label\">{{ 'Tags' | trans }}</span>\r\n                <div class=\"uk-form-controls\">\r\n                    <input-tags tags=\"{{@ file.tags}}\" existing=\"{{ tags }}\"></input-tags>\r\n                </div>\r\n            </div>\r\n\r\n        </div>\r\n    </div>";

/***/ },
/* 25 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(26)

	if (module.exports.__esModule) module.exports = module.exports.default
	;(typeof module.exports === "function" ? module.exports.options : module.exports).template = __webpack_require__(27)
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
/* 26 */
/***/ function(module, exports) {

	'use strict';

	// <template>

	//     <div class="uk-form-horizontal uk-margin">

	//         <div class="uk-form-row">

	//             <span class="uk-form-label">{{ 'Date' | trans }}</span>

	//             <div class="uk-form-controls">

	//                 <input-date datetime="{{@ file.date}}"></input-date>

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

	//     </div>

	// </template>

	// <script>

	module.exports = {

	    section: {
	        label: 'Data',
	        priority: 10
	    },

	    inherit: true

	};

	// </script>

/***/ },
/* 27 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-form-horizontal uk-margin\">\r\n\r\n        <div class=\"uk-form-row\">\r\n            <span class=\"uk-form-label\">{{ 'Date' | trans }}</span>\r\n            <div class=\"uk-form-controls\">\r\n                <input-date datetime=\"{{@ file.date}}\"></input-date>\r\n            </div>\r\n        </div>\r\n\r\n        <div class=\"uk-form-row\">\r\n            <label for=\"form-demo_url\" class=\"uk-form-label\">{{ 'Demo url' | trans }}</label>\r\n\r\n            <div class=\"uk-form-controls\">\r\n                <input id=\"form-demo_url\" class=\"uk-width-1-1\" type=\"text\" v-model=\"file.data.demo_url\">\r\n            </div>\r\n        </div>\r\n\r\n        <div class=\"uk-form-row\">\r\n            <label for=\"form-version\" class=\"uk-form-label\">{{ 'Version' | trans }}</label>\r\n\r\n            <div class=\"uk-form-controls\">\r\n                <input id=\"form-version\" class=\"uk-width-1-1\" type=\"text\" v-model=\"file.data.version\">\r\n            </div>\r\n        </div>\r\n    </div>";

/***/ }
/******/ ]);