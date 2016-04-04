<template>

    <div class="uk-grid pk-grid-large pk-width-sidebar-large" data-uk-grid-margin>
        <div class="pk-width-content uk-form-horizontal">

            <div class="uk-form-row">
                <label for="form-title" class="uk-form-label">{{ 'Title' | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-title" class="uk-form-width-large" type="text" name="title" v-model="widget.title" v-validate:required>
                    <p class="uk-form-help-block uk-text-danger" v-show="form.title.invalid">{{ 'Title cannot be blank.' | trans }}</p>
                </div>
            </div>

            <div class="uk-form-row">
                <label for="form-view" class="uk-form-label">{{ 'View' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-view" v-model="widget.data.view" class="uk-form-width-medium">
                        <option value="list">{{ 'List' | trans }}</option>
                        <option value="slider">{{ 'Slider' | trans }}</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="pk-width-sidebar">

            <partial name="settings"></partial>

        </div>
    </div>

</template>

<script>


    module.exports = {

        section: {
            label: 'Settings'
        },

        replace: false,

        props: ['widget', 'config', 'form'],

        created: function () {
            this.$options.partials = this.$parent.$options.partials;
            this.$set('widget.data', _.merge({
                view: 'list',
                items: []
            }, this.widget.data));
        }
    };

    window.Widgets.components['bixie-downloads:settings'] = module.exports;

</script>
