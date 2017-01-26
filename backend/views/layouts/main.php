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

use common\models\UserPermission;

AppAsset::register($this);

$isDashboard = false;
$isBranch = false;
$isRole = false;
$isModules = false;
$isUserPermission = false;
$isUser = false;
$isCustomer = false;
$isServiceCategory = false;
$isService = false;
$isCategory = false;
$isProduct = false;
$isSupplier = false;
$isInventory = false;
$isStaff = false;
$isPayroll = false;
$isQuotation = false;
$isInvoice = false;
$isBestSelling = false;
$isMonthlySales = false;
$isMonthlyStock = false;
$isGst = false;
$isProductLevel = false;
$isPaymentType = false;
$isTermsConditions = false;

$roleId = Yii::$app->user->identity->role_id;
$getUserPermission = UserPermission::find()->where(['role_id' => $roleId])->groupBy('controller')->all();

foreach ($getUserPermission as $key => $value) {
   
    switch($value['controller']) {
        case 'Site':
            $isDashboard = true;
        break;

        case 'Branch':
            $isBranch = true;
        break;

        case 'Role':
            $isRole = true;
        break;

        case 'Modules':
            $isModules = true;
        break;

        case 'UserPermission':
            $isUserPermission = true;
        break;

        case 'User':
            $isUser = true;
        break;

        case 'Customer':
            $isCustomer = true;
        break;

        case 'ServiceCategory':
            $isServiceCategory = true;
        break;

        case 'Service':
            $isService = true;
        break;

        case 'Category':
            $isCategory = true;
        break;

        case 'Product':
            $isProduct = true;
        break;

        case 'Supplier':
            $isSupplier = true;
        break;

        case 'Inventory':
            $isInventory = true;
        break;

        case 'Staff':
            $isStaff = true;
        break;

        case 'Payroll':
            $isPayroll = true;
        break;

        case 'Quotation':
            $isQuotation = true;
        break;

        case 'Invoice':
            $isInvoice = true;
        break;

        case 'Reports':
            $isBestSelling = true;
            $isMonthlySales = true;
            $isMonthlyStock = true;
        break;

        case 'Gst': 
            $isGst = true;
        break;

        case 'ProductLevel':
            $isProductLevel = true;
        break;

        case 'PaymentType':
            $isPaymentType = true;
        break;

        case 'TermsAndConditions':
            $isTermsConditions = true;
        break;

        default:
            $navigation = true;

    }

}

$userFullname = Yii::$app->user->identity->fullname;

$array=array
(
    '0' => array
        (
            'product' => 'abc',
            'total' => 21
        ),
    '1' => array
        (
            'product' => 'xyz',
            'total' => 1
        ),
    '2' => array
        (
            'product' => 'pqr',
            'total' => 13
        )
);


?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
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
    
     <style>
            canvas{
            }
        </style>

</head>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="?" class="site_title"><i class="fa fa-car"></i> <span> Arh Group Pte Ltd. </span></a>
                    </div>
                    <div class="clearfix"></div>


                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="assets/bootstrap/images/user.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?= $userFullname ?></h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3 style="color:transparent;">-</h3>
                            <ul class="nav side-menu">
                                <?php if($isDashboard): ?>
                                <li><a href="?"><i class="fa fa-home"></i> Dashboard </a></li>
                                <?php endif; ?>
                                <?php if($isBranch): ?>
                                <li><a href="?r=branch" id="nav-branch" ><i class="fa fa-globe"></i> Branch </a></li>
                                <?php endif; ?>
                                <?php if($isRole || $isModules || $isUserPermission || $isUser): ?>
                                <li><a id="nav-user" ><i class="fa fa-user"></i>  User <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <?php if($isRole): ?>
                                        <li><a href="?r=role" id="nav-role" > User Role</a></li>
                                        <?php endif; ?>
                                        <?php if($isModules): ?>
                                        <li><a href="?r=modules" id="nav-modules"> Module List</a></li>
                                        <?php endif; ?>
                                        <?php if($isUserPermission): ?>
                                        <li><a href="?r=user-permission" id="nav-userPermission"> User Permission</a></li>
                                        <?php endif; ?>
                                        <?php if($isUser): ?>
                                        <li ><a href="?r=user" id="nav-userList"> User </a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endif; ?>
                                <?php if($isStaff): ?>
                                <li><a href="?r=staff" id="nav-staff"  ><i class="fa fa-windows"></i> Staff </a></li>
                                <?php endif; ?>
                                <?php if($isPayroll): ?>
                                <li><a href="?r=payroll" id="nav-payroll"  ><i class="fa fa-clipboard"></i> Payroll </a></li>
                                <?php endif; ?>
                                <?php if($isCustomer): ?>
                                <li><a href="?r=customer" id="nav-customer"  ><i class="fa fa-users"></i> Customer </a></li>
                                <?php endif; ?>
                                <?php if($isServiceCategory || $isService): ?>
                                <li><a id="nav-services" ><i class="fa fa-battery-quarter"></i> Services <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <?php if($isServiceCategory): ?>
                                        <li><a href="?r=service-category"  id="nav-serviceCategory" >Category</a></li>
                                        <?php endif; ?>
                                        <?php if($isService): ?>
                                        <li><a href="?r=service"  id="nav-serviceList" >Service List</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endif; ?>
                                <?php if($isCategory || $isProduct || $isSupplier || $isInventory): ?>
                                <li><a id="nav-parts" ><i class="fa fa-cogs"></i> Parts <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <?php if($isCategory): ?>
                                        <li><a href="?r=category"  id="nav-category" >Category</a></li>
                                        <?php endif; ?>
                                        <?php if($isProduct): ?>
                                        <li><a href="?r=product"  id="nav-product" >Parts</a></li>
                                        <?php endif; ?>
                                        <?php if($isSupplier): ?>
                                        <li><a href="?r=supplier" id="nav-supplier" >Parts-Supplier</a></li>
                                        <?php endif; ?>
                                        <?php if($isInventory): ?>
                                        <li><a href="?r=inventory" id="nav-inventory" > Parts-Inventory</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endif; ?>
                                <?php if($isQuotation || $isInvoice): ?>
                                <li><a><i class="fa fa-desktop"></i>Transactions <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <?php if($isQuotation): ?>
                                        <li><a href="?r=quotation" id="nav-quotation" > Job Sheet</a></li>
                                        <?php endif; ?>
                                        <?php if($isInvoice): ?>
                                        <li><a href="?r=invoice" id="nav-invoice" > Invoice</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endif; ?>
                                <?php if($isBestSelling || $isMonthlySales || $isMonthlyStock): ?>
                                <li><a id="nav-reports" ><i class="fa fa-bar-chart"></i> Reports <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <?php if($isBestSelling): ?>
                                        <li><a href="?r=reports/best-selling-product-report">Best Selling Product</a></li>
                                        <?php endif; ?>
                                        <?php if($isMonthlySales): ?>
                                        <li><a href="?r=reports/monthly-sales-report">Monthly Sales Report</a></li>
                                        <?php endif; ?>
                                        <?php if($isMonthlyStock): ?>
                                        <li><a href="?r=reports/monthly-stock-report">Monthly Stocks Report</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endif; ?>
                                <?php if($isGst || $isProductLevel): ?>
                                <li><a id="nav-reports" ><i class="fa fa-legal"></i> Utilities <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <?php if($isGst): ?>
                                        <li><a href="?r=gst">Set GST</a></li>
                                        <?php endif; ?>
                                        <?php if($isProductLevel): ?>
                                        <li><a href="?r=product-level">Set Parts Warning Level</a></li>
                                        <?php endif; ?>
                                        <?php if($isPaymentType): ?>
                                        <li><a href="?r=payment-type">Set Payment Type</a></li>
                                        <?php endif; ?>
                                        <?php if($isTermsConditions): ?>
                                        <li><a href="?r=terms-and-conditions">Set Terms & Conditions</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

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
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/bootstrap/images/user.png" alt=""><b> <?= $userFullname ?>
                                    <span class=" fa fa-angle-down"></span> </b>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="?r=settings">
                                            <span><center id="top-nav"><b><i class="fa fa-wrench"></i> Settings</center></b></span>
                                        </a>
                                    </li>
                                    <li><?php
                                        echo Html::beginForm(['/site/logout'], 'post',['id' => 'logout-form']) . '<a href="#" onclick="document.getElementById(\'logout-form\').submit(); return false;" class="form-btn btn btn-link btn-flat" style="color: #5A738E; "><i class="fa fa-power-off"></i> Sign out</a>'. Html::endForm();
                                      ?>
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
                <div class="">     
                <br/ >

                    <div>
                        <?= $content ?>
                    </div>

                </div>
                <br/>

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
    <!-- sparkline -->
    <script src="assets/bootstrap/js/sparkline/jquery.sparkline.min.js"></script>

    <script src="assets/bootstrap/js/custom.js"></script>
    <!-- skycons -->
    <script src="assets/bootstrap/js/skycons/skycons.js"></script>

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
    
    <!-- select2 -->
    <script type="text/javascript" src="assets/bootstrap/js/selecttwo.js"></script>

    <!-- add & remove new product -->
    <script type="text/javascript" src="assets/bootstrap/js/add-remove-new-product.js"></script>
    
    <!-- update stocks qty -->
    <script type="text/javascript" src="assets/bootstrap/js/update-stocks-qty.js"></script>
  
    <!-- flot -->
    <script type="text/javascript" src="assets/bootstrap/js/flot.js"></script>
    
    <!-- sparkline  -->
    <script type="text/javascript" src="assets/bootstrap/js/sparkline.js"></script>
    
    <!-- reportrange -->
    <!-- datepicker -->
    <script type="text/javascript" src="assets/bootstrap/js/reportrange-datepicker.js"></script>

    <!-- moris js -->
    <script type="text/javascript" src="assets/bootstrap/js/moris/raphael-min.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/moris/morris.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/moris.js"></script>
    
    <!-- skycons -->
    <script type="text/javascript" src="assets/bootstrap/js/skycons.js"></script>
    
    <!--  gauge-->
    <script type="text/javascript" src="assets/bootstrap/js/gauge.js"></script>
    

    <!-- user-permission -->
    <script type="text/javascript" src="assets/bootstrap/js/user-permission.js"></script>
    
    <!-- tab -->
    <script type="text/javascript" src="assets/bootstrap/js/tab.js"></script>

    <!-- quotation -->
    <script type="text/javascript" src="assets/bootstrap/js/quotation.js"></script>

    <!-- quotation -->
    <script type="text/javascript" src="assets/bootstrap/js/payment_method.js"></script>

    <!-- customer -->
    <script type="text/javascript" src="assets/bootstrap/js/customer.js"></script>

    <!-- main -->
    <script type="text/javascript" src="assets/bootstrap/js/main.js"></script>
    
    <script>
        var lab=[];
        var data=[];
        <?php 
        foreach($array as $tem)
        {

            ?>

            lab.push('<?php echo $tem['product']; ?>');
            data.push('<?php echo $tem['total']; ?>');
        <?php }

        ?>

        var barChartData = {
            labels : lab,
            datasets : [
                {
                    fillColor : "rgba(220,220,220,0.5)",
                    strokeColor : "rgba(220,220,220,1)",
                    data : data
                },

            ]

        }

    var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Bar(barChartData);

    </script>
    
    </body>   

</html>

<?php $this->endPage() ?>
