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
	        'input-tags': __webpack_require__(10),
	        'download-section-edit': __webpack_require__(13)
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
/* 10 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(11)
	module.exports.template = __webpack_require__(12)


/***/ },
/* 11 */
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
/* 12 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-flex uk-flex-wrap\" data-uk-margin=\"\">\r\n        <div v-repeat=\"tag: tags\" class=\"uk-badge uk-margin-small-right\">\r\n            <a class=\"uk-float-right uk-close\" v-on=\"click: removeTag($event, $index)\"></a>\r\n            {{ tag }}\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"uk-flex uk-flex-middle uk-margin\">\r\n        <div>\r\n            <div class=\"uk-position-relative\" data-uk-dropdown=\"\">\r\n                <button type=\"button\" class=\"uk-button uk-button-small\">{{ 'Existing' | trans }}</button>\r\n\r\n                <div class=\"uk-dropdown uk-dropdown-small\">\r\n                    <ul class=\"uk-nav uk-nav-dropdown\">\r\n                        <li v-repeat=\"tag: existing\"><a\r\n                                v-on=\"click: addTag($event, tag)\">{{ tag }}</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div>\r\n\r\n        </div>\r\n        <div class=\"uk-flex-item-1 uk-margin-small-left\">\r\n            <div class=\"uk-form-password\">\r\n                <input type=\"text\" class=\"uk-width-1-1\" v-model=\"newtag\" v-on=\"keyup:addTag | key 'enter'\">\r\n                <a class=\"uk-form-password-toggle\" v-on=\"click: addTag()\"><i class=\"uk-icon-check uk-icon-hover\"></i></a>\r\n            </div>\r\n        </div>\r\n\r\n    </div>";

/***/ },
/* 13 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(14)
	module.exports.template = __webpack_require__(15)


/***/ },
/* 14 */
/***/ function(module, exports) {

	module.exports = {

	        section: {
	            label: 'General',
	            priority: -99
	        },

	        inherit: true

	    };

/***/ },
/* 15 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-grid pk-grid-large\" data-uk-grid-margin>\r\n        <div class=\"uk-flex-item-1\">\r\n            <div class=\"uk-form-horizontal uk-margin\">\r\n                <div class=\"uk-form-row\">\r\n                    <label for=\"form-title\" class=\"uk-form-label\">{{ 'Title' | trans }}</label>\r\n\r\n                    <div class=\"uk-form-controls\">\r\n                        <input id=\"form-title\" class=\"uk-width-1-1 uk-form-large\" type=\"text\" name=\"title\"\r\n                               v-model=\"file.title\" v-validate=\"required\">\r\n                    </div>\r\n                    <p class=\"uk-form-help-block uk-text-danger\" v-show=\"form.title.invalid\">\r\n                        {{ 'Please enter a title' | trans }}</p>\r\n                </div>\r\n\r\n                <div class=\"uk-form-row\">\r\n                    <label for=\"form-subtitle\" class=\"uk-form-label\">{{ 'Subitle' | trans }}</label>\r\n\r\n                    <div class=\"uk-form-controls\">\r\n                        <input id=\"form-subtitle\" class=\"uk-width-1-1\" type=\"text\" name=\"subtitle\"\r\n                               v-model=\"file.subtitle\">\r\n                    </div>\r\n                </div>\r\n\r\n            </div>\r\n\r\n\r\n            <div class=\"uk-form-stacked uk-margin\">\r\n                <div class=\"uk-form-row\">\r\n                    <span class=\"uk-form-label\">{{ 'Content' | trans }}</span>\r\n\r\n                    <div class=\"uk-form-controls\">\r\n                        <v-editor id=\"form-content\" value=\"{{@ file.content }}\"\r\n                                  options=\"{{ {markdown : file.data.markdown} }}\"></v-editor>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n\r\n        </div>\r\n        <div class=\"pk-width-sidebar pk-width-sidebar-large uk-form-stacked\">\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label class=\"uk-form-label\">{{ 'File' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls\">\r\n                    <input-file file=\"{{@ file.path }}\" ext=\"{{ config.file_extensions }}\"></input-file>\r\n                    <input type=\"hidden\" name=\"path\" v-model=\"file.path\" v-validate=\"required\">\r\n                </div>\r\n                <p class=\"uk-form-help-block uk-text-danger\" v-show=\"form.path.invalid\">\r\n                    {{ 'Please select a file' | trans }}</p>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label class=\"uk-form-label\">{{ 'Image' | trans }}</label>\r\n                <div class=\"uk-form-controls\">\r\n                    <input-image-meta image=\"{{@ file.image.main }}\" class=\"pk-image-max-height\"></input-image-meta>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label class=\"uk-form-label\">{{ 'Icon' | trans }}</label>\r\n                <div class=\"uk-form-controls\">\r\n                    <input-image-meta image=\"{{@ file.image.icon }}\" class=\"pk-image-max-height\"></input-image-meta>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"form-slug\" class=\"uk-form-label\">{{ 'Slug' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls\">\r\n                    <input id=\"form-slug\" class=\"uk-width-1-1\" type=\"text\" v-model=\"file.slug\">\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"form-status\" class=\"uk-form-label\">{{ 'Status' | trans }}</label>\r\n                <div class=\"uk-form-controls\">\r\n                    <select id=\"form-status\" class=\"uk-width-1-1\" v-model=\"file.status\" options=\"statusOptions\"></select>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <span class=\"uk-form-label\">{{ 'Date' | trans }}</span>\r\n                <div class=\"uk-form-controls\">\r\n                    <input-date datetime=\"{{@ file.date}}\"></input-date>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <span class=\"uk-form-label\">{{ 'Tags' | trans }}</span>\r\n                <div class=\"uk-form-controls\">\r\n                    <input-tags tags=\"{{@ file.tags}}\" existing=\"{{ tags }}\"></input-tags>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"form-demo_url\" class=\"uk-form-label\">{{ 'Demo url' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls\">\r\n                    <input id=\"form-demo_url\" class=\"uk-width-1-1\" type=\"text\" v-model=\"file.data.demo_url\">\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <label for=\"form-version\" class=\"uk-form-label\">{{ 'Version' | trans }}</label>\r\n\r\n                <div class=\"uk-form-controls\">\r\n                    <input id=\"form-version\" class=\"uk-width-1-1\" type=\"text\" v-model=\"file.data.version\">\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <span class=\"uk-form-label\">{{ 'Restrict Access' | trans }}</span>\r\n                <div class=\"uk-form-controls uk-form-controls-text\">\r\n                    <p v-repeat=\"role: roles\" class=\"uk-form-controls-condensed\">\r\n                        <label><input type=\"checkbox\" value=\"{{ role.id }}\" v-checkbox=\"file.roles\" number> {{ role.name }}</label>\r\n                    </p>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"uk-form-row\">\r\n                <span class=\"uk-form-label\">{{ 'Options' | trans }}</span>\r\n                <div class=\"uk-form-controls uk-form-controls-text\">\r\n                    <label>\r\n                        <input type=\"checkbox\" value=\"markdown\" v-model=\"file.data.markdown\"> {{ 'Enable Markdown' |\r\n                        trans }}</label>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>";

/***/ }
/******/ ]);