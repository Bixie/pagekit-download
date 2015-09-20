<template>

    <div v-on="click: pick" class="{{ class }}">
        <ul class="uk-float-right uk-subnav pk-subnav-icon">
            <li><a class="pk-icon-delete pk-icon-hover" title="{{ 'Delete' | trans }}" data-uk-tooltip="{delay: 500, 'pos': 'left'}" v-on="click: remove"></a></li>
        </ul>
        <a class="pk-icon-folder-circle uk-margin-right"></a>
        <a v-if="!file" class="uk-text-muted">{{ 'Select file' | trans }}</a>
        <a v-if="file" data-uk-tooltip="" title="{{ file }}">{{ fileName }}</a>
    </div>

    <v-modal v-ref="modal" large>

        <panel-finder root="{{ storage }}" v-ref="finder" modal="true"></panel-finder>

        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-link uk-modal-close" type="button">{{ 'Cancel' | trans }}</button>
            <button class="uk-button uk-button-primary" type="button" v-attr="disabled: !hasSelection()" v-on="click: select()">{{ 'Select' | trans }}</button>
        </div>

    </v-modal>

</template>

<script>

    module.exports = {

        props: ['file', 'ext', 'multiple', 'class'],

        data: function () {
            return _.merge({
                'file': '',
                'ext': [],
                'class': '',
                'multile': false
            }, $pagekit);
        },

        computed: {
            fileName: function () {
                return this.file.split('/').pop();
            }
        },

        methods: {

            pick: function() {
                this.$.modal.open();
            },

            select: function() {
                this.$set('file', this.$.finder.getSelected()[0]);
                this.$dispatch('file-selected', this.file);
                this.$.finder.removeSelection();
                this.$.modal.close();
            },

            remove: function(e) {
                e.stopPropagation();
                this.file = ''
            },

            hasSelection: function() {
                var selected = this.$.finder.getSelected();
                if (!this.multiple && !(selected.length === 1)) {
                    return false;
                }
                //todo there must be a prettier way
                return selected[0].match(new RegExp('\.(?:' + (this.ext || []).join('|') + ')$', 'i'));
            }

        }

    };

    Vue.component('input-file', function (resolve, reject) {
        Vue.asset({
            js: [
                'app/assets/uikit/js/components/upload.min.js',
                'app/system/modules/finder/app/bundle/panel-finder.js'
            ]
        }, function () {
            resolve(module.exports);
        })
    });

</script>
