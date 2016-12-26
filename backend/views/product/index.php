<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use common\models\Product;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';

?>

<div class="form-container product-index">

<?php if($msg <> ''){ ?>
    <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
          <?php echo $msg; ?>
    </div>
<?php } ?>

    <div class="form-title-container">
        <span class="form-header"><h4>Product Maintenance</h4></span>
    </div>      
    <hr/>
    
    <div>
        <p>
            &nbsp;
            <?= Html::button('<i class=\'icon-arrow-left\'></i> Back to Previous Page', ['name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','class'=>'uibutton loading confirm form-btn btn btn-default ']) ?>
        </p>
    </div>

    <div class="form-search-container">    
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <hr/>

    <div class="other-btns-container">
        <p>
            <?= Html::a('<i class=\'icon-plus-sign\'></i> New Product', ['create'], ['class' => 'form-btn btn btn-success']) ?>

            <?= Html::a('<i class=\'icon-print\'></i> Export Product List', '?r=customer/status', ['onclick' => 'return print_confirmation()', 'class' => 'form-btn btn btn-warning']) ?>
    
            <?php echo str_repeat('&nbsp;', 5); ?>
        </p>
    </div>

    <div class="tbl-container">
        <table class="table table-striped table-bordered">
            <thead style="background: #eee;">
                <tr>
                    <th><b>ID</b></td>
                    <th><b>PRODUCT CATEGORY</b></th>
                    <th><b>PRODUCT CODE</b></th>
                    <th><b>PRODUCT NAME</b></th>
                    <th><b>UNIT OF MEASURE</b></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productResult as $row) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['product_code']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['unit_of_measure']; ?></td>
                        <td>
                            <a href="?r=product/view&id=<?php echo $row['id']; ?>"><span class="icon-eye-open"></span> VIEW INFO. </a>
                            <a href="?r=product/update&id=<?php echo $row['id']; ?>"><span class="icon-copy"></span> UPDATE INFO. </a>
                            <a href="?r=product/delete-column&id=<?php echo $row['id']; ?>" onclick="return confirmation()"><span class="icon-trash"></span> DELETE INFO? </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php    

            // $gridColumns =
            //  [
            //     // ['class' => 'yii\grid\SerialColumn'],

            //     // 11'id',

            //     [
            //         'attribute' => 'id',
            //         'label' => 'ID',
            //     ],

            //     [
            //         'attribute' => 'category',
            //         'label' => 'CATEGORY',
            //     ],

            //     [
            //         'attribute' => 'product_code',
            //         'label' => 'PRODUCT CODE',
            //     ],

            //     [
            //         'attribute' => 'product_name',
            //         'label' => 'PRODUCT NAME',
            //     ],
                
            //     [
            //         'attribute' => 'unit_of_measure',
            //         'label' => 'UNIT OF MEASURE',
            //     ],

            //     // [
            //     //     'attribute' => 'status',
            //     //     'label' => 'STATUS',
            //     // ],

            //     [
            //         'class' => 'yii\grid\ActionColumn',
            //         'template' => '{preview}{history}{amend}{remove}{status}',
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
            //                 $url ='?r=product/view&id='.$model->id;
            //                 return $url;
            //             }
            //             if ($action === 'amend') {
            //                 $url ='?r=product/update&id='.$model->id;
            //                 return $url;
            //             }
            //             if ($action === 'remove') {
            //                 $url ='?r=product/delete-column&id='.$model->id;
            //                 return $url;
            //             }
            //             if ($action === 'history') {
            //                 $url ='?r=product/history&id='.$model->id;
            //                 return $url;
            //             }
            //             if ($action === 'status') {
            //                 $url ='?r=product/status&id='.$model->id;
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



        <br/>
    </div>
</div>
<br/>

