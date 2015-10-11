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

	module.exports = Vue.extend({

	    data: function () {
	        return window.$data;
	    },

	    fields: __webpack_require__(11),

	    methods: {

	        save: function () {
	            this.$http.post('admin/system/settings/config', { name: 'bixie/download', config: this.config }, function () {
	                this.$notify('Settings saved.');
	            }).error(function (data) {
	                this.$notify(data, 'danger');
	            });
	        }
	    },

	    components: {

	        'input-tags': __webpack_require__(13)

	    }

	});

	Vue.field.templates.formrow = __webpack_require__(16);
	Vue.field.types.checkbox = '<p class="uk-form-controls-condensed"><label><input type="checkbox" v-attr="attrs" v-model="value"> {{ optionlabel | trans }}</label></p>';
	Vue.field.types.number = '<input type="number" v-attr="attrs" v-model="value" number>';

	$(function () {

	    (new module.exports()).$mount('#download-settings');

	});


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

	
	var options = __webpack_require__(12);

	module.exports = {
	    portfolio: {
	        'filter_tags': {
	            type: 'checkbox',
	            label: 'Grid filter',
	            optionlabel: 'Filter by tags'
	        },
	        'columns': {
	            type: 'select',
	            label: 'Phone Portrait',
	            options: options.gridcols.base,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'columns_small': {
	            type: 'select',
	            label: 'Phone Landscape',
	            options: options.gridcols.inherit,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'columns_medium': {
	            type: 'select',
	            label: 'Tablet',
	            options: options.gridcols.inherit,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'columns_large': {
	            type: 'select',
	            label: 'Desktop',
	            options: options.gridcols.inherit,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'columns_xlarge': {
	            type: 'select',
	            label: 'Large screens',
	            options: options.gridcols.inherit,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'columns_gutter': {
	            type: 'select',
	            label: 'Gutter width',
	            options: options.gutter,
	            attrs: {'class': 'uk-form-width-small'}
	        }
	    },
	    teaser: {
	        'teaser.show_title': {
	            type: 'checkbox',
	            label: 'Show content',
	            optionlabel: 'Show title'
	        },
	        'teaser.show_subtitle': {
	            type: 'checkbox',
	            optionlabel: 'Show subtitle'
	        },
	        'teaser.show_image': {
	            type: 'checkbox',
	            optionlabel: 'Show image'
	        },
	        'teaser.show_tags': {
	            type: 'checkbox',
	            optionlabel: 'Show tags'
	        },
	        'teaser.show_date': {
	            type: 'checkbox',
	            optionlabel: 'Show date'
	        },
	        'teaser.show_readmore': {
	            type: 'checkbox',
	            optionlabel: 'Show readmore'
	        },
	        'teaser.show_download': {
	            type: 'checkbox',
	            optionlabel: 'Show download'
	        },
	        'teaser.show_demo': {
	            type: 'checkbox',
	            optionlabel: 'Show demo link'
	        },
	        'teaser.panel_style': {
	            type: 'select',
	            label: 'Panel style',
	            options: options.panel_style,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.content_align': {
	            type: 'select',
	            label: 'Content alignment',
	            options: options.align.general,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.tags_align': {
	            type: 'select',
	            label: 'Tags alignment',
	            options: options.align.general,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.button_align': {
	            type: 'select',
	            label: 'Button alignment',
	            options: options.align.flex,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.title_size': {
	            type: 'select',
	            label: 'Title size',
	            options: options.heading_size,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.subtitle_size': {
	            type: 'select',
	            label: 'Subtitle size',
	            options: options.heading_size,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.title_color': {
	            type: 'select',
	            label: 'Title color',
	            options: options.text_color,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.download': {
	            label: 'Read more text',
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.download_style': {
	            type: 'select',
	            label: 'Download button style',
	            options: options.button_style,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.read_more': {
	            label: 'Read more text',
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.read_more_style': {
	            type: 'select',
	            label: 'Read more button style',
	            options: options.button_style,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.demo': {
	            label: 'Demo link text',
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'teaser.demo_more_style': {
	            type: 'select',
	            label: 'Demo link button style',
	            options: options.button_style,
	            attrs: {'class': 'uk-form-width-medium'}
	        }
	    },
	    general: {
	        'files_per_page': {
	            type: 'number',
	            label: 'Files per page',
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'ordering': {
	            type: 'select',
	            label: 'Ordering',
	            options: {
	                'Title': 'title',
	                'Date': 'date',
	                'Tags (first tag of item)': 'tags'
	            },
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'markdown_enabled': {
	            type: 'checkbox',
	            label: 'Markdown',
	            optionlabel: 'Markdown enabled'
	        },
	        'date_format': {
	            type: 'select',
	            label: 'Date format',
	            options: {
	                'January 2015': 'F Y',
	                'January 15 2015': 'F d Y',
	                '15 January 2015': 'd F Y',
	                'Jan 2015': 'M Y',
	                '1 2015': 'm Y',
	                '1-15-2015': 'm-d-Y',
	                '15-1-2015': 'd-m-Y'
	            },
	            attrs: {'class': 'uk-form-width-medium'}
	        }

	    }


	};

/***/ },
/* 12 */
/***/ function(module, exports) {

	module.exports = {
	    gridcols: {
	        base: {
	            '1': '1',
	            '2': '2',
	            '3': '3',
	            '4': '4',
	            '5': '5',
	            '6': '6'
	        },
	        inherit: {
	            'Inherit': '',
	            '1': '1',
	            '2': '2',
	            '3': '3',
	            '4': '4',
	            '5': '5',
	            '6': '6'
	        }
	    },
	    gutter: {
	        'Collapse': '0',
	        '10 px': '10',
	        '20 px': '20',
	        '30 px': '30'
	    },
	    align: {
	        general: {
	            'Left': 'left',
	            'Right': 'right',
	            'Center': 'center'
	        },
	        flex: {
	            'Left': '',
	            'Right': 'uk-flex-right',
	            'Center': 'uk-flex-center'
	        }
	    },
	    heading_size: {
	        'Heading H1': 'uk-h1',
	        'Heading H2': 'uk-h2',
	        'Heading H3': 'uk-h3',
	        'Heading H4': 'uk-h4',
	        'Large header': 'uk-heading-large',
	        'Module header': 'uk-module-title',
	        'Article header': 'uk-article-title'
	    },
	    text_color: {
	        'Normal': '',
	        'Primary': 'uk-text-primary',
	        'Contrast': 'uk-text-contrast',
	        'Muted': 'uk-text-muted',
	        'Success': 'uk-text-success',
	        'Warning': 'uk-text-warning',
	        'Danger': 'uk-text-danger'
	    },
	    button_style: {
	        'Link': 'uk-link',
	        'Button': 'uk-button',
	        'Button primary': 'uk-button uk-button-primary',
	        'Button success': 'uk-button uk-button-success',
	        'Button link': 'uk-button uk-button-link'
	    },
	    panel_style: {
	        'Raw': '',
	        'Panel box': 'uk-panel-box',
	        'Panel box primary': 'uk-panel-box uk-panel-box-primary',
	        'Panel box secondary': 'uk-panel-box uk-panel-box-secondary',
	        'Panel space': 'uk-panel-space'
	    },

	};

/***/ },
/* 13 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(14)
	module.exports.template = __webpack_require__(15)


/***/ },
/* 14 */
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
/* 15 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-flex uk-flex-wrap\" data-uk-margin=\"\">\r\n        <div v-repeat=\"tag: tags\" class=\"uk-badge uk-margin-small-right\">\r\n            <a class=\"uk-float-right uk-close\" v-on=\"click: removeTag($event, $index)\"></a>\r\n            {{ tag }}\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"uk-flex uk-flex-middle uk-margin\">\r\n        <div>\r\n            <div class=\"uk-position-relative\" data-uk-dropdown=\"\">\r\n                <button type=\"button\" class=\"uk-button uk-button-small\">{{ 'Existing' | trans }}</button>\r\n\r\n                <div class=\"uk-dropdown uk-dropdown-small\">\r\n                    <ul class=\"uk-nav uk-nav-dropdown\">\r\n                        <li v-repeat=\"tag: existing\"><a\r\n                                v-on=\"click: addTag($event, tag)\">{{ tag }}</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div>\r\n\r\n        </div>\r\n        <div class=\"uk-flex-item-1 uk-margin-small-left\">\r\n            <div class=\"uk-form-password\">\r\n                <input type=\"text\" class=\"uk-width-1-1\" v-model=\"newtag\" v-on=\"keyup:addTag | key 'enter'\">\r\n                <a class=\"uk-form-password-toggle\" v-on=\"click: addTag()\"><i class=\"uk-icon-check uk-icon-hover\"></i></a>\r\n            </div>\r\n        </div>\r\n\r\n    </div>";

/***/ },
/* 16 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-form-row\" v-repeat=\"field in fields\">\r\n    <label class=\"uk-form-label\">{{ field.label | trans }}</label>\r\n    <div class=\"uk-form-controls\" v-class=\"uk-form-controls-text: ['checkbox', 'radio'].indexOf(field.type)\">\r\n        <field config=\"{{ field }}\" values=\"{{@ values }}\"></field>\r\n    </div>\r\n</div>\r\n";

/***/ }
/******/ ]);