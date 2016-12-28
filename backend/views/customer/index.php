<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use common\models\Customer;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';

?>

<div class="row form-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
  
    <div>
        <?php if($msg <> ''){ ?>
            <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
                <?php echo $msg; ?>
            </div>
        <?php } ?>
    </div>

    <div class="form-title-container">
        <span class="form-header"><h4>Customer Maintenance</h4></span>
    </div>
    <hr/>

    <div class="form-search-container">    
      <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>   
 
 </div>

</div>
<br/>

<div style="text-align: right;" class="other-btns-container">
<br/>

    <p>
        <a href="?r=customer/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New Customer </b>
        </a>

        <a href="?r=customer/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Export to Excel </b>
        </a>

        <a href="?r=customer/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Export to PDF </b>
        </a>
    </p>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/><br/>

    <table id="tblcustomer" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr style="font-size: 12px;" class="headings">
            <th>
                <input type="checkbox" class="tableflat">
            </th>
            <th> FULLNAME </th>
            <th> PHONE NUMBER </th>
            <th> CAR-PLATE </th>
            <th> MEMBER EXPIRY </th>
            <th> STATUS </th>
            <th style="text-align: center;" class=" no-link last"><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php foreach( $getCustomer as $row){ ?>
            <tr style="font-size: 12px; text-transform: uppercase;" class="even_odd pointer">
                <td class="a-center ">
                    <input type="checkbox" class="tableflat" value="<?php echo $row['id']; ?>">
                </td>
                <td class=" "><?php echo $row['fullname'];  ?></td>
                <td class=" "><?php echo $row['hanphone_no'];  ?></td>
                <td class=" "><?php echo $row['carplate'];  ?></td>
                <td class=" "><?php echo date('m-d-Y', strtotime($row['member_expiry']));  ?></td>
                <td class=" "><?php echo ( $row['status'] == 1 ) ? 'Active' : 'Inactive'; ?></td>
                <td style="text-align: center; font-size: 12px;" class=" last">
                    <a href="?r=customer/view&id=<?php echo $row['id']; ?>"><b><li class="fa fa-eye"></li> VIEW </b></a> | 
                    <a href="?r=customer/update&id=<?php echo $row['id']; ?>"><b><li class="fa fa-pencil-square"></li> UPDATE </b></a> | 
                    <a href="?r=customer/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()"><b><li class="fa fa-trash"></li> DELETE </b></a>
                </td>
            </tr>
        <?php } ?> 
    </tbody>
    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/>|<br/></div>

</div>

<br/>



