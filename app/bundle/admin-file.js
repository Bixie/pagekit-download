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

	
	__webpack_require__(4);

	module.exports = {

	    data: function () {
	        return _.merge({
	            tags: [],
	            file: {}
	        }, window.$data);
	    },

	    created: function () {
	    },

	    ready: function () {
	        this.resource = this.$resource('api/download/file/:id');
	        this.tab = UIkit.tab(this.$$.tab, {connect: this.$$.content});
	    },

	    computed: {

	        statusOptions: function () {
	            return _.map(this.statuses, function (status, id) { return { text: status, value: id }; });
	        },

	        sections: function () {

	            var sections = [];

	            _.forIn(this.$options.components, function (component, name) {

	                var options = component.options || {}, section = options.section;

	                if (section) {
	                    section.name = name;
	                    sections.push(section);
	                }

	            });

	            return sections;
	        }

	    },

	    methods: {

	        save: function (e) {

	            e.preventDefault();

	            var data = {file: this.file};

	            this.$broadcast('save', data);

	            this.resource.save({id: this.file.id}, data, function (data) {

	                if (!this.file.id) {
	                    window.history.replaceState({}, '', this.$url.route('admin/download/file/edit', {id: data.file.id}));
	                }

	                this.$set('file', data.file);

	                this.$broadcast('saved', data);

	                this.$notify(this.$trans('Download %title% saved.', {title: this.file.title}));

	            }, function (data) {
	                this.$notify(data, 'danger');
	            });
	        }

	    },

	    mixins: [window.BixieDownloads]

	};

	$(function () {

	    new Vue(module.exports).$mount('#file-edit');

	});

/***/ },
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(5)
	module.exports.template = __webpack_require__(6)


/***/ },
/* 5 */
/***/ function(module, exports) {

	module.exports = {

	        props: ['file', 'ext', 'multiple', 'class'],

	        data: function () {
	            return _.merge({
	                'file': '',
	                'ext': [],
	                'class': '',
	                'multile': false
	            }, $pagekit);
	        },

	        computed: {
	            fileName: function () {
	                return this.file.split('/').pop();
	            }
	        },

	        methods: {

	            pick: function() {
	                this.$.modal.open();
	            },

	            select: function() {
	                this.$set('file', this.$.finder.getSelected()[0]);
	                this.$dispatch('file-selected', this.file);
	                this.$.finder.removeSelection();
	                this.$.modal.close();
	            },

	            remove: function(e) {
	                e.stopPropagation();
	                this.file = ''
	            },

	            hasSelection: function() {
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
	            js: [
	                'app/assets/uikit/js/components/upload.min.js',
	                'app/system/modules/finder/app/bundle/panel-finder.js'
	            ]
	        }, function () {
	            resolve(module.exports);
	        })
	    });

/***/ },
/* 6 */
/***/ function(module, exports) {

	module.exports = "<div v-on=\"click: pick\" class=\"{{ class }}\">\r\n        <ul class=\"uk-float-right uk-subnav pk-subnav-icon\">\r\n            <li><a class=\"pk-icon-delete pk-icon-hover\" title=\"{{ 'Delete' | trans }}\" data-uk-tooltip=\"{delay: 500, 'pos': 'left'}\" v-on=\"click: remove\"></a></li>\r\n        </ul>\r\n        <a class=\"pk-icon-folder-circle uk-margin-right\"></a>\r\n        <a v-if=\"!file\" class=\"uk-text-muted\">{{ 'Select file' | trans }}</a>\r\n        <a v-if=\"file\" data-uk-tooltip=\"\" title=\"{{ file }}\">{{ fileName }}</a>\r\n    </div>\r\n\r\n    <v-modal v-ref=\"modal\" large>\r\n\r\n        <panel-finder root=\"{{ storage }}\" v-ref=\"finder\" modal=\"true\"></panel-finder>\r\n\r\n        <div class=\"uk-modal-footer uk-text-right\">\r\n            <button class=\"uk-button uk-button-link uk-modal-close\" type=\"button\">{{ 'Cancel' | trans }}</button>\r\n            <button class=\"uk-button uk-button-primary\" type=\"button\" v-attr=\"disabled: !hasSelection()\" v-on=\"click: select()\">{{ 'Select' | trans }}</button>\r\n        </div>\r\n\r\n    </v-modal>";

/***/ }
/******/ ]);