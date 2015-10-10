
require('../../components/input-file.vue');

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