<template>

    <div class="uk-flex uk-flex-wrap" data-uk-margin="">
        <div v-repeat="values" class="uk-badge uk-margin-small-right">
            <a class="uk-float-right uk-close" v-on="click: removeCategory($index)"></a>
            {{ getText($value) }}
        </div>
    </div>

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
    <pre>{{$data|json}}</pre>
</template>

<script>

    module.exports = {

        props: ['values', 'categories'],

        data: function () {
            return {
                'tree': {},
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
                    this.$nextTick(function () {
                        UIkit.$html.trigger('resize'); //todo why no check.display or changed.dom???
                    });
                }
            },

            removeCategory: function(idx) {
                this.values.$remove(idx);
            },

            isSelected: function (value) {
                return this.values.indexOf(value) > -1;
            },

            getText: function (value) {
                return _.find(this.categories, 'id', value).title;
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
