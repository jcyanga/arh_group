<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Inventory;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventories';

?>

<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/>
 </div>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/>
 
 <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-database"></i> PARTS STOCK</h4></span>
 </div>
 <hr/><br/>

 <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b><i class="fa fa-sign-in"></i> Stock-In</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false"><b><i class="fa fa-sign-out"></i> Stock-Out</b></a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
    <div>
        <?php if($msg <> ''){ ?>
            <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
                <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
                <?php echo $msg; ?>
            </div>
        <?php } ?>
    </div>
    <br/> 

    <?php $form = ActiveForm::begin(['action' => '?r=stocks/create', 'method' => 'POST', 'class' => 'form-inline']); ?>

    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
        <button type="submit" name="btn-updateQty" class="form-btn btn btn-success"><i class="fa fa-edit"></i> Update Parts Quantity</button>
        <button type="button" name="btn-checkAll" class="form-btn btn btn-info " id="checkAllParts" ><i class="fa fa-check-square"></i> Select All</button>
    </div>
    <br/>

    <div>
        <label id="stockLabel">*Check Item you want to Update Quantity.</label>
    </div>
    <br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr style="font-size: 11px;" class="headings">
            <th class="tblalign_center" > <i class="fa fa-check"></i> </th>
            <th class="tblalign_center" ><b>SUPPLIER</b></th>
            <th class="tblalign_center" ><b>PRODUCT CODE</b></th>
            <th class="tblalign_center" ><b>PRODUCT NAME</b></th>
            <th class="tblalign_center" ><b>QUANTITY</b></th>
            <th class="tblalign_center" ><b>COST PRICE</b></th>
            <th style="text-align: center;" ><b>SELLING PRICE</b></th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getProductInInventory) ): ?>
            <?php foreach( $getProductInInventory as $row){ ?>
                <tr style="font-size: 11px; text-transform: uppercase;" class="even_odd pointer">
                    <td style="text-align: center;" class=" ">
                        <input type="checkbox" name="updateQty[]" value="<?php echo $row['id'] . '|' . $row['product_name'] . '|' . $row['quantity'] . '|' . $row['product_id'] . '|' . $row['supplier_id'] . '|' . $row['cost_price'] . '|' . $row['selling_price'];  ?>" id="updateQty" class="updateQty" /></td>
                    <td class="tblalign_center"><?php echo $row['supplier_name'];  ?></td>
                    <td class="tblalign_center"><?php echo $row['product_code'];  ?></td>
                    <td class="tblalign_center"><?php echo $row['product_name'];  ?></td>
                    <td class="stockTableQty"><a><?php echo $row['quantity'];  ?></a></td>
                    <td class="tblalign_center"><?php echo $row['cost_price'];  ?></td>
                    <td class="tblalign_center"><?php echo $row['selling_price'];  ?></td>
                </tr>
            <?php } ?>    
            <?php else: ?>
                <tr>
                    <td>No Record Found.</td>
                    <td></td>
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

    <?php ActiveForm::end(); ?>
    <br/><br/>

    </div>
    
 
                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip</p>
                </div>
                
 
            </div>
        </div>

 </div>

</div>

<br/>







