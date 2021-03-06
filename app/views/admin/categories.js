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
        this.Categories = this.$resource('api/download/category/{id}');
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
                }).then(function () {
                    vm.load();
                }, function () {
                    this.$notify('Reorder failed.', 'danger');
                });
            }
        });

    },

    methods: {

        load: function () {
            var vm = this;
            return this.Categories.query({}).then(function (res) {
                vm.$set('categories', res.data);
                vm.$set('selected', []);
            });
        },

        status: function (status) {

            var categories = this.getSelected();

            categories.forEach(function (category) {
                category.status = status;
            });

            this.Categories.save({id: 'bulk'}, {categories: categories}).then(function () {
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
                this.Categories.delete({id: 'bulk'}, {ids: this.selected}).then(function () {
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

                    this.$root.Categories.save({id: this.category.id}, {category: this.category}).then(function () {
                        this.$root.load();
                        this.$notify('Category saved.');
                    });
                }

            }

        }

    }

};

Vue.ready(module.exports);
