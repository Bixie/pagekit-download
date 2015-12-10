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

	
	__webpack_require__(7);

	module.exports = {

	    data: function () {
	        return _.merge({
	            category: {},
	            roles: []
	        }, window.$data);
	    },

	    ready: function () {
	        var vm = this;
	        UIkit.sortable(this.$$.sortable, {
	            handleClass: 'pk-icon-move'
	        }).on('change.uk.sortable', function (e, sortable, el) {
	            var catordering = 1;
	            _.forEach(sortable.serialize(), function (file) {
	                _.find(vm.category.files, 'id', file.id).catordering = catordering;
	                catordering += 1;
	            });
	        });
	        this.resource = this.$resource('api/download/category/:id');

	    },

	    computed: {

	        path: function () {
	            return (this.category.path ? this.category.path.split('/').slice(0, -1).join('/') : '') + '/' + (this.category.slug || '');
	        }

	    },

	    methods: {

	        save: function (e) {

	            e.preventDefault();

	            var data = {category: this.category};

	            this.$broadcast('save', data);

	            this.resource.save({id: this.category.id}, data, function (data) {

	                if (!this.category.id) {
	                    window.history.replaceState({}, '', this.$url.route('admin/download/category/edit', {id: data.category.id}));
	                }

	                this.$set('category', data.category);

	                this.$broadcast('saved', data);

	                this.$notify(this.$trans('Category %title% saved.', {title: this.category.title}));

	            }, function (data) {
	                this.$notify(data, 'danger');
	            });
	        }

	    }

	};

	$(function () {

	    new Vue(module.exports).$mount('#category-edit');

	});

/***/ },
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(8)

	if (module.exports.__esModule) module.exports = module.exports.default
	;(typeof module.exports === "function" ? module.exports.options : module.exports).template = __webpack_require__(9)
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "C:\\BixieProjects\\pagekit\\pagekit\\packages\\bixie\\download\\app\\components\\input-file.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, (typeof module.exports === "function" ? module.exports.options : module.exports).template)
	  }
	})()}

/***/ },
/* 8 */
/***/ function(module, exports) {

	'use strict';

	// <template>

	//     <div v-on="click: pick" class="{{ class }}">

	//         <ul class="uk-float-right uk-subnav pk-subnav-icon">

	//             <li><a class="pk-icon-delete pk-icon-hover" title="{{ 'Delete' | trans }}" data-uk-tooltip="{delay: 500, 'pos': 'left'}" v-on="click: remove"></a></li>

	//         </ul>

	//         <a class="pk-icon-folder-circle uk-margin-right"></a>

	//         <a v-if="!file" class="uk-text-muted">{{ 'Select file' | trans }}</a>

	//         <a v-if="file" data-uk-tooltip="" title="{{ file }}">{{ fileName }}</a>

	//     </div>

	//     <v-modal v-ref="modal" large>

	//         <panel-finder root="{{ storage }}" v-ref="finder" modal="true"></panel-finder>

	//         <div v-show="!hasSelection()" class="uk-alert">{{ 'Select one file of the following types' | trans }}: {{ this.ext.join(', ') }}</div>

	//         <div class="uk-modal-footer uk-text-right">

	//             <button class="uk-button uk-button-link uk-modal-close" type="button">{{ 'Cancel' | trans }}</button>

	//             <button class="uk-button uk-button-primary" type="button" v-attr="disabled: !hasSelection()" v-on="click: select()">{{ 'Select' | trans }}</button>

	//         </div>

	//     </v-modal>

	// </template>

	// <script>

	module.exports = {

	    props: ['file', 'ext', 'multiple', 'class'],

	    data: function data() {
	        return _.merge({
	            'file': '',
	            'ext': [],
	            'class': '',
	            'multile': false
	        }, $pagekit);
	    },

	    computed: {
	        fileName: function fileName() {
	            return this.file.split('/').pop();
	        }
	    },

	    methods: {

	        pick: function pick() {
	            this.$.modal.open();
	        },

	        select: function select() {
	            this.$set('file', this.$.finder.getSelected()[0]);
	            this.$dispatch('file-selected', this.file);
	            this.$.finder.removeSelection();
	            this.$.modal.close();
	        },

	        remove: function remove(e) {
	            e.stopPropagation();
	            this.file = '';
	        },

	        hasSelection: function hasSelection() {
	            var selected = this.$.finder.getSelected();
	            if (!this.multiple && !(selected.length === 1)) {
	                return false;
	            }
	            //todo there must be a prettier way
	            return selected[0].match(new RegExp('\.(?:' + (this.ext || []).join('|') + ')$', 'i'));
	        }

	    }

	};

	Vue.component('input-file', function (resolve, reject) {
	    Vue.asset({
	        js: ['app/assets/uikit/js/components/upload.min.js', 'app/system/modules/finder/app/bundle/panel-finder.js']
	    }, function () {
	        resolve(module.exports);
	    });
	});

	// </script>

/***/ },
/* 9 */
/***/ function(module, exports) {

	module.exports = "<div v-on=\"click: pick\" class=\"{{ class }}\">\r\n        <ul class=\"uk-float-right uk-subnav pk-subnav-icon\">\r\n            <li><a class=\"pk-icon-delete pk-icon-hover\" title=\"{{ 'Delete' | trans }}\" data-uk-tooltip=\"{delay: 500, 'pos': 'left'}\" v-on=\"click: remove\"></a></li>\r\n        </ul>\r\n        <a class=\"pk-icon-folder-circle uk-margin-right\"></a>\r\n        <a v-if=\"!file\" class=\"uk-text-muted\">{{ 'Select file' | trans }}</a>\r\n        <a v-if=\"file\" data-uk-tooltip=\"\" title=\"{{ file }}\">{{ fileName }}</a>\r\n    </div>\r\n\r\n    <v-modal v-ref=\"modal\" large>\r\n\r\n        <panel-finder root=\"{{ storage }}\" v-ref=\"finder\" modal=\"true\"></panel-finder>\r\n\r\n        <div v-show=\"!hasSelection()\" class=\"uk-alert\">{{ 'Select one file of the following types' | trans }}: {{ this.ext.join(', ') }}</div>\r\n\r\n        <div class=\"uk-modal-footer uk-text-right\">\r\n            <button class=\"uk-button uk-button-link uk-modal-close\" type=\"button\">{{ 'Cancel' | trans }}</button>\r\n            <button class=\"uk-button uk-button-primary\" type=\"button\" v-attr=\"disabled: !hasSelection()\" v-on=\"click: select()\">{{ 'Select' | trans }}</button>\r\n        </div>\r\n\r\n    </v-modal>";

/***/ }
/******/ ]);