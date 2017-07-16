<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/toastr/build/toastr.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/peity/jquery.peity.min.js"></script>
<script src="vendor/sparkline/index.js"></script>
<script src="vendor/nestable/jquery.nestable2.js"></script>
<script src="vendor/nestable/jquery.nestable.js"></script>
<script src="vendor/moment/moment.js"></script>
<script src="vendor/select2-3.5.2/select2.min.js"></script>
<script src="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>

<!-- App scripts -->
<script src="scripts/homer.js"></script>
<script src="scripts/charts.js"></script>

<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DataTables buttons scripts -->
<script src="vendor/pdfmake/build/pdfmake.min.js"></script>
<script src="vendor/pdfmake/build/vfs_fonts.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#txtGlobalSearch").on('keyup', function(e) {
			if (e.keyCode == 13) {
				// Do something
				do_global_search($("#txtGlobalSearch").val());
				//alert("ENTER!");
			}
		});

		toastr.options = {
			"debug" : false,
			"newestOnTop" : false,
			"positionClass" : "toast-top-center",
			"closeButton" : true,
			"toastClass" : "animated fadeInDown",
		};
	});

	function do_global_search(search_term) {
		$("#searchResultsDiv").html("");
		show_splash();
		var params = {
			search_term : search_term
		};
		$.ajax({
			type : "POST",
			url : "header_global_search.php",
			contentType : "application/json; charset=utf-8",
			data : JSON.stringify(params),
			success : function(result) {
				var res = jQuery.parseJSON(result);
				$.each(res, function(i, item_result) {
					/*$.each(item_result, function(i2, node) {
					 console.debug(node);
					 $("#searchResultsDiv").append(getNodeControl(node));
					 });*/
					$("#searchResultsDiv").append(getFoundControl(item_result));
				})

				console.debug(res);
				$('.dd').nestable();
				$("#searchResultsModal").modal("show");
				hide_splash();
			},
			context : document.body
		});
	}

	function show_splash() {
		$(".splash").css("display", "");
	}

	function hide_splash() {
		$(".splash").css("display", "none");
	}

	var current_list_id = 0;

	function getFoundControl(foundresult) {
		var id = current_list_id + 1;
		current_list_id = current_list_id + 1;
		var foundControl = $("<div/>");
		var grouping_div = $("<div/>", {
			class : "dd",
			id : "list_" + id
		});
		var ol = $("<ol/>", {
			class : "dd-list"
		});

		$.each(foundresult, function(i, item) {

			var description = item.Detail;
			var searchTerm = $("#txtGlobalSearch").val();
			pattern = new RegExp(searchTerm, 'gi');
			
			description = description.replace(pattern, '<span style="color:green;font-weight:bold;">'+searchTerm+'</span>');
			
			var node_type = null;
			var node = $("<li/>", {
				class : "dd-item",
				"data-id" : item.CTable + "_" + item.CID,
				"RID" : item.RID
			});
			var n_div = $("<div/>", {
				class : "dd-handle"
			}).html(description);
			var n_span = $("<span/>", {
				class : "label h-bg-navy-blue tree_label"
			});
			var n_icon = $("<i/>");

			if (item.Type == "Grouping") {
				$(n_icon).addClass("fa fa-building");
				node_type = $("<span/>", {
					class : "pull-right"
				}).text("DEPT/CC");
			} else if (item.Type == "User") {
				$(n_icon).addClass("fa fa-user");
				node_type = $("<span/>", {
					class : "pull-right"
				}).text("USER");
			} else if (item.Type == "Extension") {
				$(n_icon).addClass("fa fa-phone");
				node_type = $("<span/>", {
					class : "pull-right"
				}).text("DEVICE");
			}

			var n_ol = $("<ol/>", {
				class : "dd-list",
				id : "node_" + item.CTable + "_" + item.CID
			});
			n_span.append(n_icon);
			n_div.prepend(n_span);
			n_div.prepend(node_type);
			node.append(n_div);
			node.append(n_ol);

			if ($("ol", $(ol)).last().length == 0) {
				$(ol).append(node);
			} else {
				$("ol", $(ol)).last().append(node);
			}

		});

		$(grouping_div).append(ol);
		$(foundControl).append(grouping_div);
		/*$(grouping_div).nestable({
		 group : 1
		 }).on('change', function(e) {

		 });*/

		$(".dd-list", $(foundControl)).each(function(i, item) {
			if ($(item).children().length == 0) {
				$(item).remove();
			}
		});

		return foundControl;
	}

	function getNodeControl(node) {
		if (node.Type == "Grouping") {
			console.debug("GROUPING");
			return getGroupControl(node);
		} else if (node.Type == "User") {
			return getUserControl(node);
		} else if (node.Type == "Extension") {
			return getExtensionControl(node);
		}
	}

	function getGroupControl(node) {
		var div = $("<div/>", {
			class : "dd-handle"
		});
		//<span class="label h-bg-navy-blue tree_label"><i class="fa fa-building"></i></span>
		var span = $("<span/>", {
			class : "label h-bg-navy-blue tree_label"
		});
		var i = $("<i/>", {
			class : "fa fa-building"
		});
		span.append(i);
		div.append(span);

		var type = $("<span/>", {
			class : "pull-right"
		}).text("GROUP");
		div.append(type);

		div.append(node.Detail);
		$(div).css("float", "left");
		return (div);
	}

	function getUserControl(node) {
		var div = $("<div/>", {
			class : "dd-handle"
		});
		//<span class="label h-bg-navy-blue tree_label"><i class="fa fa-building"></i></span>
		var span = $("<span/>", {
			class : "label h-bg-navy-blue tree_label"
		});
		var i = $("<i/>", {
			class : "fa fa-user"
		});
		span.append(i);
		div.append(span);

		var type = $("<span/>", {
			class : "pull-right"
		}).text("USER");
		div.append(type);

		div.append(node.Detail);
		$(div).css("float", "left");
		return (div);
	}

	function getExtensionControl(node) {
		var div = $("<div/>", {
			class : "dd-handle"
		});
		//<span class="label h-bg-navy-blue tree_label"><i class="fa fa-building"></i></span>
		var span = $("<span/>", {
			class : "label h-bg-navy-blue tree_label"
		});
		var i = $("<i/>", {
			class : "fa fa-phone"
		});
		span.append(i);
		div.append(span);

		var type = $("<span/>", {
			class : "pull-right"
		}).text("DEVICE");
		div.append(type);

		div.append(node.Detail);
		$(div).css("float", "left");
		return (div);
	}
</script>

