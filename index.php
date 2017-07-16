<?php
error_reporting(0);
include("class_jumo_loan.php");

        // Pull the info fro the CSV and map the rows
        $loan_array = array_map('str_getcsv', file('Loans.csv'));
        
        // convert from simple array to associative array with headings as keys
        $header = array_shift($loan_array);
        array_walk($loan_array, '_combine_array', $header);
        
        // Callback function 
        function _combine_array(&$row, $key, $header) {
            $row = array_combine($header, $row);
        }
		
// Initialise the Object		
$loan = new output_results();

// Get Cost Totals for all months
$loan->summarise_totals($loan_array);

// Get Network Info
$loan->group_network($loan_array);
$networks = array();
$networks = array_values($loan->output_network);

// Get MSISDN Info
$loan->msisdn_info($loan_array);
$msisdns = array();
$msisdns = array_values($loan->output_msisdn);

// Get Product Info
$loan->group_product($loan_array);
$products = array();
$products = array_values($loan->output_product);
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>JUMO | Expense Management System</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="styles/style.css">

</head>
<body class="fixed-navbar sidebar-scroll">

<!-- Skin option / for demo purpose only -->
<style>
    .skin-option { position: fixed; text-align: center; right: -1px; padding: 10px; top: 80px; width: 150px; height: 133px; text-transform: uppercase; background-color: #ffffff; box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05), 0 1px 4px rgba(0, 0, 0, .1); border-radius: 4px 0 0 4px; z-index: 100; }
</style>
<script>
    setInterval(function(){ $('#demo-star').toggleClass('text-success'); }, 300)
</script>

<!-- Main Wrapper -->
    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            <a class="closebox"><i class="fa fa-times"></i></a>
                        </div>
                        Recently Added Reports</div>
                    <div class="panel-body list">
                        <div class="table-responsive project-list">
                            <table class="table table-striped">
                                <thead>
                                <tr>

                                    <th colspan="2">REPORTS</th>
                                    <th>Click Below To Generate Reports</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="checkbox" class="i-checks" checked></td>
                                    <td><a href="group_by_network.php" target="_blank">TOTALS PER NETWORK</a><br/>
                                        <small><i class="fa fa-clock-o"></i><a href="group_by_network.php" target="_blank"> Grouped By Network</a></small>
                                    </td>
                                    <td>
                                        <a href="group_by_network.php" target="_blank">VIEW REPORT</a>
                                    </td>
                                  </tr>
                                <tr>
                                    <td><input type="checkbox" class="i-checks" checked></td>
                                    <td><a href="group_by_product.php" target="_blank">TOTALS PER PRODUCT</a><br/>
                                        <small><i class="fa fa-clock-o"></i> <a href="group_by_product.php" target="_blank">Grouped By Product</a></small>
                                    </td>
                                    <td>
                                        <a href="group_by_product.php" target="_blank">VIEW REPORT</a>
                                    </td>
                                  </tr>
                                <tr>
                                    <td><input type="checkbox" class="i-checks" checked></td>
                                    <td><a href="group_by_date.php" target="_blank">TOTALS PER DATE</a><br/>
                                        <small><i class="fa fa-clock-o"></i> <a href="group_by_date.php" target="_blank">Grouped By Date</a></small>
                                    </td>
                                    <td>
                                        <a href="group_by_date.php" target="_blank">VIEW REPORT</a>
                                    </td>
                                  </tr>
                                <tr>
                                    <td><input type="checkbox" class="i-checks" checked></td>
                                    <td><a href="group_by_all.php" target="_blank">TOTALS PER NETWORK, PRODUCT &amp; DATE</a><br/>
                                        <small><i class="fa fa-clock-o"></i> <a href="group_by_all.php" target="_blank">Grouped By Network, Product and Date</a></small>
                                    </td>
                                    <td>
                                        <a href="group_by_all.php" target="_blank">VIEW REPORT</a>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            <a class="closebox"><i class="fa fa-times"></i></a>
                        </div>
                        Total Cost Summary</div>
                    <div class="panel-body text-center h-200">
                        <i class="pe-7s-graph1 fa-4x"></i>

                        <h1 class="m-xs"><?php echo "R".$loan->output_sumtotal; ?></h1>

                        <h3 class="font-extra-bold no-margins text-success">
                            Total Rand Cost
                        </h3>
                        <small>All Months Total Summary Cost</small>
                    </div>
                    <div class="panel-footer">
                        Total Cost Summary
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="hpanel stats">
                    <div class="panel-body h-200">
                        <div class="stats-title pull-left">
                            <h4>NETWORK ACTIVITY</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="pe-7s-battery fa-4x"></i>
                        </div>
                        <div class="clearfix"></div>
                        <div class="m-t-xs">
						<?php for ($n=0; $n<count($networks); $n++) { ?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <small class="stat-label"><?php echo $networks[$n]['Network']; ?></small>
                                    <h4><?php echo "Count: ".$networks[$n]['Count']; ?><i class="fa fa-level-up text-success"></i></h4>
                                </div>
                                <div class="col-xs-6">
                                    <small class="stat-label">Total Cost</small>
                                    <h4><?php echo $networks[$n]['Amount']; ?><i class="fa fa-level-up text-success"></i></h4>
                                </div>
                            </div>
                         <?php } ?>   
                        </div>
                    </div>
                    <div class="panel-footer">
                        Network Summary
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="hpanel stats">
                    <div class="panel-body h-200">
                        <div class="stats-title pull-left">
                            <h4>MSISDN Activity</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="pe-7s-share fa-4x"></i>
                        </div>
                        <div class="m-t-xl">
                    <span class="font-bold no-margins">
                        Available MSISDN Accounts</span>
                            <div class="progress m-t-xs full progress-small">
                                <div style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="100" role="progressbar">
                                    <span class="sr-only">35% Complete (success)</span>
                                </div>
                          </div>
                          <?php for ($x=0; $x<count($msisdns); $x++) { ?>
                            <div class="row">
                                <div class="col-xs-6">
                                  <h12><?php echo $msisdns[$x]['MSISDN']; ?></h12>
                                </div>

                                <div class="col-xs-6">
                                    <small class="stats-label">Cost</small>
                                    <h12><?php echo $msisdns[$x]['Amount'];  ?></h12>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="panel-footer">
                        MSISDN Summary
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="hpanel stats">
                    <div class="panel-body h-200 list">
                        <div class="stats-title pull-left">
                            <h4>Product Activity</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="pe-7s-science fa-4x"></i>
                        </div>
                        <div class="m-t-xl">
                            <span class="font-bold no-margins">
                                Available Products</span>
                            <br/>
                            <small>
                                Product Cost Totals</small>
                        </div>
                            <div class="row m-t-sm">
                            <?php for ($p=0;$p<count($products);$p++) { ?>
                                <div class="col-lg-6">
                                    <h12 class="no-margins font-extra-bold text-success"><?php echo $products[$p]['Product']; ?></h12>
                                    <div class="font-bold">Count: <?php echo $products[$p]['Count']; ?> <i class="fa fa-level-up text-success"></i></div>
                                </div>
                                <div class="col-lg-6">
                                    <h12 class="no-margins font-extra-bold text-success"><?php echo $products[$p]['Amount']; ?></h12>
                                    <div class="font-bold"><?php echo "Cost" ?> <i class="fa fa-level-up text-success"></i></div></div>
                            <?php } ?>
                            </div>
                    </div>
                    <div class="panel-footer">
                        Product Summary</div>
                </div>
            </div>            
            <div class="col-lg-3">
                <div class="hpanel">
                    <div class="panel-body text-center h-200">
                        <a href="bi_analytics.php" target="_blank"><i class="pe-7s-graph2 fa-4x"></i></a>
                        <h1 class="m-xs"><a href="bi_analytics.php" target="_blank">Analytics</a></h1>
                        <small><a href="bi_analytics.php" target="_blank">View integrated Business Intelligence and Insights on the Netwrok, Product, MSISDN accounts.</a></small>
                    </div>
                    <div class="panel-footer">
                        Business Insights
                    </div>
                </div>
            </div>
        </div>       

    </div>

    <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">

        <div class="p-m">
            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
            </button>
            <div>
                <span class="font-bold no-margins"> Analytics </span>
                <br>
                <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            </div>
            <div class="row m-t-sm m-b-sm">
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">300,102</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">280,200</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
            </div>
            <div class="progress m-t-xs full progress-small">
                <div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar"
                     class=" progress-bar progress-bar-success">
                    <span class="sr-only">35% Complete (success)</span>
                </div>
            </div>
        </div>
        <div class="p-m bg-light border-bottom border-top">
            <span class="font-bold no-margins"> Social talks </span>
            <br>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            <div class="m-t-md">
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a1.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">John Novak</span>
                            <small class="text-muted">21.03.2015</small>
                            <div class="social-content small">
                                Injected humour, or randomised words which don't look even slightly believable.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a3.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Mark Smith</span>
                            <small class="text-muted">14.04.2015</small>
                            <div class="social-content">
                                Many desktop publishing packages and web page editors.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a4.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Marica Morgan</span>
                            <small class="text-muted">21.03.2015</small>

                            <div class="social-content">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-m">
            <span class="font-bold no-margins"> Sales in last week </span>
            <div class="m-t-xs">
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$170,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$580,90 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$620,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$140,70 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
            </div>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.
                Many desktop publishing packages and web page editors.
            </small>
        </div>

    </div>

<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/jquery-flot/jquery.flot.js"></script>
<script src="vendor/jquery-flot/jquery.flot.resize.js"></script>
<script src="vendor/jquery-flot/jquery.flot.pie.js"></script>
<script src="vendor/flot.curvedlines/curvedLines.js"></script>
<script src="vendor/jquery.flot.spline/index.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/peity/jquery.peity.min.js"></script>
<script src="vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="scripts/homer.js"></script>
<script src="scripts/charts.js"></script>

<script>

    $(function () {

        /**
         * Flot charts data and options
         */
        var data1 = [ [0, 55], [1, 48], [2, 40], [3, 36], [4, 40], [5, 60], [6, 50], [7, 51] ];
        var data2 = [ [0, 56], [1, 49], [2, 41], [3, 38], [4, 46], [5, 67], [6, 57], [7, 59] ];

        var chartUsersOptions = {
            series: {
                splines: {
                    show: true,
                    tension: 0.4,
                    lineWidth: 1,
                    fill: 0.4
                },
            },
            grid: {
                tickColor: "#f0f0f0",
                borderWidth: 1,
                borderColor: 'f0f0f0',
                color: '#6a6c6f'
            },
            colors: [ "#62cb31", "#efefef"],
        };

        $.plot($("#flot-line-chart"), [data1, data2], chartUsersOptions);

        /**
         * Flot charts 2 data and options
         */
        var chartIncomeData = [
            {
                label: "line",
                data: [ [1, 20], [2, 26], [3, 16], [4, 36], [5, 32], [6, 51] ]
            }
        ];

        var chartIncomeOptions = {
            series: {
                lines: {
                    show: true,
                    lineWidth: 0,
                    fill: true,
                    fillColor: "#64cc34"

                }
            },
            colors: ["#62cb31"],
            grid: {
                show: false
            },
            legend: {
                show: false
            }
        };

        $.plot($("#flot-income-chart"), chartIncomeData, chartIncomeOptions);



    });

</script>

</body>
</html>