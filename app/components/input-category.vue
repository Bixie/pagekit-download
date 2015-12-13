<template>

    <ul class="uk-list">
        <li v-for="value in values">
            <div class="uk-nestable-panel uk-visible-hover uk-flex uk-flex-middle">
                <div class="uk-flex-item-1">
                    {{ getText(value) }}
                </div>
                <div class="">
                    <ul class="uk-subnav pk-subnav-icon">
                        <li><a class="pk-icon-star"
                               data-uk-tooltip="{delay: 300}" title="{{ 'Make primary category' | trans }}"
                               :class="{'uk-invisible': primary !== value}"
                               @click.prevent="primary = value"></a></li>
                        <li><a class="pk-icon-delete pk-icon-hover uk-invisible" @click.prevent="removeCategory(value)"></a></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>

    <div id="select-category" class="uk-flex uk-flex-middle uk-margin">
        <div>
            <div class="uk-position-relative" data-uk-dropdown="{justify:'#select-category'}">
                <button type="button" class="uk-button uk-button-small">{{ 'Please select' | trans }}</button>

                <div class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                        <category-item v-for="category in tree[0]" :category="category" :tree="tree"></category-item>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</template>

<script>

    module.exports = {

        props: {
            'values': {default: []},
            'primary': {default: 0},
            'categories': {default: []}
        },

        data: function () {
            return {
                'tree': {}
            };
        },

        created: function () {
            this.tree = _(this.categories).sortBy('priority').groupBy('parent_id').value();
        },

        methods: {

            addCategory: function(value) {
                if (!this.isSelected(value)) {
                    this.values.push(value);
                    this.checkPrimary();
                }
            },

            removeCategory: function(value) {
                this.values.$remove(value);
                this.checkPrimary();
            },

            isSelected: function (value) {
                return this.values.indexOf(value) > -1;
            },

            getText: function (value) {
                return _.find(this.categories, 'id', value).title;
            },

            checkPrimary: function () {
                if (this.values.length && this.values.indexOf(this.primary) == -1) {
                    this.primary = this.values[0];
                }
            }

        },

        components: {

            categoryItem: {

                name: 'categoryItem',

                props: ['category', 'tree'],

                template: '<li :class="{\'uk-parent\': tree[category.id]}">\n    <a @click.prevent="addCategory()" :class="{\'uk-text-primary\': isSelected()}">{{ category.title }}</a>\n    <ul class="uk-nav-sub" v-if="tree[category.id]">\n        <category-item v-for="category in tree[category.id]" :category="category" :tree="tree"></category-item>\n    </ul>\n</li>',

                methods: {
                    isSelected: function () {
                        this.getBase().isSelected(this.category.id);
                    },
                    addCategory: function () {
                        this.getBase().addCategory(this.category.id);
                    },
                    getBase: function () {
                        var base = this.$parent;
                        do {

                            if (base.$options.name == 'input-category') {
                                return base;
                            }

                            base = base.$parent;

                        } while (base);

                    }
                }
            }

        }

    };

</script>
