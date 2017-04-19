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

$roleId = Yii::$app->user->identity->role_id;
$userFullname = Yii::$app->user->identity->fullname;

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
    <!-- <link rel="stylesheet" href="assets/bootstrap/css/cssprint.css" media="print" /> -->
    
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
<style type="text/css">
     body {
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 21cm;
        min-height: 29.7cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 1cm;
        /*border: 5px red solid;*/
        /*height: 256mm;*/
        /*outline: 2cm #FFEAEA solid;*/
    }
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }

        /* Payslip */

        .invoice-box .receiptLogo {
            height: 100px; 
            width: 100px; 
            /*max-width: 100%;*/
        }

        .invoice-box .psBranchContainer {
            text-align: left; 
            margin-left: -25px;
            font-size: 14px; 
            font-family: Arial;
        }

        .invoice-box .psBranchName {
            margin-top: 15px;
            line-height: 125%;
            font-size: 14px;
            font-family: Arial;
        }

        .invoice-box .psAddressInfo {
            margin-top: 1px; 
            line-height: 125%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psContactnoInfo {
            line-height: 125%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psFaxInfo {
            line-height: 125%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psEmailInfo {
            line-height: 125%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psWebsiteInfo {
            line-height: 125%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psStaffContainer {
            margin-top: 5px; 
            margin-left: 5px;
            font-family: Arial;
            text-align: left;
        }

        .invoice-box .psEmpCode {
            line-height: 125%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psEmpCodeAlign {
            margin-left: 27px;
        }

        .invoice-box .psEmpIc {
            line-height: 200%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psEmpIcWidth {
            width: 45%;
        }

        .invoice-box .psEmpIcAlign {
            margin-left: -10px;
        }

        .invoice-box .psEmpName {
            line-height: 130%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psEmpNameAlign {
            margin-left: 20px;
        }

        .invoice-box .psInfoAlign {
            margin-left: 10px;
        }

        .invoice-box .psInfoLabelWidth {
            width: 40%;
        }

        .invoice-box .psInfoValueWidth {
            width: 60%;
        }

        .invoice-box .PayslipInfoLabel {
            line-height: 140%;
            text-align: left; 
            font-size: 13px; 
            font-family: Arial;
        }

        .invoice-box .psPayslipNo {
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psPayslipMonth {
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psDateIssue {
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psDept {
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psJobTitle {
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psNationality {
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psGender {
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psEarningLabelsWidth {
            width: 40%;
        }

        .invoice-box .psEarningValueWidth {
            width: 25.5%;
        }

        .invoice-box .psEarningContainer {
            margin-top: -5px;   
            text-align: left; 
            margin-left: -5px;
            text-transform: uppercase;
        }

        .invoice-box .psStandardPay {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psOtHour {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psOtRatePerHour {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psOtPay {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psAllowance {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psNonTaxAllowance {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psLevySupplement {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psTotalEarning {
            line-height: 300%;
            font-size: 12px;
            font-family: Arial;
        }

        .invoice-box .psDeductionLabelsWidth {
            width: 55%; 
            margin-left: -110px; 
            margin-top: 20px;
        }

        .invoice-box .psDeductionValueWidth {
            width: 35%; 
            margin-top: 20px;
        }

        .invoice-box .psDeductionContainer {
            margin-top: -5px;   
            text-align: left; 
            margin-left: -5px;
            text-transform: uppercase;
        }

        .invoice-box .psCashAdvance {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psOtherDeduction {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psMonthlyLevyCharge {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psEmployeeCpf {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psEmployerCpf {
            line-height: 150%;
            font-size: 10px;
            font-family: Arial;
        }

        .invoice-box .psLEmployerCpf {
            line-height: 150%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psLTotalCpf {
            line-height: 175%;
            font-size: 11px;
            font-family: Arial;
        }

        .invoice-box .psTotalDeduction {
            line-height: 300%;
            font-size: 12px;
            font-family: Arial;
        }

        .invoice-box .psNettPay {
            line-height: 300%;
            font-size: 12px;
            font-family: Arial;
        }

        .invoice-box .psHeaders {
            font-family: Arial; 
            font-weight: bold;
        }

        .invoice-box .psNotesContainer {
            border: solid 1px #444; 
            font-size: 11px; 
            border-radius: 3px;
        }

        .invoice-box .psNotesContent {
            margin-left: 5px; 
            height: 75px; 
            line-height: 150%;
        }

        .invoice-box .hrLine {
            border-top: 1px solid #111111;
        }

        .invoice-box .psReceiverContent {
            margin-top: 65px;
            margin-left: -180px; 
            font-size: 11px; 
            font-family: Arial; 
            line-height: 165%;
        }

        /* Quotation and Invoice */

        .invoice-box .jiReceiptLogo {
            height: 65px; 
            width: 75px; 
            /*max-width: 100%;*/
        }

        .invoice-box .branchcustomerContainer {
            margin-top: -10px;    
            text-align: left; 
            margin-left: -25px;
            font-size: 14px; 
            text-transform: uppercase;
        }

        .invoice-box .branchName {
            line-height: 125%;
            margin-top: 15px;
            font-family: Arial;
            font-size: 18px;
        }

        .invoice-box .addressInfo {
            margin-top: 2px;
            line-height: 125%;
            font-size: 8px;
            font-family: Arial;
        }

        .invoice-box table.headers{
            background-color: #41464c !important;
            border: solid 1px #41464c; 
            -webkit-print-color-adjust: exact;
            -moz-print-color-adjust: exact;
            -o-print-color-adjust: exact;
        }

        .invoice-box table.headers td{
            color: #fff !important; 
            -webkit-print-color-adjust: exact;
            -moz-print-color-adjust: exact;
            -o-print-color-adjust: exact;
        }

        .invoice-box .jobsheetinvoiceLabel {
            text-align: right; 
            font-size: 13px; 
            line-height: 150%;
            font-family: Arial;
        }

        .invoice-box .jobsheetinvoiceAlign {
            margin-left: 40px;
        }

        .invoice-box .jobsheetinvoiceHeaderAlign {
            margin-left: 70px;
        }

        .invoice-box .jobsheetinvoiceHeaderAlign1 {
            margin-left: 10px;
        }

        .invoice-box .jobsheetinvoiceDate {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceNo {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceVehicle {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceMake {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceModel {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceComeIn {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceComeOut {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceCompanyTel {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceHomeTel {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceHanphoneTel {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceMileage {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoicePoints {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box .jobsheetinvoiceTerms {
            font-size: 11px; 
            font-family: Arial;
            line-height: 150%;
            float: right;
            display: inline-block;
        }

        .invoice-box #receiptorderNumberHeader {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #receiptorderDescriptionHeader {
            width: 50%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #receiptorderQtyHeader {
            width: 20%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #receiptorderSubtotalHeader {
            width: 20%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box .receiptorderTable {
            border: solid 1px #666;
        }

        .invoice-box #orderNumbers {
            width: 10%; 
            text-align: center; 
            font-size: 11px; 
            line-height: 175%;
        }

        .invoice-box #orderDescriptions {
            width: 50%; 
            text-align: center; 
            font-size: 11px; 
            line-height: 175%;
        }

        .invoice-box #orderQtys {
            width: 20%; 
            text-align: center; 
            font-size: 11px; 
            line-height: 175%;
        }

        .invoice-box #orderSubtotals {
            width: 20%; 
            text-align: center; 
            font-size: 11px; 
            line-height: 175%;
        }

        .invoice-box .carSize {
            width: 100%; 
            height: 100%;
        }

        .invoice-box .termsandconditionsLists {
            text-align: left; 
            font-size: 8px; 
            line-height: 120%;
        }

        .invoice-box #invoiceorderNumberHeader {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #invoiceorderDescriptionHeader {
            width: 30%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #invoiceorderUnitPriceHeader {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #invoiceorderQtyHeader {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #invoiceorderDiscountHeader {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #invoiceorderAddDiscountHeader {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #invoiceorderSubTotalHeader {
            width: 20%; 
            text-align: center; 
            font-size: 11px;
        }

        .invoice-box #invoiceorderNumber {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
            line-height: 175%;
        }

        .invoice-box #invoiceorderDescription {
            width: 30%; 
            text-align: center; 
            font-size: 11px;
            line-height: 175%;
        }

        .invoice-box #invoiceorderUnitPrice {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
            line-height: 175%;
        }

        .invoice-box #invoiceorderQty {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
            line-height: 175%;
        }

        .invoice-box #invoiceorderDiscount {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
            line-height: 175%;
        }

        .invoice-box #invoiceorderAddDiscount {
            width: 10%; 
            text-align: center; 
            font-size: 11px;
            line-height: 175%;
        }

        .invoice-box #invoiceorderSubTotal {
            width: 20%; 
            text-align: center; 
            font-size: 11px;
            line-height: 175%;
        }

        .invoice-box #invoicesubTableLabel {
            width: 80%; 
            text-align: right; 
            font-size: 11px
            line-height: 175%;
        }

        .invoice-box #invoicesubTableInfo {
            width: 20%; 
            text-align: center; 
            font-size: 11px;
            line-height: 175%;
        }

        .invoice-box .customerInfoContainer {
            margin-left: -105px;
            margin-top: 125px;
        }

        .invoice-box .customerName {
            font-size: 11px;
            font-family: Arial;
            line-height: 125%;
            text-transform: uppercase;
        }

        .invoice-box .customerAddressInfo { 
            line-height: 125%;
            font-size: 11px;
            font-family: Arial;
            text-transform: uppercase;
        }

    }


    /*body {
      background: rgb(204,204,204); 
    }
    page[size="A4"] {
      background: white;
      width: 21cm;
      height: 29.7cm;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }
    @media print {
      body, page[size="A4"] {
        margin: 0;
        box-shadow: 0;
      }
    }*/
</style>

</head>

<body style="background: #ffffff;">

        

    <!-- page content -->
        <div >
            <?= $content ?>
        </div>           

    <!-- /page content -->

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
    
    <!-- staff/payroll -->
    <script type="text/javascript" src="assets/bootstrap/js/staff_payroll.js"></script>

    </body>   

</html>

<?php $this->endPage() ?>
