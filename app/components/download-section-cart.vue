<template>

    <div class="uk-form-horizontal">

        <div class="uk-form-row">
            <span class="uk-form-label">{{ 'Shopping cart' | trans }}</span>

            <div class="uk-form-controls uk-form-controls-text">
                <p v-show="file.id" class="uk-form-controls-condensed">
                    <label><input type="checkbox" v-model="file.data.cart_active"> {{ 'Enable cart' | trans }}</label>
                </p>
                <p v-show="!file.id" class="uk-form-help-block uk-text-warning">
                    {{ 'Save item to enable cart' | trans }}
                </p>
            </div>
        </div>

        <div v-show="file.id && product.active" class="uk-margin">
            <div class="uk-form-row">
                <label for="form-cart-price" class="uk-form-label">{{ 'Price' | trans }}</label>

                <div class="uk-form-controls">
                    <div class="uk-form-icon">
                        <i class="{{ currencyIcon }}"></i>
                        <input type="number" step="0.01" v-model="product.price"
                               id="form-cart-price" class="uk-form-width-medium uk-text-right" number>
                    </div>
                </div>
            </div>

            <div class="uk-form-row">
                <label class="uk-form-label">{{ 'Price config' | trans }}</label>

                <div class="uk-form-controls uk-form-controls-text">
                    <select name="file_cart_currency" class="uk-form-width-small"
                            v-model="product.currency">
                        <option value="EUR">{{ 'Euro' | trans }}</option>
                        <option value="USD">{{ 'Dollar' | trans }}</option>
                    </select>
                    <select name="file_cart_vat" class="uk-margin-small-left uk-form-width-small"
                            v-model="product.vat">
                        <option v-for="option in config.vatclasses" value="$key">{{ vatclass.name }}</option>
                    </select>
                </div>
            </div>

            <div class="uk-form-row">
                <label for="file_cart_validity_period" class="uk-form-label">{{ 'Validity period' | trans }}</label>

                <div class="uk-form-controls uk-form-controls-text">
                    <select id="file_cart_validity_period" name="file_cart_validity_period" class="uk-form-width-small"
                            v-model="product.data.validity_period">
                        <option value="">{{ 'Infinite' | trans }}</option>
                        <option v-for="period in periods" value="{{ $key }}">{{ period | trans }}</option>
                    </select>
                </div>
            </div>

            <div class="uk-form-row">
                <label for="form-cart-product_identifier" class="uk-form-label">{{ 'Package name' | trans }}</label>

                <div class="uk-form-controls">
                    <input type="text" v-model="product.data.product_identifier"
                          id="form-cart-product_identifier" class="uk-form-width-medium">
                </div>
            </div>


        </div>
    </div>

</template>

<script>

    module.exports = {

        section: {
            label: 'Cart',
            priority: 99

        },

        props: ['file', 'config', 'form'],

        data: function () {
            return _.merge({
                product: {
                    active: this.file.data.cart_active,
                    id: 0,
                    item_model: 'Bixie\\Download\\Model\\File',
                    item_id: this.file.id,
                    price: 0,
                    currency: window.$cart.config.currency,
                    vat: window.$cart.config.vat,
                    data: {
                        validity_period: '',
                        package_name: ''
                    }
                },
                config: {}
            }, window.$cart)
        },

        events: {
            'save': function (data) {
                if (this.file.data.cart_active && this.product.item_id) {
                    data.product = this.product;
                }
            },
            'saved': function (data) {
                if (data.file.data.cart_active && data.file.product) {
                    this.$set('product', data.file.product);
                }
                this.$set('product.item_id', data.file.id);
            }
        },

        computed: {
            currencyIcon: function () {
                var icons = {
                    'EUR': 'uk-icon-euro',
                    'USD': 'uk-icon-dollar'
                };
                return icons[(this.product.currency || this.config.currency)];
            }
        },

        watch: {
            'file.data.cart_active': function (value) {
                this.product.active = value;
            }
        }

    };

    window.BixieDownloads.components['download-section-cart'] = module.exports;

</script>
