
require('../../components/input-file.vue');

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

        'input-tags': require('../../components/input-tags.vue')

    }

});

$(function () {

    (new module.exports()).$mount('#file-edit');

});
