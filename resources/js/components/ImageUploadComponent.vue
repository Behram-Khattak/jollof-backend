<template>
    <div>
        <loading :active.sync="loader.isLoading"
                 :loader="loader.shape"
                 :color="loader.color"
                 :is-full-page="loader.fullPage"
        />
        <cropper
            :src="image"
            :stencil-props="{ aspectRatio: this.ratio }"
            ref="cropper"
            class="border border-dashed w-100"
            style="min-height: 400px; max-height: 400px"
        ></cropper>

        <p class="mt-3 text-center text-danger">{{ errorMessages[0] }}</p>

        <div class="d-flex justify-content-around m-3">

            <ValidationProvider rules="required|ext:jpg,png,jpeg|size:1024" ref="provider">

                <button type="button" class="btn btn-outline-secondary" @click="$refs.file.click()">

                    <input type="file"
                           ref="file"
                           v-show="false"
                           accept="image/png,image/jpeg,image/jpg"
                           @change="loadImage($event)">

                    {{ this.placeholder }}

                </button>

            </ValidationProvider>

            <button class="btn btn-primary" type="submit" @click="upload" :disabled="invalid">Upload</button>

        </div>

    </div>

</template>

<script>
    import {Cropper} from "vue-advanced-cropper";
    import {ValidationProvider, ValidationObserver, extend} from 'vee-validate';
    import {required, ext, size} from 'vee-validate/dist/rules';
    import Loading from 'vue-loading-overlay';

    extend('required', {
        ...required,
        message: 'This field is required.'
    });

    extend('ext', {
        ...ext,
        message: 'The selected file must be an image.'
    });

    extend('size', {
        ...size,
        message: "The selected image should not be greater than 1 megabyte."
    });

    export default {
        name: "ImageUploadComponent",
        components: {
            Cropper,
            ValidationProvider,
            ValidationObserver,
            Loading
        },
        props: {
            'route': {
                required: true,
                type: String
            },
            'ratio': {
                required: true,
                type: String
            },
            'placeholder': {
                required: true,
                type: String
            },
            'existingImage': {
              required: false,
              type: String
            }
        },
        data() {
            return {
                image: null,
                avatar: null,
                invalid: true,
                mimeType: null,
                errorMessages: '',
                loader: {
                    isLoading: false,
                    fullPage: false,
                    color: '#db261b',
                    shape: 'dots'
                },
            };
        },
        methods: {
            loadImage: async function (event) {
                const {errors, valid} = await this.$refs.provider.validate(event);

                if (errors) {
                    this.errorMessages = errors;
                }

                if (valid) {
                    // Reference to the DOM input element
                    let input = event.target;
                    // Ensure that you have a file before attempting to read it
                    if (input.files && input.files[0]) {
                        // create a new FileReader to read this image and convert to base64 format
                        let reader = new FileReader();
                        // Define a callback function to run, when FileReader finishes its job
                        reader.onload = (event) => {
                            // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
                            // Read image as base64 and set to imageData
                            this.image = event.target.result;
                        };
                        this.avatar = input.files[0];
                        reader.onloadend = (event) => {
                            if (!event || !event.target || !event.target.result) {
                                return;
                            }
                            const arr = (new Uint8Array(event.target.result)).subarray(0, 4);
                            let header = "";
                            for (let i = 0; i < arr.length; i++) {
                                header += arr[i].toString(16);
                            }
                            switch (header) {
                                case "89504e47":
                                    this.mimeType = "image/png";
                                    break;
                                case "47494638":
                                    this.mimeType = "image/gif";
                                    break;
                                case "ffd8ffe0":
                                case "ffd8ffe1":
                                case "ffd8ffe2":
                                case "ffd8ffe3":
                                case "ffd8ffe8":
                                    this.mimeType = "image/jpeg";
                                    break;
                                default:
                                    this.mimeType = this.avatar.type;
                                    break;
                            }
                        };
                        // Start the reader job - read file as a data url (base64 format)
                        reader.readAsDataURL(this.avatar);
                    }
                    this.invalid = false;
                }
            },
            upload(blob) {
                const {canvas} = this.$refs.cropper.getResult();
                this.loader.isLoading = true;
                canvas.toBlob(result => {
                    let formData = new FormData();
                    formData.append('avatar', result, this.avatar.name);
                    axios.post(`${this.route}`, formData)
                        .then(function (response) {
                            window.location.reload();
                        }.bind(this))
                        .catch(function (error) {
                            this.loader.isLoading = false;
                            this.errorMessages = error.response.data.error.message;
                        }.bind(this));
                }, this.mimeType)
            },
        },
    };
</script>
