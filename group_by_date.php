<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<?php
include("head.php");
?>
<body class="fixed-navbar fixed-sidebar">

<?
// include("splash_div.php");
?>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Header -->
<?php
include("header.php");
?>
<!-- Main Wrapper -->

    <div class="normalheader transition animated fadeIn">
        <div class="hpanel">
            <div class="panel-body">
                <a class="small-header-action" href="">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>

                <div id="hbreadcrumb" class="pull-right m-t-lg">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="index.php">Quick Reports</a></li>
                        <li>
                            <span>Filters</span>
                        </li>
                        <li class="active">
                            <span>Results</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                   Totals Per Date</h2>
                <small>Report - displays totals by date</small>
            </div>
        </div>
    </div>


<div class="content animate-panel">



    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        <a class="closebox"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="gbd" class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Count</th>
                            <th>Total Currency</th>                                                       
                        </tr>
                        </thead>
                    </table>

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
        </div>

    </div>
</div>
<?php
include("javascript.php");
?>
</body>
</html>