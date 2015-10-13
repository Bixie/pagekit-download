<template>

    <ul class="uk-list">
        <li v-repeat="values">
            <div class="uk-nestable-panel uk-visible-hover uk-flex uk-flex-middle">
                <div class="uk-flex-item-1">
                    {{ getText($value) }}
                </div>
                <div class="">
                    <ul class="uk-subnav pk-subnav-icon">
                        <li><a class="pk-icon-star"
                               data-uk-tooltip="{delay: 300}" title="{{ 'Make primary category' | trans }}"
                               v-class="uk-invisible: primary !== $value"
                               v-on="click: primary = $value"></a></li>
                        <li><a class="pk-icon-delete pk-icon-hover uk-invisible" v-on="click: removeCategory($index)"></a></li>
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
                        <category-item v-repeat="category: tree[0]"></category-item>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</template>

<script>

    module.exports = {

        props: ['values', 'primary', 'categories'],

        data: function () {
            return {
                'tree': {},
                'primary': '',
                'values': [],
                'categories': {}
            };
        },

        created: function () {
            this.tree = _(this.categories).sortBy('priority').groupBy('parent_id').value();
        },

        computed: {
            categorieOptions: function () {
                var options = [];
                _.forIn(this.categories, function (category) {
                    options.push({value: category.id, text: category.title});
                });
                return options;
            }
        },

        methods: {

            addCategory: function(value) {
                if (!this.isSelected(value)) {
                    this.values.push(value);
                    this.checkPrimary();
                }
            },

            removeCategory: function(idx) {
                this.values.$remove(idx);
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

                template: '<li v-class="uk-parent: tree[category.id]">\n    <a v-on="click: addCategory(category.id)" v-class="uk-text-primary: isSelected(category.id)">{{ category.title }}</a>\n    <ul class="uk-nav-sub" v-if="tree[category.id]">\n        <category-item v-repeat="category: tree[category.id]"></category-item>\n    </ul>\n</li>',

                inherit: true
            }

        }

    };

</script>
