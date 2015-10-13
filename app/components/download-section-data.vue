<template>

    <div class="uk-form-horizontal uk-margin">

        <div class="uk-form-row">
            <span class="uk-form-label">{{ 'Date' | trans }}</span>
            <div class="uk-form-controls">
                <input-date datetime="{{@ file.date}}"></input-date>
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
    </div>

</template>

<script>

    module.exports = {

        section: {
            label: 'Data',
            priority: 10
        },

        inherit: true

    };

</script>
