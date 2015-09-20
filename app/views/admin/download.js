module.exports = {

    data: function () {
        return _.merge({
            files: false,
            pages: 0,
            count: '',
            selected: []
        }, window.$data);
    },

    created: function () {
        this.resource = this.$resource('api/download/file/:id');
        this.config.filter = _.extend({ search: '', order: 'title asc', limit: this.config.files_per_page}, this.config.filter);
    },

    methods: {

        active: function (portfolio) {
            return this.selected.indexOf(portfolio.id) != -1;
        },

        load: function (page) {

            page = page !== undefined ? page : this.config.page;

            return this.resource.query({ filter: this.config.filter, page: page }, function (data) {
                this.$set('files', data.files);
                this.$set('pages', data.pages);
                this.$set('count', data.count);
                this.$set('config.page', page);
                this.$set('selected', []);
            });
        },

        getSelected: function () {
            return this.projects.filter(function (project) {
                return this.selected.indexOf(project.id) !== -1;
            }, this);
        },

        removeFiles: function () {

            this.resource.delete({id: 'bulk'}, {ids: this.selected}, function () {
                this.load();
                this.$notify('File(s) deleted.');
            });
        }

    },

    watch: {
        'config.page': 'load',

        'config.filter': {
            handler: function () { this.load(0); },
            deep: true
        }
    }


};

$(function () {

    new Vue(module.exports).$mount('#download-files');

});
