<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Redeem Points';

?>

<div class="row form-container">
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">
    
 <div class="form-title-container">
    <span class="form-header"><h4>View Redeem Points</h4></span>
 </div>      
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
    </div>
 </div>    
 <br/>

<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
    
    <div class="tile-stats">
    <br/>
        
        <div class="icon">
        <br/>
            <i class="fa fa-bell-o"></i>
        </div>

        <div class="count">
            <?= $customerPoints ?>
        </div>

        <h3>TOTAL POINTS</h3>

    <br/>
    </div>

</div>
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="tbl-container viewDesign">
        
        <?php if( !empty($getRedeemPoints) ): ?>
        
            <table style="border: solid 1px #eee;" class="table table-hover table-striped">
                <?php foreach($getRedeemPoints as $rpRow): ?>
                    <tr>
                        <td><b>TRANSACTION #</b></td>
                        <td><?php echo $rpRow['id']; ?></td>
                        <td><b>INVOICE NUMBER</b></td>
                        <td><?php echo $rpRow['invoice_no']; ?></td>
                        <td><b>REDEEM POINTS</b></td>
                        <td><?php echo $rpRow['points_redeem']; ?></td>
                        <td><b>TRANSACTION DATE</b></td>
                        <td><?php echo date('M-d-Y', strtotime($rpRow['payment_date'])); ?></td>
                        <td><b>TRANSACTION TIME</b></td>
                        <td><?php echo $rpRow['payment_time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php else: ?>
            <div>
                &nbsp; <h5> <b>-No Record Found.</b> </h5>
            </div>

        <?php endif; ?>
    </div>   
    <br/>

 </div>

</div>
<br/>
