"use strict";

var KTDatatablesExtensionButtons = (function() {
    var initTable1 = function() {
        // begin first table
        var table = $("#export-table").DataTable({
            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

            buttons: ["print", "excel", "csv"]
        });
    };

    return {
        //main function to initiate the module
        init: function() {
            initTable1();
        }
    };
})();

jQuery(document).ready(function() {
    const rolesDataTable = $("#roles-table").KTDatatable({
        data: {
            saveState: {
                cookie: false,
                webstorage: false
            }
        },
        layout: {
            scroll: true,
            footer: false
        },
        sortable: true,
        search: {
            input: $("#generalSearch")
        },
        rows: {
            autoHide: false
        },
        translate: {
            records: {
                noRecords: "No roles found..."
            }
        },
        columns: [
            {
                field: "#",
                title: "#",
                sortable: "asc",
                width: 30,
                type: "number",
                selector: false,
                textAlign: "center"
            },
            {
                field: "Created",
                type: "date",
                format: "M j, Y"
            },
            {
                field: "Last Updated",
                type: "date",
                format: "M j, Y"
            },
            {
                field: "Actions",
                title: "Actions",
                sortable: false,
                width: 110
            },
            {
                field: "Status",
                title: "Status",
                width: 110
            }
        ]
    });

    $("#kt_form_status").on("change", function() {
        rolesDataTable.search(
            $(this)
                .val()
                .toLowerCase(),
            "Status"
        );
    });

    $("#kt_form_status, #kt_form_type").selectpicker();

    $("#settings-table").KTDatatable({
        data: {
            saveState: {
                cookie: false,
                webstorage: false
            }
        },
        layout: {
            scroll: true,
            footer: false
        },
        sortable: true,
        search: {
            input: $("#generalSearch")
        },
        rows: {
            autoHide: false
        },
        translate: {
            records: {
                noRecords: "No settings found..."
            }
        },
        columns: [
            {
                field: "#",
                title: "#",
                sortable: "asc",
                width: 30,
                type: "number",
                selector: false,
                textAlign: "center"
            },
            {
                field: "Name",
                width: 200
            },
            {
                field: "Value",
                width: 700
            },
            {
                field: "Actions",
                title: "Actions",
                sortable: false,
                width: 110
            }
        ]
    });

    KTDatatablesExtensionButtons.init();
});
