
var options = require('./options');

Vue.field.templates.formrow = require('../templates/formrow.html');
Vue.field.templates.raw = require('../templates/raw.html');
Vue.field.types.checkbox = '<p class="uk-form-controls-condensed"><label><input type="checkbox" v-attr="attrs" v-model="value"> {{ optionlabel | trans }}</label></p>';
Vue.field.types.number = '<input type="number" v-attr="attrs" v-model="value" number>';
Vue.field.types.title = '<h3 v-attr="attrs">{{ title | trans }}</h3>';

module.exports = {
    portfolio: {
        'title1': {
            raw: true,
            type: 'title',
            label: '',
            title: 'Grid settings',
            attrs: {'class': 'uk-margin-top'}
        },
        'filter_items': {
            type: 'select',
            label: 'Filter items',
            options: {
                'Don\'t filter': '',
                'Categories': 'category',
                'Tags': 'tag'
            },
            attrs: {'class': 'uk-form-width-medium'}
        },
        'columns': {
            type: 'select',
            label: 'Phone Portrait',
            options: options.gridcols.base,
            attrs: {'class': 'uk-form-width-small'}
        },
        'columns_small': {
            type: 'select',
            label: 'Phone Landscape',
            options: options.gridcols.inherit,
            attrs: {'class': 'uk-form-width-small'}
        },
        'columns_medium': {
            type: 'select',
            label: 'Tablet',
            options: options.gridcols.inherit,
            attrs: {'class': 'uk-form-width-small'}
        },
        'columns_large': {
            type: 'select',
            label: 'Desktop',
            options: options.gridcols.inherit,
            attrs: {'class': 'uk-form-width-small'}
        },
        'columns_xlarge': {
            type: 'select',
            label: 'Large screens',
            options: options.gridcols.inherit,
            attrs: {'class': 'uk-form-width-small'}
        },
        'columns_gutter': {
            type: 'select',
            label: 'Gutter width',
            options: options.gutter,
            attrs: {'class': 'uk-form-width-small'}
        }
    },
    teaser_show: {
        'teaser.show_title': {
            type: 'checkbox',
            label: 'Show content',
            optionlabel: 'Show title'
        },
        'teaser.show_subtitle': {
            type: 'checkbox',
            optionlabel: 'Show subtitle'
        },
        'teaser.show_image': {
            type: 'checkbox',
            optionlabel: 'Show image'
        },
        'teaser.show_tags': {
            type: 'checkbox',
            optionlabel: 'Show tags'
        },
        'teaser.show_date': {
            type: 'checkbox',
            optionlabel: 'Show date'
        },
        'teaser.show_version': {
            type: 'checkbox',
            optionlabel: 'Show version'
        },
        'teaser.show_category': {
            type: 'checkbox',
            optionlabel: 'Show category'
        },
        'teaser.show_readmore': {
            type: 'checkbox',
            optionlabel: 'Show readmore'
        },
        'teaser.show_download': {
            type: 'checkbox',
            optionlabel: 'Show download'
        },
        'teaser.show_demo': {
            type: 'checkbox',
            optionlabel: 'Show demo link'
        }
    },
    teaser: {
        'teaser.panel_style': {
            type: 'select',
            label: 'Panel style',
            options: options.panel_style,
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.content_align': {
            type: 'select',
            label: 'Content alignment',
            options: options.align.general,
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.tags_align': {
            type: 'select',
            label: 'Tags alignment',
            options: options.align.general,
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.button_align': {
            type: 'select',
            label: 'Button alignment',
            options: options.align.flex,
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.title_size': {
            type: 'select',
            label: 'Title size',
            options: options.heading_size,
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.subtitle_size': {
            type: 'select',
            label: 'Subtitle size',
            options: options.heading_size,
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.title_color': {
            type: 'select',
            label: 'Title color',
            options: options.text_color,
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.download': {
            label: 'Read more text',
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.download_style': {
            type: 'select',
            label: 'Download button style',
            options: options.button_style,
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.read_more': {
            label: 'Read more text',
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.read_more_style': {
            type: 'select',
            label: 'Read more button style',
            options: options.button_style,
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.demo': {
            label: 'Demo link text',
            attrs: {'class': 'uk-form-width-medium'}
        },
        'teaser.demo_more_style': {
            type: 'select',
            label: 'Demo link button style',
            options: options.button_style,
            attrs: {'class': 'uk-form-width-medium'}
        }
    },
    general: {
        'routing': {
            type: 'select',
            label: 'Routing type',
            options: {
                'Include category': 'category',
                'Direct item links': 'item'
            },
            attrs: {'class': 'uk-form-width-medium'}
        },
        'files_per_page': {
            type: 'number',
            label: 'Files per page',
            attrs: {'class': 'uk-form-width-small'}
        },
        'ordering': {
            type: 'select',
            label: 'Ordering',
            options: {
                'Title': 'title',
                'Date': 'date',
                'Tags (first tag of item)': 'tags'
            },
            attrs: {'class': 'uk-form-width-medium'}
        },
        'markdown_enabled': {
            type: 'checkbox',
            label: 'Markdown',
            optionlabel: 'Markdown enabled'
        },
        'date_format': {
            type: 'select',
            label: 'Date format',
            options: {
                'January 2015': 'F Y',
                'January 15 2015': 'F d Y',
                '15 January 2015': 'd F Y',
                'Jan 2015': 'M Y',
                '1 2015': 'm Y',
                '1-15-2015': 'm-d-Y',
                '15-1-2015': 'd-m-Y'
            },
            attrs: {'class': 'uk-form-width-medium'}
        }

    }


};