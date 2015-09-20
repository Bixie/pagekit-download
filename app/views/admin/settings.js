module.exports = Vue.extend({

    data: function () {
        return window.$data;
    },

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

        'input-tags': require('../../components/input-tags.vue')

    }

});

$(function () {

    (new module.exports()).$mount('#download-settings');

});
