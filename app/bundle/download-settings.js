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

	module.exports = {

	    el: '#download-settings',

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

	};

	Vue.field.templates.formrow = __webpack_require__(16);
	Vue.field.templates.raw = __webpack_require__(17);
	Vue.field.types.text = '<input type="text" v-bind="attrs" v-model="value">';
	Vue.field.types.textarea = '<textarea v-bind="attrs" v-model="value"></textarea>';
	Vue.field.types.select = '<select v-bind="attrs" v-model="value"><option v-for="option in options" :value="option">{{ $key }}</option></select>';
	Vue.field.types.radio = '<p class="uk-form-controls-condensed"><label v-for="option in options"><input type="radio" :value="option" v-model="value"> {{ $key | trans }}</label></p>';
	Vue.field.types.checkbox = '<p class="uk-form-controls-condensed"><label><input type="checkbox" v-bind="attrs" v-model="value" v-bind:true-value="1" v-bind:false-value="0" number> {{ optionlabel | trans }}</label></p>';
	Vue.field.types.number = '<input type="number" v-bind="attrs" v-model="value" number>';
	Vue.field.types.title = '<h3 v-bind="attrs">{{ title | trans }}</h3>';


	Vue.ready(module.exports);



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
	        'category.show_subcategories': {
	            type: 'checkbox',
	            label: 'Subcategories',
	            optionlabel: 'Show subcategories'
	        },
	        'subcategories_columns': {
	            type: 'select',
	            label: 'Subcategories columns',
	            options: options.gridcols.base,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'subcategories_panel_style': {
	            type: 'select',
	            label: 'Subcategories panel style',
	            options: options.panel_style,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'subcategories_content_align': {
	            type: 'select',
	            label: 'Subcategories title alignment',
	            options: options.align.general,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'subcategories_title_size': {
	            type: 'select',
	            label: 'Subcategories title size',
	            options: options.heading_size,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'title1': {
	            raw: true,
	            type: 'title',
	            label: '',
	            title: 'Grid settings',
	            attrs: {'class': 'uk-margin-top'}
	        },
	        'filter_items': {
	            type: 'select',
	            label: 'Filter items',
	            options: {
	                'Don\'t filter': '',
	                'Categories': 'category',
	                'Tags': 'tag'
	            },
	            attrs: {'class': 'uk-form-width-medium'}
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
	    category: {
	        'category.image_align': {
	            type: 'select',
	            label: 'Image alignment',
	            options: options.align.general,
	            attrs: {'class': 'uk-form-width-medium'}
	        },
	        'title1': {
	            raw: true,
	            type: 'title',
	            label: '',
	            title: 'Grid settings',
	            attrs: {'class': 'uk-margin-top'}
	        },
	        'category.filter_items': {
	            type: 'checkbox',
	            label: 'Filter by tags'
	        },
	        'category.columns': {
	            type: 'select',
	            label: 'Phone Portrait',
	            options: options.gridcols.base,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'category.columns_small': {
	            type: 'select',
	            label: 'Phone Landscape',
	            options: options.gridcols.inherit,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'category.columns_medium': {
	            type: 'select',
	            label: 'Tablet',
	            options: options.gridcols.inherit,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'category.columns_large': {
	            type: 'select',
	            label: 'Desktop',
	            options: options.gridcols.inherit,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'category.columns_xlarge': {
	            type: 'select',
	            label: 'Large screens',
	            options: options.gridcols.inherit,
	            attrs: {'class': 'uk-form-width-small'}
	        },
	        'category.columns_gutter': {
	            type: 'select',
	            label: 'Gutter width',
	            options: options.gutter,
	            attrs: {'class': 'uk-form-width-small'}
	        }
	    },
	    category_show: {
	        'category.show_title': {
	            type: 'checkbox',
	            label: 'Show content',
	            optionlabel: 'Show title'
	        },
	        'category.show_image': {
	            type: 'checkbox',
	            optionlabel: 'Show image'
	        },
	        'category.show_description': {
	            type: 'checkbox',
	            optionlabel: 'Show description'
	        }
	    },
	    teaser_show: {
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
	        'teaser.show_version': {
	            type: 'checkbox',
	            optionlabel: 'Show version'
	        },
	        'teaser.show_category': {
	            type: 'checkbox',
	            optionlabel: 'Show category'
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
	        }
	    },
	    teaser: {
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
	        'teaser.demo_style': {
	            type: 'select',
	            label: 'Demo link button style',
	            options: options.button_style,
	            attrs: {'class': 'uk-form-width-medium'}
	        }
	    },
	    general: {
	        'routing': {
	            type: 'select',
	            label: 'Routing type',
	            options: {
	                'Include category': 'category',
	                'Direct item links': 'item'
	            },
	            attrs: {'class': 'uk-form-width-medium'}
	        },
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
	        'count_admindownloads': {
	            type: 'checkbox',
	            label: 'Download count',
	            optionlabel: 'Count administrator downloads'
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
	    }

	};

/***/ },
/* 13 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(14)

	if (module.exports.__esModule) module.exports = module.exports.default
	;(typeof module.exports === "function" ? module.exports.options : module.exports).template = __webpack_require__(15)
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
/* 14 */
/***/ function(module, exports) {

	'use strict';

	// <template>

	//     <div class="uk-flex uk-flex-wrap" data-uk-margin="">

	//         <div v-for="tag in tags" class="uk-badge uk-margin-small-right">

	//             <a class="uk-float-right uk-close" @click.prevent="removeTag(tag)"></a>

	//             {{ tag }}

	//         </div>

	//     </div>

	//     <div class="uk-flex uk-flex-middle uk-margin">

	//         <div>

	//             <div class="uk-position-relative" data-uk-dropdown="">

	//                 <button type="button" class="uk-button uk-button-small">{{ 'Existing' | trans }}</button>

	//                 <div class="uk-dropdown uk-dropdown-small">

	//                     <ul class="uk-nav uk-nav-dropdown">

	//                         <li v-for="tag in existing"><a @click.prevent="addTag(tag)">{{ tag }}</a></li>

	//                     </ul>

	//                 </div>

	//             </div>

	//         </div>

	//         <div class="uk-flex-item-1 uk-margin-small-left">

	//             <div class="uk-form-password">

	//                 <input type="text" class="uk-width-1-1" v-model="newtag">

	//                 <a class="uk-form-password-toggle" @click.prevent="addTag()"><i class="uk-icon-check uk-icon-hover"></i></a>

	//             </div>

	//         </div>

	//     </div>

	// </template>

	// <script>

	module.exports = {

	    props: ['tags', 'existing'],

	    data: function data() {
	        return {
	            'newtag': ''
	        };
	    },

	    methods: {

	        addTag: function addTag(tag) {
	            if (!tag) return;
	            this.tags.push(tag || this.newtag);
	            this.$nextTick(function () {
	                UIkit.$html.trigger('resize'); //todo why no check.display or changed.dom???
	            });
	            this.newtag = '';
	        },

	        removeTag: function removeTag(tag) {
	            this.tags.$remove(tag);
	        }

	    }

	};

	// </script>

/***/ },
/* 15 */
/***/ function(module, exports) {

	module.exports = "<div class=\"uk-flex uk-flex-wrap\" data-uk-margin=\"\">\r\n        <div v-for=\"tag in tags\" class=\"uk-badge uk-margin-small-right\">\r\n            <a class=\"uk-float-right uk-close\" @click.prevent=\"removeTag(tag)\"></a>\r\n            {{ tag }}\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"uk-flex uk-flex-middle uk-margin\">\r\n        <div>\r\n            <div class=\"uk-position-relative\" data-uk-dropdown=\"\">\r\n                <button type=\"button\" class=\"uk-button uk-button-small\">{{ 'Existing' | trans }}</button>\r\n\r\n                <div class=\"uk-dropdown uk-dropdown-small\">\r\n                    <ul class=\"uk-nav uk-nav-dropdown\">\r\n                        <li v-for=\"tag in existing\"><a @click.prevent=\"addTag(tag)\">{{ tag }}</a></li>\r\n                    </ul>\r\n                </div>\r\n            </div>\r\n\r\n        </div>\r\n        <div class=\"uk-flex-item-1 uk-margin-small-left\">\r\n            <div class=\"uk-form-password\">\r\n                <input type=\"text\" class=\"uk-width-1-1\" v-model=\"newtag\">\r\n                <a class=\"uk-form-password-toggle\" @click.prevent=\"addTag()\"><i class=\"uk-icon-check uk-icon-hover\"></i></a>\r\n            </div>\r\n        </div>\r\n\r\n    </div>";

/***/ },
/* 16 */
/***/ function(module, exports) {

	module.exports = "<div v-for=\"field in fields\" :class=\"{'uk-form-row': !field.raw}\">\r\n    <label v-if=\"field.label\" class=\"uk-form-label\">\r\n        <i v-if=\"field.tip\" class=\"uk-icon-info uk-icon-hover uk-margin-small-right\" data-uk-tooltip=\"{delay: 100}\" :title=\"field.tip\"></i>\r\n        {{ field.label | trans }}\r\n    </label>\r\n    <div v-if=\"!field.raw\" class=\"uk-form-controls\" :class=\"{'uk-form-controls-text': ['checkbox', 'radio'].indexOf(field.type)>-1}\">\r\n        <field :config=\"field\" :values.sync=\"values\"></field>\r\n    </div>\r\n    <field v-else :config=\"field\" :values.sync=\"values\"></field>\r\n</div>\r\n";

/***/ },
/* 17 */
/***/ function(module, exports) {

	module.exports = "<template v-for=\"field in fields\">\r\n    <field :config=\"field\" :values.sync=\"values\"></field>\r\n</template>\r\n";

/***/ }
/******/ ]);