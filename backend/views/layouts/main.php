<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);

$isDashboard = false;
$isCustomer = false;
$isUser = false;
$isRole = false;
$isModules = false;
$isModulesAccess = false;
$isInventory = false;
$isCategory = false;
$isSupplier = false;
$isProduct = false;
$isInventory = false;

if(isset($_GET['r'])) {
    $getClass = $_GET['r'];
    $url = explode('/', $_GET['r']);
    $isDashboard = true;
    
    if( $url ) {
        $getClass = $url[0];
    }

    if( $getClass == 'customer' ) {
        $isCustomer = true;
    }

    if( $getClass == 'user' ) {
        $isUser = true;
    }

    if( $getClass == 'role' ) {
        $isRole = true;
    }

    if( $getClass == 'modules' ) {
        $isModules = true;
    }

    if( $getClass == 'modules-access' ) {
        $isModulesAccess = true;
    }

    if( $getClass == 'inventory' ) {
        $isInventory = true;
    }

    if( $getClass == 'category' ) {
        $isCategory = true;
    }

    if( $getClass == 'supplier' ) {
        $isSupplier = true;
    }

    if( $getClass == 'product' ) {
        $isProduct = true;
    }

    if( $getClass == 'inventory' ) {
        $isInventory = true;
    }
}

$userName = Yii::$app->user->identity->username;

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARH Group Pte Ltd.</title>

    <!-- CSS -->

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />    
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/animate.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/custom.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/maps/jquery-jvectormap-2.0.1.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/icheck/flat/green.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/editor/external/google-code-prettify/prettify.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/editor/index.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/floatexamples.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/select/select2.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/switchery/switchery.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/datatables/tools/css/dataTables.tableTools.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/dashboard-styles.css" />
</head>

<body class="nav-md">

<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
        
        <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">
                <a href="index.html" class="site_title"><i class="fa fa-car"></i> <span> ARH Group </span></a>
            </div>
            <div class="clearfix"></div>

            <!-- menu prile quick info -->
            <div class="profile">
                <div class="profile_pic">
                
                <img src="assets/bootstrap/photos/user.png" alt="..." class="img-circle profile_img">
               
                </div>
                
                <div class="profile_info">
                    <span>Welcome,</span>
                    <h2><?php echo $userName; ?></h2>
                </div>
            </div>
            <!-- /menu prile quick info -->
            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
            <h3 style="color: transparent;">-</h3>

            <ul class="nav side-menu">
                <li><span id="nav-menu-header" > <i class="fa fa-list"></i> MENU NAVIGATION - </span></li>
                <!-- <li><span style="color: #ffffff;"><hr/></span></li> -->
            	<li><a href="?" id="nav-dashboard" ><i class="fa fa-home"></i> Dashboard </a></li>
                <li><a href="r=product" id="nav-quotation" ><i class="fa fa-pencil"></i> Quotation</a></li>
                <li><a href="r=inventory" id="nav-invoice" ><i class="fa fa-paste"></i> Invoice</a></li>
                <li><a href="#" id="nav-services" ><i class="fa fa-battery-quarter"></i> Services <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="?r=category"  id="nav-category" >Category</a></li>
                        <li><a href="?r=product"  id="nav-product" >Service List</a></li>
                    </ul>
                </li>
                <li><a href="#" id="nav-parts" ><i class="fa fa-cogs"></i> Parts <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="?r=category"  id="nav-category" >Category</a></li>
                        <li><a href="?r=product"  id="nav-product" >Products</a></li>
                        <li><a href="?r=supplier" id="nav-supplier" >Supplier</a></li>
                        <li><a href="?r=inventory" id="nav-inventory" > Inventory</a></li>
                    </ul>
                </li>
                <li><a href="?r=customer" id="nav-customer"  ><i class="fa fa-users"></i> Customer </a></li>
                <li><a href="#" id="nav-user" ><i class="fa fa-user"></i>  User <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li ><a href="?r=user" id="nav-userList"  >User List</a></li>
                        <li><a href="?r=modules" id="nav-modules" >Module List</a></li>
                        <li><a href="?r=role" id="nav-role"  >User Role</a></li>
                        <li><a href="?r=user-permission" id="nav-userPermission" >User Permission</a></li>
                    </ul>
                </li>
                <li><a href="#" id="nav-reports" ><i class="fa fa-bar-chart"></i> Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="general_elements.html">General Elements</a>
                        </li>
                        <li><a href="media_gallery.html">Media Gallery</a>
                        </li>
                        <li><a href="typography.html">Typography</a>
                        </li>
                        <li><a href="icons.html">Icons</a>
                        </li>
                        <li><a href="glyphicons.html">Glyphicons</a>
                        </li>
                        <li><a href="widgets.html">Widgets</a>
                        </li>
                        <li><a href="invoice.html">Invoice</a>
                        </li>
                        <li><a href="inbox.html">Inbox</a>
                        </li>
                        <li><a href="calender.html">Calender</a>
                        </li>
                    </ul>
                </li>
                <li id="footer-container"><span style="color: transparent;" >-</span><br/><span id="footer-content"> &copy; <?php echo date('Y'); ?> | FIRSTCOM SOLUTIONS</span><br/><span style="color: transparent;" >-</span></li>
                <!-- <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="tables.html">Tables</a>
                        </li>
                        <li><a href="tables_dynamic.html">Table Dynamic</a>
                        </li>
                    </ul>
                </li>
                <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="chartjs.html">Chart JS</a>
                        </li>
                        <li><a href="chartjs2.html">Chart JS2</a>
                        </li>
                        <li><a href="morisjs.html">Moris JS</a>
                        </li>
                        <li><a href="echarts.html">ECharts </a>
                        </li>
                        <li><a href="other_charts.html">Other Charts </a>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
        <!-- <div class="menu_section">
            <h3>Live On</h3>
            <ul class="nav side-menu">
                <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="e_commerce.html">E-commerce</a>
                        </li>
                        <li><a href="projects.html">Projects</a>
                        </li>
                        <li><a href="project_detail.html">Project Detail</a>
                        </li>
                        <li><a href="contacts.html">Contacts</a>
                        </li>
                        <li><a href="profile.html">Profile</a>
                        </li>
                    </ul>
                </li>
                <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="page_404.html">404 Error</a>
                        </li>
                        <li><a href="page_500.html">500 Error</a>
                        </li>
                        <li><a href="plain_page.html">Plain Page</a>
                        </li>
                        <li><a href="login.html">Login Page</a>
                        </li>
                        <li><a href="pricing_tables.html">Pricing Tables</a>
                        </li>

                    </ul>
                </li>
                <li><a><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a>
                </li>
            </ul>
        </div> -->

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>
    </div>

<!-- top navigation -->
<div class="top_nav">

<div class="nav_menu">
    
    <nav class="" role="navigation">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" id="top-nav-right" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="assets/bootstrap/photos/user.png" alt=""> <?php echo $userName; ?>
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                    <li><a href="javascript:;">  Profile</a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="badge bg-red pull-right">50%</span>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">Help</a>
                    </li>
                    <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a><?php
                    echo Html::beginForm(['/site/logout'], 'post',['id' => 'logout-form']) . '<a href="#" onclick="document.getElementById(\'logout-form\').submit(); return false;" class="btn btn-default btn-flat">Sign out</a>'. Html::endForm();
                  ?>
                    </li>
                </ul>
            </li>

            <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                    <li>
                        <a>
                            <span class="image">
                        <img src="assets/bootstrap/photos/user.png" alt="Profile Image" />
                    </span>
                            <span>
                        <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                            </span>
                            <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                    </span>
                        </a>
                    </li>
                    <li>
                        <a>
                            <span class="image">
                        <img src="assets/bootstrap/photos/user.png" alt="Profile Image" />
                    </span>
                            <span>
                        <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                            </span>
                            <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                    </span>
                        </a>
                    </li>
                    <li>
                        <a>
                            <span class="image">
                        <img src="assets/bootstrap/photos/user.png" alt="Profile Image" />
                    </span>
                            <span>
                        <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                            </span>
                            <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                    </span>
                        </a>
                    </li>
                    <li>
                        <a>
                            <span class="image">
                        <img src="assets/bootstrap/photos/user.png" alt="Profile Image" />
                    </span>
                            <span>
                        <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                            </span>
                            <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                    </span>
                        </a>
                    </li>
                    <li>
                        <div class="text-center">
                            <a>
                                <strong><a href="inbox.html">See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>

</div>

</div>
<!-- /top navigation -->


<!-- page content -->
<div class="right_col" role="main">
<br/>

<div>
    <?= $content ?>
</div>
<br />

<!-- footer content -->
<!-- <footer>
    <div class="">
        <p class="pull-right"> &copy; <?php echo date('Y'); ?> Powered by <a>FirstCom Solutions</a>. |
            <span class="lead"> <i class="fa fa-car"></i> ARH Group Pte Ltd. </span>
        </p>
    </div>
    <div class="clearfix"></div>
</footer> -->
<!-- /footer content -->

</div>
<!-- /page content -->

    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

    <!-- Javascript -->
    <script src="assets/bootstrap/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/nprogress.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- gauge -->
    <script src="assets/bootstrap/js/gauge/gauge.min.js"></script>
    <script src="assets/bootstrap/js/gauge/gauge_demo.js"></script>
    <!-- chart js -->
    <script src="assets/bootstrap/js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="assets/bootstrap/js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="assets/bootstrap/js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="assets/bootstrap/js/icheck/icheck.min.js"></script>
     <!-- daterangepicker -->
    <script type="text/javascript" src="assets/bootstrap/js/moment.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/moment.min2.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/datepicker/daterangepicker.js"></script>

    <script src="assets/bootstrap/js/custom.js"></script>

    <!-- flot -->
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.orderBars.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.time.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/date.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.spline.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.stack.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/curvedLines.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.resize.js"></script>

    <!-- tags -->
    <script type="text/javascript" src="assets/bootstrap/js/tags/jquery.tagsinput.min.js"></script>
    <!-- switchery -->
    <script type="text/javascript" src="assets/bootstrap/js/switchery/switchery.min.js"></script>
    <!-- richtext editor -->
    <script type="text/javascript" src="assets/bootstrap/js/editor/bootstrap-wysiwyg.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/editor/external/jquery.hotkeys.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/editor/external/google-code-prettify/prettify.js"></script>
    <!-- select2 -->
    <script type="text/javascript" src="assets/bootstrap/js/select/select2.full.js"></script>
    <!-- form validation -->
    <script type="text/javascript" src="assets/bootstrap/js/parsley/parsley.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/form-validation.js"></script>
    <!-- textarea resize -->
    <script type="text/javascript" src="assets/bootstrap/js/textarea/autosize.min.js"></script>

    <script>
            autosize($('.resizable_textarea'));
    </script>

     <!-- Autocomplete -->
    <script type="text/javascript" src="assets/bootstrap/js/autocomplete/countries.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/autocomplete/jquery.autocomplete.js"></script>

    <!-- Datatables -->
    <script type="text/javascript" src="assets/bootstrap/js/datatables/js/jquery.dataTables.js"></script>
    <!-- <script type="text/javascript" src="assets/bootstrap/js/datatables/tools/js/dataTables.tableTools.js"></script> -->
    <script type="text/javascript" src="assets/bootstrap/js/table-design.js"></script>

    <script type="text/javascript" src="assets/bootstrap/js/confirmation.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/datepicker.js"></script>
    
    <script type="text/javascript">
        $
            $('#userRole').change(function(){
            $('#w0').submit();
            });

            $('#controllerName').change(function(){
                $('#w0').submit();
            });

            $('#select-all').click(function(event) {   
                $('.actionChkbox').each(function() {
                    this.checked = true;
                
                });
            });
    </script>

    <!-- select2 -->
    <script>
        $(document).ready(function () {
            $(".select2_single").select2({
                placeholder: "Select a state",
                allowClear: true
            });
            $(".select3_single").select2({
                placeholder: "Select a state",
                allowClear: true
            });
            $(".select2_group").select2({});
            $(".select2_multiple").select2({
                maximumSelectionLength: 4,
                placeholder: "With Max Selection limit 4",
                allowClear: true
            });
        });

        $(document).ready(function() {


          $(".add-more").click(function(){ 

              var html = $(".copy").html();

              $(".after-add-more").after(html);

          });


          $(".remove").click(function(){

              $(this).parents(".control-group").remove();

          });


        });

    </script>
    <!-- /select2 -->

    </body>   

</html>

<?php $this->endPage() ?>
