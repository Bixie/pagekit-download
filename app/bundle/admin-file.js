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

	module.exports = Vue.extend({

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

	                this.$notify(this.$trans('Download %title% saved.', {title: this.file.title}));

	            }, function (data) {
	                this.$notify(data, 'danger');
	            });
	        }

	    },

	    components: {

	        'input-tags': __webpack_require__(7)

	    }

	});

	$(function () {

	    (new module.exports()).$mount('#file-edit');

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

/***/ },
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(8)
	module.exports.template = __webpack_require__(9)


/***/ },
/* 8 */
/***/ function(module, exports) {

	module.exports = {

	        props: ['tags', 'existing'],

	        data: function () {
	            return {
	                'newtag': '',
	                'tags': '',
	                'existing': ''
	            };
	        },

	        methods: {

	            addTag: function(e, tag) {
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

	            removeTag: function(e, idx) {
	                if (e) {
	                    e.preventDefault();
	                }
	                this.tags.$remove(idx)
	            }

	        }

	    };

/***/ },
/* 9 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-flex uk-flex-wrap\" data-uk-margin=\"\">\r\n        <div v-repeat=\"tag: tags\" class=\"uk-badge uk-margin-small-right\">\r\n            <a class=\"uk-float-right uk-close\" v-on=\"click: removeTag($event, $index)\"></a>\r\n            {{ tag }}\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"uk-flex uk-flex-middle uk-margin\">\r\n        <div>\r\n            <div class=\"uk-position-relative\" data-uk-dropdown=\"\">\r\n                <button type=\"button\" class=\"uk-button uk-button-small\">{{ 'Existing' | trans }}</button>\r\n\r\n                <div class=\"uk-dropdown uk-dropdown-small\">\r\n                    <ul class=\"uk-nav uk-nav-dropdown\">\r\n                        <li v-repeat=\"tag: existing\"><a\r\n                                v-on=\"click: addTag($event, tag)\">{{ tag }}</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div>\r\n\r\n        </div>\r\n        <div class=\"uk-flex-item-1 uk-margin-small-left\">\r\n            <div class=\"uk-form-password\">\r\n                <input type=\"text\" class=\"uk-width-1-1\" v-model=\"newtag\" v-on=\"keyup:addTag | key 'enter'\">\r\n                <a class=\"uk-form-password-toggle\" v-on=\"click: addTag()\"><i class=\"uk-icon-check uk-icon-hover\"></i></a>\r\n            </div>\r\n        </div>\r\n\r\n    </div>";

/***/ }
/******/ ]);