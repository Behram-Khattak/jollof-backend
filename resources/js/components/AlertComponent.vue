<template>

    <b-alert class="alert-icon text-center" :variant="variant" :dismissible="dismissible" show>
        <i v-if="icon" class="fa mr-2" v-bind:class="[iconType]" aria-hidden="true"></i>
        {{ body }}
    </b-alert>

</template>

<script>
    export default {
        name: "AlertComponent",
        props: {
            'variant': {
                type: String,
                required: true
            },
            'title': {
                type: String,
                required: false
            },
            'body': {
                type: String,
                required: true
            },
            'dismissible': {
                type: Boolean,
                default: false
            },
            'icon': {
                type: Boolean,
                default: true
            },
        },
        computed: {
            iconType() {
                switch (this.variant) {
                    case 'success':
                        return 'fa-check-circle';
                    case 'info':
                        return 'fa-info-circle';
                    case 'warning':
                        return 'fa-exclamation-circle';
                    case 'help':
                        return 'question-circle';
                    case 'danger':
                        return 'fa-exclamation-triangle'
                }
                return 'fa-info-circle'
            },
        }
    }
</script>
