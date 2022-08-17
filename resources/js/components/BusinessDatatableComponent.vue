<template>

    <vue-bootstrap4-table :rows="businesses" :columns="columns" :config="config">

        <template slot="row-id" slot-scope="props">
            {{ props.row.vbt_id }}
        </template>
        <template slot="business-name" slot-scope="props">
            <a :href="`/admin/businesses/${props.row.slug}`" v-html="props.cell_value">
            </a>
        </template>
        <template slot="status-slot" slot-scope="props">
            <span class="kt-badge kt-badge--inline kt-badge--pill" :class="pill(props.row.status)">
                {{ props.row.status }}
            </span>
        </template>

        <template slot="paginataion-previous-button">
            Previous
        </template>
        <template slot="paginataion-next-button">
            Next
        </template>

    </vue-bootstrap4-table>

</template>

<script>
    import VueBootstrap4Table from 'vue-bootstrap4-table'

    export default {
        name: "BusinessDatatableComponent",
        components: {
            VueBootstrap4Table,
        },
        props: {
            'businesses': {
                required: true,
                type: Array
            },
            'types': {
                required: true,
                type: Array
            },
        },
        data() {
            return {
                columns: [
                    {
                        label: "#",
                        name: "id",
                        slot_name: "row-id",
                        sort: true,
                    },
                    {
                        label: "Business Name",
                        name: "name",
                        sort: true,
                        slot_name: "business-name",
                    },
                    {
                        label: "Business Type",
                        name: "type.name",
                        sort: true,
                        filter: {
                            closeDropdownOnSelection: true,
                            type: "select",
                            placeholder: "Business Type",
                            mode: "multi",
                            options: [
                                {
                                    "name": 'Cuisine',
                                    "value": 'Cuisine'
                                },
                                {
                                    "name": 'Fashion',
                                    "value": 'Fashion'
                                }
                            ]
                        },
                    },
                    {
                        label: "E-mail",
                        name: "email",
                        sort: true,
                    },
                    {
                        label: "Telephone",
                        name: "telephone",
                        sort: true,
                    },
                    {
                        label: "WhatsApp",
                        name: "whatsapp",
                        sort: true,
                    },
                    {
                        label: "Approval Status",
                        name: "status",
                        slot_name: "status-slot",
                        sort: true,
                        filter: {
                            closeDropdownOnSelection: true,
                            type: "select",
                            placeholder: "Approval Status",
                            mode: "multi",
                            options: [
                                {
                                    "name": "Approved",
                                    "value": "approved"
                                },
                                {
                                    "name": "Pending",
                                    "value": "pending"
                                },
                                {
                                    "name": "Declined",
                                    "value": "declined"
                                }, {
                                    "name": "Suspended",
                                    "value": "suspended"
                                }
                            ]
                        },
                    },
                ],
                config: {
                    card_mode: false,
                    highlight_row_hover: false,
                    checkbox_rows: false,
                    rows_selectable: false,
                    show_refresh_button: false,
                    per_page_options: [5, 10, 20, 30, 50],
                    global_search: {
                        placeholder: "Search here...",
                        visibility: true,
                        case_sensitive: false,
                        showClearButton: false,
                        searchOnPressEnter: false,
                        searchDebounceRate: 1000,
                    },
                },
            }
        },
        methods: {
            approve(row) {
            },
            decline(row) {
                console.log(row);
            },
            pill(status) {
                if (status === 'pending') {
                    return 'kt-badge--metal';
                }
                if (status === 'declined' || status === 'suspended') {
                    return 'kt-badge--danger';
                }
                if (status === 'approved') {
                    return 'kt-badge--success'
                }
            },
        },
    }
</script>

<style scoped>

</style>
