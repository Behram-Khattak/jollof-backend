<template>
    <b-form-invalid-feedback :class="{'d-block': force}">
        <strong> {{ message }} </strong>
    </b-form-invalid-feedback>
</template>

<script>
    export default {
        name: "InvalidFeedbackComponent",
        props: {
            message: {
                type: String,
                required: true
            },
            force: {
                type: Boolean,
                default: false
            }
        },
    }
</script>

<style scoped>

</style>
