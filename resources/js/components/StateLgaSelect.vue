<template>

    <div class="form-row">

        <b-form-group class="col-md-6" id="input-group-state" label="State" label-for="state">

            <b-form-select v-model="state"
                           name="state"
                           @change="updateLGA"
                           :state="stateError ? false : null"
                           required
            >
                <!-- This slot appears above the options from 'options' prop -->
                <template v-slot:first>
                    <b-form-select-option :value="null" disabled>
                        -- Please select an option --
                    </b-form-select-option>
                </template>

                <b-form-select-option v-for="(state, index) in stateProp" :key="index" :value="state.state">
                    {{ state.state }}
                </b-form-select-option>

            </b-form-select>

            <b-form-invalid-feedback :state="false">
                <strong>
                    {{ stateError }}
                </strong>
            </b-form-invalid-feedback>

        </b-form-group>

        <b-form-group class="col-md-6" id="input-group-lga" label="City" label-for="lga">

            <b-form-select v-model="lga"
                           name="city"
                           @change="updateAreas"
                           :state="lgaError ? false : null"
                           required
            >
                <!-- This slot appears above the options from 'options' prop -->
                <template v-slot:first>
                    <b-form-select-option :value="null" disabled>
                        -- Please select an option --
                    </b-form-select-option>
                </template>

                <b-form-select-option v-for="(lga, index) in lgas" :key="index" :value="lga">
                    {{ lga }}
                </b-form-select-option>

            </b-form-select>

            <b-form-invalid-feedback :state="false">
                <strong>
                    {{ lgaError }}
                </strong>
            </b-form-invalid-feedback>

        </b-form-group>

        <b-form-group v-if="showAreas" class="col-md-6" id="input-group-area" label="Area" label-for="area">

            <b-form-select v-model="area"
                           name="area"
                           :state="areaError ? false : null"
                           required
            >
                <!-- This slot appears above the options from 'options' prop -->
                <template v-slot:first>
                    <b-form-select-option :value="null" disabled>
                        -- Please select an option --
                    </b-form-select-option>
                </template>

                <b-form-select-option v-for="(area, index) in areas" :key="index" :value="area.area">
                    {{ area.area }}
                </b-form-select-option>

            </b-form-select>

            <b-form-invalid-feedback :state="false">
                <strong>
                    {{ areaError }}
                </strong>
            </b-form-invalid-feedback>

        </b-form-group>

    </div>

</template>

<script>
    export default {
        name: "StateLgaSelect",
        props: {
            'stateProp': {
                type: Array,
                required: true,
            },
            'oldState': {
                type: String,
                required: false,
            },
            'stateError': {
                type: String,
                required: false
            },
            'oldLga': {
                type: String,
                required: false,
            },
            'lgaError': {
                type: String,
                required: false,
            },
            'areaError': {
                type: String,
                required: false,
            },
            'oldArea': {
                type: String,
                required: false,
            }
        },
        data() {
            return {
                state: this.oldState ? this.oldState : null,
                lga: this.oldLga ? this.oldLga : null,
                area: this.oldArea ? this.oldArea : null,
                found: null,
                lgas: [],
                areas: [],
            }
        },
        methods: {
            updateLGA(event) {
                this.lga = this.found = this.area = null;
                this.areas = [];
                this.found = this.stateProp.find(element => element.state === event);
                this.lgas = this.found.lgas.constructor.name === 'Array' ? this.found.lgas : Object.keys(this.found.lgas);
            },
            updateAreas(event) {
                this.area = null;
                this.areas = [];
                this.areas = this.found.lgas[event]?.areas;
            }
        },
        computed: {
            showAreas() {
                return !(this.areas === undefined || this.areas.length <= 0);

            }

        },
        mounted() {
            this.oldLga ? this.lgas.push(this.oldLga) : [];
        }
    }
</script>

<style scoped>

</style>
