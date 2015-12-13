
require('../../components/input-file.vue');

module.exports = {

    el: '#file-edit',

    data: function () {
        return _.merge({
            tags: [],
            file: {},
            config: {},
            form: {}
        }, window.$data);
    },

    ready: function () {
        this.resource = this.$resource('api/download/file/:id');
        this.tab = UIkit.tab(this.$els.tab, {connect: this.$els.content});
    },

    computed: {

        sections: function () {

            var sections = [];

            _.forIn(this.$options.components, function (component, name) {

                var options = component.options || {}, section = options.section;

                if (section) {
                    section.name = name;
                    sections.push(section);
                }

            });

            return sections;
        }

    },

    methods: {

        save: function () {

            var data = {file: this.file};

            this.$broadcast('save', data);

            this.resource.save({id: this.file.id}, data, function (data) {

                if (!this.file.id) {
                    window.history.replaceState({}, '', this.$url.route('admin/download/file/edit', {id: data.file.id}));
                }

                this.$set('file', data.file);

                this.$broadcast('saved', data);

                this.$notify(this.$trans('Download %title% saved.', {title: this.file.title}));

            }, function (data) {
                this.$notify(data, 'danger');
            });
        },

        resetDownloads: function () {
            this.file.downloads = 0;
            this.save();
        }

    },

    mixins: [window.BixieDownloads]

};

Vue.ready(module.exports);
