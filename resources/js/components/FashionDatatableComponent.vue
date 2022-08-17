<template>

    <vue-bootstrap4-table :rows="products" :columns="columns" :config="config" :classes="classes">

        <template slot="row-id" slot-scope="props">
            {{ props.row.vbt_id }}
        </template>
        <template slot="featured_image-slot" slot-scope="props" style="width: 15% !important;">
            <img :src="props.row.featured_image" class="img-fluid img-thumbnail w-75" alt="featured image">
        </template>
        <template slot="product-slot" slot-scope="props">
            <a :href="`/merchant/fashion/${props.row.owner.slug}/products/${props.row.slug}`">
                {{ props.row.name | strLimit(50) | capitalize }}
            </a>
        </template>
        <template slot="price-slot" slot-scope="props">
            {{ props.row.price | currency }}
        </template>
        <template slot="sale_price-slot" slot-scope="props">
            {{ props.row.sales_price | currency }}
        </template>

        <template slot="promo-slot" slot-scope="props">
            <span class="kt-badge kt-badge--inline" :class="pill(props.row.runing_promo)">
                {{ props.row.running_promo ? 'active' : 'inactive' }}
            </span>
        </template>

        <template slot="status-slot" slot-scope="props">
            <span v-if="props.row.deleted_at !== null" class="kt-badge kt-badge--inline kt-badge--dark">
                deleted
            </span>
            <span v-else class="kt-badge kt-badge--inline" :class="pill(props.row.is_available)">
                {{ props.row.is_available ? 'available' : 'unavailable' }}
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
        name: "FashionDatatableComponent",
        components: {
            VueBootstrap4Table,
        },
        props: {
            'products': {
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
                        label: "Image",
                        name: "featured_image",
                        slot_name: "featured_image-slot",
                    },
                    {
                        label: "Name",
                        name: "name",
                        slot_name: "product-slot",
                        sort: true,
                        row_text_alignment: "text-left"
                    },
                    {
                        label: "Qty",
                        name: "quantity",
                        sort: true,
                    },
                    {
                        label: "Price",
                        name: "price",
                        slot_name: "price-slot",
                        sort: true,
                    },
                    {
                        label: "Discount Price",
                        name: "sales_price",
                        slot_name: "sale_price-slot",
                        sort: true,
                    },
                    {
                        label: "Discount Status",
                        name: "running_promo",
                        slot_name: "promo-slot",
                        sort: true,
                    },
                    {
                        label: "State",
                        name: "is_available",
                        slot_name: "status-slot",
                        sort: true,
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
                classes: {
                    row: {
                        "deleted": function (row) {
                            return row.deleted_at !== null
                        }
                    },
                    cell: {
                        "align-middle": true,
                        "w-15": function (row, column, cellValue) {
                            return column.name === "featured_image";
                        }
                    }
                }
            }
        },
        methods: {
            pill(state) {
                return state === true ? 'kt-badge--success' : 'kt-badge--danger';
            },
        },
        filters: {
            currency(value) {
                const formatter = new Intl.NumberFormat('en-ng', {
                    style: 'currency',
                    currency: 'NGN',
                    minimumFractionDigits: 2
                });

                return value ? formatter.format(value) : 'Unavailable';
            },
            capitalize(value) {
                return typeof value !== 'string' ? '' : value.charAt(0).toUpperCase() + value.slice(1);
            },
            'strLimit'(value, size) {
                if (!value) return '';
                value = value.toString();

                if (value.length <= size) {
                    return value;
                }
                return value.substr(0, size) + '...';
            }
        },
    }
</script>

<style>

    .w-15 {
        width: 15% !important;
    }

    .deleted {
        opacity: 0.3;
    }

</style>
