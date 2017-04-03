<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use common\models\User;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';

?>

<div class="row form-container">

<div>
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
            <h5 class="alert-heading"><i class="fa fa-info-circle"></i> <?= Yii::$app->session->getFlash('success'); ?></h5>
        </div>
    <?php endif; ?>
</div>

 <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-user"></i> User Maintenance</h4></span>
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
        <a href="?r=user/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New User </b>
        </a>

        <a href="?r=user/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>

        <a href="?r=user/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
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
            <th class="tblalign_center" > BRANCH </th>
            <th class="tblalign_center" > ROLE </th>
            <th class="tblalign_center" > FULLNAME </th>
            <th class="tblalign_center" > E-MAIL </th>
            <th class="tblalign_center" > STATUS </th>
            <th class="no-link last tblalign_center"><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getUser) ): ?>
            <?php foreach( $getUser as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="tblalign_center" ><?php echo $row['name'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['role'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['fullname'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['email'];  ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['status'] == 1 ) ? 'Active' : 'Inactive'; ?></td>
                    <td class="last tblalign_center">
                        <a href="?r=user/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-eye"></li> </a> |
                        <a href="?r=user/update&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit Record" ><li class="fa fa-pencil-square"></li> </a> | 
                        <a href="?r=user/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()" data-toggle="tooltip" data-placement="top" title="Delete Record" ><li class="fa fa-trash"></li> </a>
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
            </tr>
        <?php endif; ?> 
    </tbody>
    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/>|<br/></div>

</div>


