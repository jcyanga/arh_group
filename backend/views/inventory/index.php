<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Inventory;
use common\models\Supplier;
use common\models\Product;

use yii\db\Query;

$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'supplier_name');

$rows = new Query();

$dataProduct = ArrayHelper::map($rows->select(['id', "concat(product_code, ' - ' ,product_name) as product_name"])
            ->from('product')
            ->all(),
             'id', 'product_name');


// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Inventories';

?>

<div class="form-container inventory-index">

<?php if($msg <> ''){ ?>
    <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
          <?php echo $msg; ?>
    </div>
<?php } ?>

    <div class="form-title-container">
        <span class="form-header"><h4>PRODUCT INVENTORY</h4></span>
    </div>      
    <hr/>
    
    <div>
        <p>
            &nbsp;
            <?= Html::button('<i class=\'icon-arrow-left\'></i> Back to Previous Page', ['name' => 'btnBack','onclick'=>'   js:history.go(-1);returnFalse;','class'=>'uibutton loading confirm form-btn btn btn-default ']) ?>
        </p>
    </div>
    <br/>

   <!--  <div class="form-search-container">    
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div> -->
    <!-- <hr/><br/><br/> -->

    <div class="other-btns-container">
        <p>
            <a href=#><img src="assets/icons/add_image.png" style="height: 35px; width: 40px;" class="modal-addProduct"></img></a>
            &nbsp;

            <a href="index.php?r=supplier/create"><img src="assets/icons/cogs.png" style="height: 35px; width: 40px;"></img></a>
            &nbsp;

            <a href="index.php?r=product/create"><img src="assets/icons/barcode.png" style="height: 35px; width: 40px;"></img></a>
            &nbsp;

            <a href="#"><img src="assets/icons/xport2xcel.png" style="height: 35px; width: 40px;"></img></a>
            &nbsp;
            <!-- <?= Html::a('<i class=\'icon-plus-sign\'></i> New Item in Inventory', '#', ['class' => 'form-btn btn btn-success modal-addProduct']) ?>

            <?= Html::a('<i class=\'icon-print\'></i> Export Customer List', '?r=customer/status', ['onclick' => 'return print_confirmation()', 'class' => 'form-btn btn btn-warning']) ?> -->
    
            <?php echo str_repeat('&nbsp;', 5); ?>
        </p>
    </div>

    <div class="tbl-container">
        <table style="background: #fff; text-transform: uppercase;" class="table table-bordered">
            <thead>
                <tr>
                    <th style="background: blue; color: #fff;"><b>SUPPLIER</b></th>
                    <th style="background: blue; color: #fff;"><b>PRODUCT CODE</b></th>
                    <th style="background: blue; color: #fff;"><b>PRODUCT NAME</b></th>
                    <th style="background: blue; color: #fff;"><b>QUANTITY</b></th>
                    <th style="background: blue; color: #fff;"><b>COST PRICE</b></th>
                    <th style="background: blue; color: #fff;"><b>SELLING PRICE</b></th>
                    <th style="background: blue; color: #fff;">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($getProductInInventory as $row) { ?>
                    <tr>
                        <td><b><?php echo $row['supplier_name']; ?></b></td>
                        <td><b><?php echo $row['product_code']; ?></b></td>
                        <td><b><?php echo $row['product_name']; ?></b></td>
                        <td><b><?php echo $row['quantity']; ?></b></td>
                        <td><b><?php echo $row['cost_price']; ?></b></td>
                        <td><b><?php echo $row['selling_price']; ?></b></td>
                        <td>
                            <a href="?r=inventory/view&id=<?php echo $row['id']; ?>"><img src="assets/icons/view.icon.png" style="height: 20px; width: 20px;"></a>
                            &nbsp;

                            <a href="#" id="<?php echo $row['id']; ?>" class="modal-editProduct" ><img src="assets/icons/edit.png" style="height: 20px; width: 20px;" ></img></a>
                            &nbsp;

                            <a href="?r=inventory/delete&id=<?php echo $row['id']; ?>"><img src="assets/icons/delete.png" style="height: 20px; width: 20px;"></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
            
            // $gridColumns =
            //  [

            //     [
            //         'class' => 'yii\grid\ActionColumn',
            //         'template' => '{send}',
            //         'buttons' => [
            //             'send' => function ($url, $model) {
            //                 return Html::CheckBox('f_n',false, array (
            //                             'value'=>'on',
            //                             ));
            //             },
            //         ]
            //     ],

            //     [
            //         'attribute' => 'supplier_id',
            //         'label' => 'supplier',
            //     ],

            //     [
            //         'attribute' => 'product_id',
            //         'label' => 'product',
            //     ],
                
                
            //     [
            //         'attribute' => 'quantity',
            //         'label' => 'quantity',
            //     ],

            //     [
            //         'attribute' => 'selling_price',
            //         'label' => 'selling price',
            //     ],

            //     [
            //         'attribute' => 'cost_price',
            //         'label' => 'cost price',
            //     ],

            //     // [
            //     //     'attribute' => 'status',
            //     //     'label' => 'STATUS',
            //     // ],

            //     [
            //         'class' => 'yii\grid\ActionColumn',
            //         'template' => '{preview}{history}{amend}{remove}{rewards}',
            //         'buttons' => [
            //             'preview' => function ($url, $model) {
            //                 return Html::a(' <span class="icon-eye-open"> VIEW INFO. </span> ', $url, [
            //                             'title' => Yii::t('app', 'Preview'),
            //                 ]);
            //             },
            //             'amend' => function ($url, $model) {
            //                 return Html::a(' <span class="icon-copy"> UPDATE INFO. </span> ', $url, [
            //                             'title' => Yii::t('app', 'Amend'),
            //                 ]);
            //             },
            //             'remove' => function ($url, $model) {
            //                 return Html::a(' <span class="icon-trash"> DELETE INFO? </span> ', $url, ['onclick' => 'return confirmation()',
            //                             'title' => Yii::t('app', 'Remove'),
            //                             'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
            //                             // 'data-method' => 'post',
            //                 ]);
            //             },
            //             // 'status' => function ($url, $model) {
            //             //     return Html::a(' <span class="icon-copy"> Change Status </span> ', $url, [
            //             //                 'title' => Yii::t('app', 'Status'),
            //             //         ]);
            //             // }
            //             // 'history' => function ($url, $model) {
            //             //     return Html::a(' <span class="glyphicon glyphicon glyphicon-time"></span> ', $url, [
            //             //                 'title' => Yii::t('app', 'History'),
            //             //     ]);
            //             // },
            //         ],
            //         'urlCreator' => function ($action, $model, $key, $index) {
            //             if ($action === 'preview') {
            //                 $url ='?r=customer/view&id='.$model->id;
            //                 return $url;
            //             }
            //             if ($action === 'amend') {
            //                 $url ='?r=customer/update&id='.$model->id;
            //                 return $url;
            //             }
            //             if ($action === 'remove') {
            //                 $url ='?r=customer/delete-column&id='.$model->id;
            //                 return $url;
            //             }
            //             if ($action === 'history') {
            //                 $url ='?r=customer/history&id='.$model->id;
            //                 return $url;
            //             }
            //             if ($action === 'status') {
            //                 $url ='?r=customer/status&id='.$model->id;
            //                 return $url;
            //             }
            //             if($action === 'rewards') {
            //                 $url ='?r=customer/rewards&id='.$model->id;
            //                 return $url;
            //             }
            //         }
            //     ],
            //    ] 
         ?>

        <?php

            // echo GridView::widget([
            //     'dataProvider' => $dataProvider,
            //     // 'filterModel' => $searchModel,
            //     'columns' => $gridColumns,
            //     // 'showFooter'=>true,
            // ]);
        ?>

        <!-- <div>
            <p><b> <?= Html::a('<i class=\'icon-arrow-up\'></i> <i class=\'icon-trash\'></i> REMOVE SELECTED ITEM/S', ['send'], ['style' => 'font-size: 10px;', 'class' => 'form-btn btn btn-default']) ?></b></p>
        </div> -->
        <br/><br/>

    </div>
</div>
<br/>

<div class="modal fade" id="modal-addProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
 <div class="modal-dialog">
    <div class="modal-content">

<div style="background: #fff; border-top-right-radius: 10px; border-top-left-radius: 10px;" class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"> <img src="assets/icons/add_image.png" style="height: 35px; width: 35px;" class="modal-addProduct"></img> NEW ITEM IN INVENTORY</h4>
</div>

<div class="modal-body">

    <?php $form = ActiveForm::begin(['action' => '/index.php?r=inventory/create', 'method' => 'post', 'id' => 'modal-form', 'class' => 'form-inline']); ?>

    <div class="search-label-container">
        <span class="search-label"><li class="icon-edit"></li> Fill-up all the field.</span>
    </div>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">SUPPLIER</label>
        <?= $form->field($model, 'supplier_id')->dropDownList($dataSupplier, ['style' => 'text-transform: uppercase; border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;', 'id' => 'supplier_id'])->label(false) ?>
    </div>
    <br/>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">PRODUCT</label>
        <?= $form->field($model, 'product_id')->dropDownList($dataProduct, ['style' => 'text-transform: uppercase; border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;', 'id' => 'product_id'])->label(false) ?>
    </div>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">QUANTITY</label>
        <?= $form->field($model, 'quantity')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;','autocomplete' => 'off', 'id' => 'quantity', 'placeholder' => 'Enter Quantity here...'])->label(false) ?>
    </div>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">COST PRICE</label>
        <?= $form->field($model, 'cost_price')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;','autocomplete' => 'off', 'id' => 'cost_price', 'placeholder' => 'Enter Cost Price here...'])->label(false) ?>
    </div>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">SELLNG PRICE</label>
        <?= $form->field($model, 'selling_price')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;','autocomplete' => 'off', 'id' => 'selling_price', 'placeholder' => 'Enter Selling Price here...'])->label(false) ?>
    </div>


</div>

    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-remove-sign"></i>  Close</button>
    <button type="button" id="modal-submit" class="btn btn-primary"><i class="icon-share"></i>  Submit</button>
    </div>
    
    <?php ActiveForm::end() ?>
    
    </div>
 </div>
</div>



<div class="modal fade" id="modal-editProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
 <div class="modal-dialog">
    <div class="modal-content">

<div style="background: #fff; border-top-right-radius: 10px; border-top-left-radius: 10px;" class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"> <img src="assets/icons/add_image.png" style="height: 35px; width: 35px;" class="modal-addProduct"></img> EDIT ITEM IN INVENTORY</h4>
</div>

<div class="modal-body">

    <?php $form = ActiveForm::begin(['action' => '/index.php?r=inventory/update', 'method' => 'post', 'id' => 'modal-form-update', 'class' => 'form-inline']); ?>

    <div class="search-label-container">
        <span class="search-label"><li class="icon-edit"></li> Fill-up all the field.</span>
    </div>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">SUPPLIER</label>
        <?= $form->field($model, 'supplier_id')->dropDownList($dataSupplier, ['style' => 'text-transform: uppercase; border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;', 'id' => 'supplier_id'])->label(false) ?>
    </div>
    <br/>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">PRODUCT</label>
        <?= $form->field($model, 'product_id')->dropDownList($dataProduct, ['style' => 'text-transform: uppercase; border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;', 'id' => 'product_id'])->label(false) ?>
    </div>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">QUANTITY</label>
        <?= $form->field($model, 'quantity')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;','autocomplete' => 'off', 'id' => 'quantity', 'placeholder' => 'Enter Quantity here...'])->label(false) ?>
    </div>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">COST PRICE</label>
        <?= $form->field($model, 'cost_price')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;','autocomplete' => 'off', 'id' => 'cost_price', 'placeholder' => 'Enter Cost Price here...'])->label(false) ?>
    </div>

    <div class="floating-box">
        <label style="font-size: 11px; font-weight: bold;">SELLNG PRICE</label>
        <?= $form->field($model, 'selling_price')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 11px;','autocomplete' => 'off', 'id' => 'selling_price', 'placeholder' => 'Enter Selling Price here...'])->label(false) ?>
    </div>


</div>

    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-remove-sign"></i>  Close</button>
    <button type="button" id="modal-submit" class="btn btn-primary"><i class="icon-share"></i>  Submit</button>
    </div>
    
    <?php ActiveForm::end() ?>
    
    </div>
 </div>
</div>

