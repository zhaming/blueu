<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8" />
        <title>控制台</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <!-- basic styles -->
        <link rel="stylesheet" href="/statics/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/statics/css/font-awesome.min.css" />

        <!--[if IE 7]>
        <link rel="stylesheet" href="/statics/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->
        <link rel="stylesheet" href="/statics/css/jquery-ui-1.10.3.custom.min.css" />
        <link rel="stylesheet" href="/statics/css/chosen.css" />
        <link rel="stylesheet" href="/statics/css/datepicker.css" />
        <link rel="stylesheet" href="/statics/css/bootstrap-timepicker.css" />
        <link rel="stylesheet" href="/statics/css/daterangepicker.css" />
        <link rel="stylesheet" href="/statics/css/colorpicker.css" />

        <!-- fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

        <!-- ace styles -->
        <link rel="stylesheet" href="/statics/css/ace.min.css" />
        <link rel="stylesheet" href="/statics/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="/statics/css/ace-skins.min.css" />

        <!--[if lte IE 8]>
        <link rel="stylesheet" href="/statics/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="/statics/js/ace-extra.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="/statics/js/html5shiv.js"></script>
        <script src="/statics/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <?php $this->widget('application.modules.admin.widgets.NavbarWidget'); ?>
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed');
                } catch (e) {
                    console.log(e);
                }
            </script>
            <div class="main-container-inner">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>
                <?php $this->widget('application.modules.admin.widgets.SidebarWidget'); ?>
                <div class="main-content">
                    <?php $this->widget('application.modules.admin.widgets.BreadcrumbsWidget'); ?>
                    <div class="page-content">
                        <?php echo $content; ?>
                    </div>
                </div>
                <?php $this->widget('application.modules.admin.widgets.SettingWidget'); ?>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="icon-double-angle-up icon-only bigger-110"></i>
            </a>
        </div>

        <!-- basic scripts -->
        <!--[if !IE]> -->
        <script src="/statics/js/jquery-2.0.3.min.js"></script>
        <!-- <![endif]-->

        <!--[if IE]>
        <script src="/statics/js/jquery-1.10.2.min.js"></script>
        <![endif]-->

        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='/statics/js/jquery.mobile.custom.min.js'>" + "<" + "script>");
        </script>
        <script src="/statics/js/bootstrap.min.js"></script>
        <script src="/statics/js/typeahead-bs2.min.js"></script>

        <!-- page specific plugin scripts -->

        <!--[if lte IE 8]>
        <script src="/statics/js/excanvas.min.js"></script>
        <![endif]-->

        <script src="/statics/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="/statics/js/jquery.ui.touch-punch.min.js"></script>
        <script src="/statics/js/jquery.slimscroll.min.js"></script>
        <script src="/statics/js/jquery.easy-pie-chart.min.js"></script>
        <script src="/statics/js/jquery.sparkline.min.js"></script>
        <!--<script src="/statics/js/flot/jquery.flot.min.js"></script>-->
        <!--<script src="/statics/js/flot/jquery.flot.pie.min.js"></script>-->
        <!--script src="/statics/js/flot/jquery.flot.resize.min.js"></script>-->

        <!-- ace scripts -->

        <script src="/statics/js/ace-elements.min.js"></script>
        <script src="/statics/js/ace.min.js"></script>

        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            jQuery(function($) {
                $('.easy-pie-chart.percentage').each(function() {
                    var $box = $(this).closest('.infobox');
                    var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
                    var trackColor = barColor === 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
                    var size = parseInt($(this).data('size')) || 50;
                    $(this).easyPieChart({
                        barColor: barColor,
                        trackColor: trackColor,
                        scaleColor: false,
                        lineCap: 'butt',
                        lineWidth: parseInt(size / 10),
                        animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
                        size: size
                    });
                });

                $('.sparkline').each(function() {
                    var $box = $(this).closest('.infobox');
                    var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
                    $(this).sparkline('html', {tagValuesAttribute: 'data-values', type: 'bar', barColor: barColor, chartRangeMin: $(this).data('min') || 0});
                });

                var placeholder = $('#piechart-placeholder').css({'width': '90%', 'min-height': '150px'});
                var data = [
                    {label: "social networks", data: 38.7, color: "#68BC31"},
                    {label: "search engines", data: 24.5, color: "#2091CF"},
                    {label: "ad campaigns", data: 8.2, color: "#AF4E96"},
                    {label: "direct traffic", data: 18.6, color: "#DA5430"},
                    {label: "other", data: 10, color: "#FEE074"}
                ];
                



                var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
                var previousPoint = null;

                placeholder.on('plothover', function(event, pos, item) {
                    if (item) {
                        if (previousPoint !== item.seriesIndex) {
                            previousPoint = item.seriesIndex;
                            var tip = item.series['label'] + " : " + item.series['percent'] + '%';
                            $tooltip.show().children(0).text(tip);
                        }
                        $tooltip.css({top: pos.pageY + 10, left: pos.pageX + 10});
                    } else {
                        $tooltip.hide();
                        previousPoint = null;
                    }

                });






                var d1 = [];
                for (var i = 0; i < Math.PI * 2; i += 0.5) {
                    d1.push([i, Math.sin(i)]);
                }

                var d2 = [];
                for (var i = 0; i < Math.PI * 2; i += 0.5) {
                    d2.push([i, Math.cos(i)]);
                }

                var d3 = [];
                for (var i = 0; i < Math.PI * 2; i += 0.2) {
                    d3.push([i, Math.tan(i)]);
                }


                var sales_charts = $('#sales-charts').css({'width': '100%', 'height': '220px'});
               


                $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
                function tooltip_placement(context, source) {
                    var $source = $(source);
                    var $parent = $source.closest('.tab-content');
                    var off1 = $parent.offset();
                    var w1 = $parent.width();

                    var off2 = $source.offset();
                    var w2 = $source.width();

                    if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                        return 'right';
                    return 'left';
                }


                $('.dialogs,.comments').slimScroll({
                    height: '300px'
                });


                //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
                //so disable dragging when clicking on label
                var agent = navigator.userAgent.toLowerCase();
                if ("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
                    $('#tasks').on('touchstart', function(e) {
                        var li = $(e.target).closest('#tasks li');
                        if (li.length === 0)
                            return;
                        var label = li.find('label.inline').get(0);
                        if (label === e.target || $.contains(label, e.target))
                            e.stopImmediatePropagation();
                    });

                $('#tasks').sortable({
                    opacity: 0.8,
                    revert: true,
                    forceHelperSize: true,
                    placeholder: 'draggable-placeholder',
                    forcePlaceholderSize: true,
                    tolerance: 'pointer',
                    stop: function(event, ui) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
                        $(ui.item).css('z-index', 'auto');
                    }
                }
                );
                $('#tasks').disableSelection();
                $('#tasks input:checkbox').removeAttr('checked').on('click', function() {
                    if (this.checked)
                        $(this).closest('li').addClass('selected');
                    else
                        $(this).closest('li').removeClass('selected');
                });
                $('#id-input-file-upload-logo').ace_file_input({
        no_file:'请选择一张图片作为商户的Logo',
        btn_choose:'Choose',
        btn_change:'Change',
        droppable:false,
        onchange:null,
        thumbnail:true, //| true | large
        whitelist:'gif|png|jpg|jpeg'
        //blacklist:'exe|php'
        //onchange:''
        //
    });


            });
        </script>
    </body>
</html>

