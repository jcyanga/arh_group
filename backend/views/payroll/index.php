<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use common\models\Customer;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll';

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
        <span class="form-header"><h4><i class="fa fa-clipboard"></i> Payroll</h4></span>
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
        <a href="?r=payroll/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New Payroll </b>
        </a>
    </p>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/><br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" > # </th>
            <th class="tblalign_center" > STAFF FULLNAME </th>
            <th class="tblalign_center" > BASIC </th>
            <th class="tblalign_center" > PAY DATE </th>
            <th class=" no-link last tblalign_center"><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getPayroll) ): ?>
            <?php foreach( $getPayroll as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="tblalign_center" ><?php echo $row['id'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['fullname'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['basic'];  ?></td>
                    <td class="tblalign_center" ><?php echo date('M-d-Y', strtotime($row['pay_date']));  ?></td>
                    <td class="last tblalign_center">
                        <a href="?r=payroll/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-eye"></li> </a> |
                        <a href="?r=payroll/update&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Update Record" ><li class="fa fa-pencil-square"></li> </a> | 
                        <a href="?r=payroll/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()" data-toggle="tooltip" data-placement="top" title="Delete Record"  ><li class="fa fa-trash"></li> </a>

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
            </tr>
        <?php endif; ?> 
    </tbody>
    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/>|<br/></div>

</div>

<br/>
