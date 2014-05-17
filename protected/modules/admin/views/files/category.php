
<?php $this->widget('application.modules.admin.widgets.NavTabWidget',array('index'=>'user_stat'))?>
	<script language="javascript" type="text/javascript" src="/statics/plugins/flot/jquery.flot.min.js"></script>
	<script language="javascript" type="text/javascript" src="/statics/plugins/flot/jquery.flot.selection.min.js"></script>
	<script language="javascript" type="text/javascript" src="/statics/plugins/flot/jquery.flot.time.min.js"></script>
	<script type="text/javascript">

	$(function() {

		var data = [{
			label: "关注用户量",
			data: <?php echo empty($tp)?'[]':$tp;?>
		}];

		var options = {
			series: {
				lines: {
					show: true
				},
				points: {
					show: true
				}
			},
//			hoverable: true,
			legend: {
				noColumns: 2
			},
			xaxis: {
				mode:"time",
				timezone:"browser",
				timeformat: "%m月%d日",
				tickDecimals: 0
			},
			yaxis: {
				min: 0
			},
			selection: {
				mode: "x"
			}
		};

		var placeholder = $("#placeholder");
/*
		placeholder.bind("plotselected", function (event, ranges) {

			$("#selection").text(ranges.xaxis.from.toFixed(1) + " to " + ranges.xaxis.to.toFixed(1));

			var zoom = $("#zoom").attr("checked");

			if (zoom) {
				plot = $.plot(placeholder, data, $.extend(true, {}, options, {
					xaxis: {
						min: ranges.xaxis.from,
						max: ranges.xaxis.to
					}
				}));
			}
		});

		placeholder.bind("plotunselected", function (event) {
			//	$("#selection").text("");
		});
*/
		var plot = $.plot(placeholder, data, options);
/*
		$("#clearSelection").click(function () {
			plot.clearSelection();
		});

		$("#setSelection").click(function () {
			plot.setSelection({
				xaxis: {
					from: 1994,
					to: 1995
				}
			});
		});
*/
		// Add the Flot version string to the footer

	//	$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
	});

	</script>

	<div id="content">
			<div id="placeholder" style="width:100%;height:500px;margin-bottom:50px;" ></div>
	</div>






