var TableAdvanced = function () {
    var initTable2 = function() {
        var oTable = $('#online_orders_table').dataTable( {           
           
			"aoColumnDefs": [
                { "aTargets": [ 0 ] }
            ],
            "aaSorting": [],
             "aLengthMenu": [
                [5, 10, 20, 40, -1],
                [5, 10, 20, 40, "Все"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10,
        });

        jQuery('#online_orders_table_wrapper .dataTables_filter input').addClass("form-control input-small input-inline"); // modify table search input
        jQuery('#online_orders_table_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown
        jQuery('#online_orders_table_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

        $('#online_orders_table_column_toggler input[type="checkbox"]').change(function(){
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
        });
    };
	
	
	var initTable3 = function() {
        var oTable3 = $('#catalog_products_table').dataTable( {           
           
			"aoColumnDefs": [
                { "aTargets": [ 0 ] }
            ],
            "aaSorting": [],
             "aLengthMenu": [
                [5, 10, 20, 40, -1],
                [5, 10, 20, 40, "Все"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 20,
        });

        jQuery('#catalog_products_table_wrapper .dataTables_filter input').addClass("form-control input-small input-inline"); // modify table search input
        jQuery('#catalog_products_table_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown
        jQuery('#catalog_products_table_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

        $('#catalog_products_table_column_toggler input[type="checkbox"]').change(function(){
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable3.fnSettings().aoColumns[iCol].bVisible;
            oTable3.fnSetColumnVis(iCol, (bVis ? false : true));
        });
    };
	
	
	

    return {

        //main function to initiate the module
        init: function () {
            
            if (!jQuery().dataTable) {
                return;
            }

            initTable2();
			initTable3();
        }

    };
}();