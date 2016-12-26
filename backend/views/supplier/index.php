<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';

?>

<div class="form-container supplier-index">

<?php if($msg <> ''){ ?>
    <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
          <?php echo $msg; ?>
    </div>
<?php } ?>

    <div class="form-title-container">
        <span class="form-header"><h4>Suppliers Maintenance</h4></span>
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
            <?= Html::a('<i class=\'icon-plus-sign\'></i> New Supplier', ['create'], ['class' => 'form-btn btn btn-success']) ?>

            <?= Html::a('<i class=\'icon-print\'></i> Export Supplier List', ['new'], ['class' => 'form-btn btn btn-warning']) ?>
            <?php echo str_repeat('&nbsp;', 5); ?>
        </p>
    </div>

    <div class="tbl-container">
        <?php
            // 'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            

            $gridColumns =
             [
                // ['class' => 'yii\grid\SerialColumn'],

                // 11'id',

                [
                    'attribute' => 'id',
                    'label' => 'ID',
                ],

                [
                    'attribute' => 'supplier_code',
                    'label' => 'Supplier Code',
                ],

                [
                    'attribute' => 'supplier_name',
                    'label' => 'Supplier Name',
                ],

                [
                    'attribute' => 'address',
                    'label' => 'Address',
                ],

                [
                    'attribute' => 'contact_number',
                    'label' => 'Contact Number',
                ],

                // [
                //     'attribute' => 'status',
                //     'label' => 'STATUS',
                // ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{preview}{history}{amend}{remove}{status}',
                    'buttons' => [
                        'preview' => function ($url, $model) {
                            return Html::a(' <span class="icon-eye-open"> VIEW INFO. </span> ', $url, [
                                        'title' => Yii::t('app', 'Preview'),
                            ]);
                        },
                        'amend' => function ($url, $model) {
                            return Html::a(' <span class="icon-copy"> UPDATE INFO. </span> ', $url, [
                                        'title' => Yii::t('app', 'Amend'),
                            ]);
                        },
                        'remove' => function ($url, $model) {
                            return Html::a(' <span class="icon-trash"> DELETE INFO? </span> ', $url, ['onclick' => 'return confirmation()',
                                        'title' => Yii::t('app', 'Remove'),
                                        'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                        // 'data-method' => 'post',
                            ]);
                        },
                        // 'status' => function ($url, $model) {
                        //     return Html::a(' <span class="icon-trash btn btn-default"> Change Status </span> ', $url, [
                        //                 'title' => Yii::t('app', 'Status'),
                        //         ]);
                        // }
                        // 'history' => function ($url, $model) {
                        //     return Html::a(' <span class="glyphicon glyphicon glyphicon-time"></span> ', $url, [
                        //                 'title' => Yii::t('app', 'History'),
                        //     ]);
                        // },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'preview') {
                            $url ='?r=supplier/view&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'amend') {
                            $url ='?r=supplier/update&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'remove') {
                            $url ='?r=supplier/delete-column&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'history') {
                            $url ='?r=supplier/history&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'status') {
                            $url ='?r=supplier/status&id='.$model->id;
                            return $url;
                        }
                    }
                ],
               ] 
         ?>

        <?php

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => $gridColumns,
                // 'showFooter'=>true,
            ]);
        ?>

        <br/>
    </div>
</div>
<br/>


