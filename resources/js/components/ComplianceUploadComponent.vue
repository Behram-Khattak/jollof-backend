<template>

    <div class="d-flex mt-2 justify-content-center">
        <!-- uppy uploader container start-->

        <div id="uppy"></div>

        <!-- uppy uploader container end -->
    </div>

</template>

<script>

    import Uppy from "@uppy/core";
    import Dashboard from "@uppy/dashboard";
    import XHRUpload from "@uppy/xhr-upload";


    export default {
        name: "ComplianceUploadComponent",
        components: {
            Uppy,
            Dashboard,
            XHRUpload,
        },
        props: {
            'route': {
                required: true,
                type: String
            },
        },
        data() {
            return {
                uppy: {},
                uppyFiles: null,
            }
        },
        methods: {
            formatBytes(bytes, decimals = 2) {
                if (bytes === 0) {
                    return '0 Bytes';
                }

                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            },
        },
        mounted() {
            let uppy;
            this.uppy = uppy = new Uppy({
                debug: true,
                allowMultipleUploads: false,
                autoProceed: false,
                restrictions: {
                    maxFileSize: 1024 * 1024,
                    maxNumberOfFiles: 5,
                    allowedFileTypes: ['.jpg', '.jpeg', '.png', '.pdf', '.doc', '.docx']
                },
            })
                .use(Dashboard, {
                    inline: true,
                    height: 400,
                    width: 400,
                    target: '#uppy',
                    proudlyDisplayPoweredByUppy: false,
                    hideUploadButton: false,
                    note: `Only images and documents are supported. Maximum of 1 file; up to ${this.formatBytes(1024 * 1024)}`,
                })
                .use(XHRUpload, {
                    endpoint: `${this.route}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                    },
                    formData: true,
                    fieldName: 'kyc'
                })
                .on('upload-success', (file, response) => {
                    window.location.reload();
                })
                .on('file-added', () => {
                    this.uppyFiles = uppy.getFiles();
                })
                .on('file-removed', () => {
                    this.uppyFiles = uppy.getFiles();
                });
        },
    }
</script>

<style scoped lang="scss">

    @import "~@uppy/core/dist/style.css";
    @import "~@uppy/dashboard/dist/style.css";

</style>
