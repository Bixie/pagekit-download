<template>

    <div @click=" pick" class="{{ class }}">
        <ul class="uk-float-right uk-subnav pk-subnav-icon">
            <li><a class="pk-icon-delete pk-icon-hover" title="{{ 'Delete' | trans }}" data-uk-tooltip="{delay: 500, 'pos': 'left'}" @click.prevent="remove"></a></li>
        </ul>
        <a class="pk-icon-folder-circle uk-margin-right"></a>
        <a v-if="!file" class="uk-text-muted">{{ 'Select file' | trans }}</a>
        <a v-else data-uk-tooltip="" title="{{ file }}">{{ fileName }}</a>
    </div>

    <v-modal v-ref:modal large>

        <panel-finder :root="root" v-ref:finder :modal="true"></panel-finder>

        <div v-show="!hasSelection()" class="uk-alert">{{ 'Select one file of the following types' | trans }}: {{ this.ext.join(', ') }}</div>

        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-link uk-modal-close" type="button">{{ 'Cancel' | trans }}</button>
            <button class="uk-button uk-button-primary" type="button" :disabled="!hasSelection()" @click="select()">{{ 'Select' | trans }}</button>
        </div>

    </v-modal>

</template>

<script>

    module.exports = {

        props: {
            'file': {default: ''},
            'ext': {type: Array, default: []},
            'multiple': {type: Boolean, default: false},
            'root': {default: 'storage'},
            'class': {default: ''}
        },

        data: function () {
            return _.merge({}, $pagekit);
        },

        computed: {
            fileName: function () {
                return this.file.split('/').pop();
            }
        },

        methods: {

            pick: function() {
                this.$refs.modal.open();
            },

            select: function() {
                this.$set('file', this.root + this.getSelected()[0]);
                this.$dispatch('file-selected', this.file);
                this.$refs.finder.removeSelection();
                this.$refs.modal.close();
            },

            remove: function(e) {
                e.stopPropagation();
                this.file = ''
            },

            //get path instead of url from selected
            getSelected: function () {
                return this.$refs.finder.selected.map(function (name) {
                    return _.find(this.$refs.finder.items, 'name', name).path;
                }, this);
            },

            hasSelection: function() {
                var selected = this.$refs.finder.getSelected();
                if (!this.multiple && !(selected.length === 1)) {
                    return false;
                }
                //todo there must be a prettier way
                return selected[0].match(new RegExp('\.(?:' + (this.ext).join('|') + ')$', 'i'));
            }

        }

    };

    Vue.component('input-file', function (resolve, reject) {
        Vue.asset({
            js: [
                'app/assets/uikit/js/components/upload.min.js',
                'app/system/modules/finder/app/bundle/panel-finder.js'
            ]
        }).then(function () {
            resolve(module.exports);
        });
    });

</script>
