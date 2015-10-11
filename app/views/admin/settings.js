module.exports = Vue.extend({

    data: function () {
        return window.$data;
    },

    fields: require('../../settings/fields'),

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

Vue.field.templates.formrow = require('../../templates/formrow.html');
Vue.field.types.checkbox = '<p class="uk-form-controls-condensed"><label><input type="checkbox" v-attr="attrs" v-model="value"> {{ optionlabel | trans }}</label></p>';
Vue.field.types.number = '<input type="number" v-attr="attrs" v-model="value" number>';

$(function () {

    (new module.exports()).$mount('#download-settings');

});
