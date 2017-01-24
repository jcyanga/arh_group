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
        <span class="form-header"><h4><i class="fa fa-users"></i> Customer Maintenance</h4></span>
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
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>

        <a href="?r=customer/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Print to PDF </b>
        </a>
    </p>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/><br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" >
                <!-- <i class="fa fa-envelope-o"></i> -->
            </th>
            <th class="tblalign_center" > FULLNAME </th>
            <th class="tblalign_center" > PHONE NUMBER </th>
            <th class="tblalign_center" > CAR-PLATE </th>
            <th class="tblalign_center" > MEMBER ? </th>
            <th class="tblalign_center" > MEMBER EXPIRY </th>
            <th class="no-link last tblalign_center"><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if(count($getCustomer) > 0 ): ?>
            <?php foreach( $getCustomer as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="a-center tblalign_center">
                        <!-- <input type="checkbox" class="chkUser form-control" value="<?php echo $row['id']; ?>"> -->
                    </td>
                    <td class="tblalign_center" ><?php echo $row['fullname'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['hanphone_no'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['carplate'];  ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['is_member'] == 1 )? 'Yes' : 'No'; ?></td>
                    <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($row['member_expiry']));  ?></td>
                    <td class="last tblalign_center">
                        <a href="?r=customer/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-eye"></li> </a> |
                        <a href="?r=customer/update&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Update Record" ><li class="fa fa-pencil-square"></li> </a> | 
                        <a href="?r=customer/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()" data-toggle="tooltip" data-placement="top" title="Delete Record" ><li class="fa fa-trash"></li> </a> |
                         <a href="?r=customer/points-redemption-history&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Points Redemption History" ><li class="fa fa-laptop"></li> </a> 
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



