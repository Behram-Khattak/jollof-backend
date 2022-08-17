<template>

    <div>

        <b-table primary-key="id"
                 :items="items"
                 :current-page="currentPage"
                 :per-page="perPage"
                 :fields="fields"
                 responsive="true"
                 head-variant="light"
                 outlined
                 hover>

            <template v-slot:cell(actions)="row">

                <b-button
                    class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-info btn-edit"
                    title="Edit"
                    @click="info(row.item, row.index, $event.target)"
                >
                    <i class="fa fa-pen"></i>
                </b-button>
                <button
                    class="btn btn-sm btn-icon btn-icon-md btn-outline-hover-danger js-delete-trigger"
                    title="Delete"
                >
                    <i class="fa fa-trash"></i>
                </button>

            </template>

        </b-table>


        <div class="row m-0 mr-5 my-5 justify-content-end">

            <b-form-group
                label="Display"
                label-for="perPageSelect"
                label-class="mr-3"
                class="row align-items-baseline m-0"
            >
                <b-form-select
                    v-model="perPage"
                    id="perPageSelect"
                    size="sm"
                    :options="pageOptions"
                ></b-form-select>
            </b-form-group>

            <b-pagination
                v-model="currentPage"
                :total-rows="totalRows"
                :per-page="perPage"
                align="right"
                first-text="First"
                prev-text="Prev"
                next-text="Next"
                last-text="Last"
                class="ml-3"
            ></b-pagination>

        </div>

    </div>

</template>

<script>
    export default {
        name: "SettingsDatatableComponent",
        props: {
            'initialItems': {
                type: Array,
                required: true
            },
        },
        data() {
            return {
                fields: [
                    {
                        key: 'identity',
                        isRowHeader: true,
                        sortable: true,
                        label: '#',
                        class: 'text-center',
                        thStyle: 'width:100px',
                        thClass: 'text-bold'
                    },
                    {
                        key: 'name',
                        sortable: true,
                        thClass: 'text-body text-uppercase',
                        thStyle: 'width:200px',

                    },
                    {
                        key: 'value',
                        thClass: 'text-center text-body text-uppercase',
                        sortable: true,
                    },
                    {
                        key: 'actions',
                        label: 'Actions',
                        thClass: 'text-body text-uppercase',
                        class: 'text-center',
                        thStyle: 'width:150px'
                    }
                ],
                totalRows: this.initialItems.length,
                currentPage: 1,
                perPage: 10,
                pageOptions: [5, 10, 25, 50],
                startIndex: 0,
            }
        },
        methods: {
            info(item, index, button) {
                console.log(item.id)
                // this.infoModal.title = `Row index: ${index}`
                // this.infoModal.content = JSON.stringify(item, null, 2)
                // this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
        },
        computed: {
            items() {
                return this.initialItems.map((item, index) => (Object.assign(item, {identity: index + 1})));
            }
        }
    }
</script>

<style scoped>

</style>
