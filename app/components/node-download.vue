<template>

    <div class="uk-form-horizontal">

        <partial name="settings"></partial>

    </div>

</template>

<script>

    module.exports = {

        inherit: true,

        section: {
            label: 'Settings',
            priority: 0,
            active: 'download'
        }

    };

    window.Site.components['download'] = module.exports;

</script>
