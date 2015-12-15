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
/***/ function(module, exports) {

	module.exports = {

	    el: '#download-categories',

	    data: function () {
	        return _.merge({
	            categories: [],
	            tree: [],
	            selected: []
	        }, window.$data);
	    },

	    created: function () {
	        this.Categories = this.$resource('api/download/category/:id');
	        this.load();
	    },

	    ready: function () {

	        var vm = this;

	        UIkit.nestable(this.$els.nestable, {
	            maxDepth: 20,
	            group: 'download.categories'
	        }).on('change.uk.nestable', function (e, nestable, el, type) {

	            if (type && type !== 'removed') {

	                vm.Categories.save({id: 'updateOrder'}, {
	                    categories: nestable.list()
	                }, vm.load).error(function () {
	                    this.$notify('Reorder failed.', 'danger');
	                });
	            }
	        });

	    },

	    methods: {

	        load: function () {
	            var vm = this;
	            return this.Categories.query({}, function (categories) {
	                vm.$set('categories', categories);
	                vm.$set('selected', []);
	            });
	        },

	        status: function (status) {

	            var categories = this.getSelected();

	            categories.forEach(function (category) {
	                category.status = status;
	            });

	            this.Categories.save({id: 'bulk'}, {categories: categories}, function () {
	                this.load();
	                this.$notify('Category(ies) saved.');
	            });
	        },

	        removeCategories: function () {

	            if (this.menu.id !== 'trash') {

	                var categories = this.getSelected();

	                categories.forEach(function (category) {
	                    category.status = 0;
	                });

	                this.moveNodes('trash');

	            } else {
	                this.Categories.delete({id: 'bulk'}, {ids: this.selected}, function () {
	                    this.load();
	                    this.$notify('Categories deleted.');
	                });
	            }
	        },

	        getSelected: function () {
	            return this.categories.filter(function (category) {
	                return this.isSelected(category);
	            }, this);
	        },

	        isSelected: function (category, children) {

	            if (_.isArray(category)) {
	                return _.every(category, function (category) {
	                    return this.isSelected(category, children);
	                }, this);
	            }

	            return this.selected.indexOf(category.id) !== -1 && (!children || !this.tree[category.id] || this.isSelected(this.tree[category.id], true));
	        },

	        toggleSelect: function (category) {

	            var index = this.selected.indexOf(category.id);

	            if (index == -1) {
	                this.selected.push(category.id);
	            } else {
	                this.selected.splice(index, 1);
	            }
	        }

	    },

	    computed: {

	        showDelete: function () {
	            return this.isSelected(this.getSelected(), true);
	        }

	    },

	    watch: {

	        categories: function () {
	            this.$set('tree', _(this.categories).sortBy('priority').groupBy('parent_id').value());
	        }

	    },

	    filters: {

	    },

	    components: {

	        category: {

	            name: 'category',

	            props: ['category', 'tree'],

	            template: '#category',

	            methods: {

	                toggleStatus: function () {

	                    this.category.status = this.category.status === 1 ? 0 : 1;

	                    this.$root.Categories.save({id: this.category.id}, {category: this.category}, function () {
	                        this.$root.load();
	                        this.$notify('Category saved.');
	                    });
	                }

	            }

	        }

	    }

	};

	Vue.ready(module.exports);


/***/ }
/******/ ]);