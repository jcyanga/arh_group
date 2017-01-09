<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use common\models\Service;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Service Categories';

?>

<div class="row form-container">

<div>
    <?php if($msg <> ''){ ?>
        <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
            <?php echo $msg; ?>
        </div>
    <?php } ?>
</div>

 <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4>Service Maintenance</h4></span>
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
        <a href="?r=service/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New Service </b>
        </a>

        <a href="?r=service/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Export to Excel </b>
        </a>

        <a href="?r=service/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Export to PDF </b>
        </a>
    </p>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/><br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr style="font-size: 11px;" class="headings">
            <th> # </th>
            <th class="tblalign_center"> SERVICE CATEGORY </th>
            <th class="tblalign_center"> SERVICE NAME </th>
            <th class="tblalign_center"> DESCRIPTION </th>
            <th class="tblalign_center"> DEFAULT PRICE </th>
            <th class="tblalign_center"> STATUS </th>
            <th style="text-align: center;" class=" no-link last"><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getService) ): ?>
            <?php foreach( $getService as $row){ ?>
                <tr style="font-size: 11px; text-transform: uppercase;" class="even_odd pointer">
                    <td class=" "><?php echo $row['id'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo $row['name'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo $row['service_name'];  ?></td>
                    <td style="text-align: center; width: 40%;" class=" "><?php echo $row['description'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo $row['default_price'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo ( $row['status'] == 1 ) ? 'Active' : 'Inactive' ;  ?></td>
                    <td style="text-align: center; font-size: 13px;" class=" last">
                        <a href="?r=service/view&id=<?php echo $row['id']; ?>"><li class="actionTooltip fa fa-eye"><span class="actionTooltiptext">View record</span></li> </a> |
                        <a href="?r=service/update&id=<?php echo $row['id']; ?>"><li class="actionTooltip fa fa-pencil-square"><span class="actionTooltiptext">Update record</span></li> </a> | 
                        <a href="?r=service/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()"><li class="actionTooltip fa fa-trash"><span class="actionTooltiptext">Delete record</span></li> </a>
                    </td>
                </tr>
            <?php } ?> 
        <?php else: ?>
            <tr>
                <td><span>No Record Found.</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endif; ?> 
    </tbody>
    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/>|<br/></div>

</div>

<br/>








