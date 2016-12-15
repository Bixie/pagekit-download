<template>

    <div class="uk-form-horizontal uk-margin">

        <div class="uk-form-row">
            <span class="uk-form-label">{{ 'Date' | trans }}</span>
            <div class="uk-form-controls">
                <input-date :datetime.sync="file.date"></input-date>
            </div>
        </div>

        <div class="uk-form-row">
            <label for="form-demo_url" class="uk-form-label">{{ 'Demo url' | trans }}</label>

            <div class="uk-form-controls">
                <input id="form-demo_url" class="uk-width-1-1" type="text" v-model="file.data.demo_url">
            </div>
        </div>

        <div class="uk-form-row">
            <label for="form-version" class="uk-form-label">{{ 'Version' | trans }}</label>

            <div class="uk-form-controls">
                <input id="form-version" class="uk-width-1-1" type="text" v-model="file.data.version">
            </div>
        </div>

        <div v-for="datafield in config.datafields" class="uk-form-row">

            <datafieldvalue :datafield="datafield" :value.sync="file.data[datafield.name]"></datafieldvalue>

        </div>
    </div>

</template>

<script>

    module.exports = {

        section: {
            label: 'Data',
            priority: 10
        },

        props: ['file', 'config', 'form'],

        created: function () {
            this.$on('datafieldvalue.changed', function (name, value) {
                this.file.data[name] = value;
            });
        },

        components: {

            datafieldvalue: {

                props: ['datafield', 'value'],

                template: '<label for="form-{{ datafield.name }}" class="uk-form-label">{{ datafield.label }}</label>\n<div class="uk-form-controls">\n    <input id="form-{{ datafield.name }}" class="uk-form-width-large" type="text" name="{{ datafield.name }}"\n           v-model="value">\n</div>\n',

                watch: {
                    value: function (value) {
                        this.$dispatch('datafieldvalue.changed', this.datafield.name, value);
                    }
                }

            }

        }


    };

</script>
