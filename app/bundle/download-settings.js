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

	module.exports = {

	    el: '#download-settings',

	    data: function () {
	        return window.$data;
	    },

	    fields: __webpack_require__(9),

	    ready: function () {
	        var vm = this;
	        UIkit.nestable(this.$els.datafieldsNestable, {
	            maxDepth: 1,
	            handleClass: 'uk-nestable-handle',
	            group: 'portfolio.datafields'
	        }).on('change.uk.nestable', function (e, nestable, el, type) {
	            if (type && type !== 'removed') {
	                var datafields = [];
	                _.forEach(nestable.list(), function (option) {
	                    datafields.push(_.find(vm.config.datafields, 'name', option.name));
	                });
	                vm.$set('config.datafields', datafields);
	            }
	        });

	    },

	    methods: {

	        save: function () {
	            this.$http.post('admin/system/settings/config', { name: 'bixie/download', config: this.config }).then(function () {
	                this.$notify('Settings saved.');
	            }, function (data) {
	                this.$notify(data, 'danger');
	            });
	        },

	        addDatafield: function () {
	            this.config.datafields.push({
	                name: '',
	                label: '',
	                attachValue: true,
	                invalid: false
	            });
	            this.$nextTick(function () {
	                UIkit.$(this.$els.datafieldsNestable).find('input:last').focus();
	            });
	        },

	        deleteDatafield: function (field) {
	            this.config.datafields.$remove(field);
	            this.checkDuplicates();
	        },

	        clearCache: function () {
	            this.imageApi.query({task: 'clearcache'}, function (data) {
	                this.$notify(data.message);
	            });
	        },

	        checkDuplicates: function () {
	            var current, dups = [];
	            _.sortBy(this.config.datafields, 'name').forEach(function (datafield) {
	                if (current && current === datafield.name) {
	                    dups.push(datafield.name);
	                }
	                current = datafield.name;
	            });
	            this.config.datafields.forEach(function (datafield) {
	                datafield.invalid = dups.indexOf(datafield.name) > -1 ? 'Duplicate name' : false;
	            });
	        }
	    },

	    components: {

	        datafield: {

	            template: '<li class="uk-nestable-item" data-name="{{ datafield.name }}">\n    <div class="uk-nestable-panel uk-visible-hover uk-form uk-flex uk-flex-middle">\n        <div class="uk-flex-item-1">\n            <div class="uk-form-row">\n                <small class="uk-form-label uk-text-muted uk-text-truncate" style="text-transform: none"\n                       v-show="datafield.attachValue"\n                       :class="{\'uk-text-danger\': datafield.invalid}">{{ datafield.name }}</small>\n                <span class="uk-form-label" v-show="!datafield.attachValue">\n                    <input type="text" class="uk-form-small"\n                           @keyup="safeValue(true)"\n                           :class="{\'uk-text-danger\': datafield.invalid}"\n                           v-model="datafield.name"/></span>\n                <div class="uk-form-controls">\n                    <input type="text" class="uk-form-width-large" v-model="datafield.label"/></div>\n                <p class="uk-form-help-block uk-text-danger" v-show="datafield.invalid">{{ datafield.invalid | trans }}</p>\n\n            </div>\n        </div>\n        <div class="">\n            <ul class="uk-subnav pk-subnav-icon">\n                <li><a class="uk-icon uk-margin-small-top pk-icon-hover uk-invisible"\n                       data-uk-tooltip="{delay: 500}" :title="\'Link/Unlink name from label\' | trans"\n                       :class="{\'uk-icon-link\': !datafield.attachValue, \'uk-icon-chain-broken\': datafield.attachValue}"\n                       @click="datafield.attachValue = !datafield.attachValue"></a></li>\n                <li><a class="pk-icon-delete pk-icon-hover uk-invisible" @click="$parent.deleteDatafield(datafield)"></a></li>\n                <li><a class="pk-icon-move pk-icon-hover uk-invisible uk-nestable-handle"></a></li>\n            </ul>\n        </div>\n    </div>\n</li>   \n',

	            props: ['datafield'],

	            methods: {
	                safeValue: function (checkDups) {
	                    this.datafield.name = _.escape(_.snakeCase(this.datafield.name));
	                    if (checkDups) {
	                        this.$parent.checkDuplicates();
	                    }
	                }
	            },

	            watch: {
	                "datafield.label": function (name) {
	                    if (this.datafield.attachValue) {
	                        this.datafield.name = _.escape(_.snakeCase(name));
	                    }
	                    this.$parent.checkDuplicates();
	                }

	            }
	        }

	    }

	};

	Vue.ready(module.exports);



/***/ },

/***/ 9:
/***/ function(module, exports, __webpack_require__) {

	
	var options = __webpack_require__(10);

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

/***/ 10:
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

/***/ }

/******/ });