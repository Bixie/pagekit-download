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

	    el: '#category-edit',

	    data: function () {
	        return _.merge({
	            category: {},
	            roles: [],
	            form: {}
	        }, window.$data);
	    },

	    ready: function () {
	        var vm = this;
	        UIkit.sortable(this.$els.sortable, {
	            handleClass: 'pk-icon-move'
	        }).on('change.uk.sortable', function (e, sortable, el) {
	            var catordering = 1;
	            _.forEach(sortable.serialize(), function (file) {
	                _.find(vm.category.files, 'id', file.id).catordering = catordering;
	                catordering += 1;
	            });
	        });
	        this.resource = this.$resource('api/download/category/{id}');

	    },

	    computed: {

	        path: function () {
	            return (this.category.path ? this.category.path.split('/').slice(0, -1).join('/') : '') + '/' + (this.category.slug || '');
	        }

	    },

	    methods: {

	        save: function () {

	            var data = {category: this.category};

	            this.$broadcast('save', data);

	            this.resource.save({id: this.category.id || 0}, data).then(function (res) {

	                if (!this.category.id) {
	                    window.history.replaceState({}, '', this.$url.route('admin/download/category/edit', {id: res.data.category.id}));
	                }

	                this.$set('category', res.data.category);

	                this.$broadcast('saved', res.data);

	                this.$notify(this.$trans('Category %title% saved.', {title: this.category.title}));

	            }, function (res) {
	                this.$notify(res.data, 'danger');
	            });
	        }

	    }

	};

	Vue.ready(module.exports);


/***/ }
/******/ ]);