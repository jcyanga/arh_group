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

<div style="margin-top: 50px; border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; background-color: #fff;" class="row">
 
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
        <span style="color: #666;" class="form-header"><h4>Customer Maintenance</h4></span>
    </div>
    <hr/>

    <div class="form-search-container">    
      <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>   
 
 </div>

</div>
<br/>

<div style="border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; background-color: #fff;" class="row">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
  
    <div class="other-btns-container">
        <a class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New </b>
        </a>

        <a class="btn btn-app">
            <i class="fa fa-print"></i> <b> Print </b>
        </a>

        <p>
            <?= Html::a('<i class=\'icon-plus-sign\'></i> New Customer', ['create'], ['class' => 'form-btn btn btn-success']) ?>

            <?= Html::a('<i class=\'icon-print\'></i> Export Customer List', '?r=customer/status', ['onclick' => 'return print_confirmation()', 'class' => 'form-btn btn btn-warning']) ?>
    
            <?php echo str_repeat('&nbsp;', 5); ?>
        </p>
    </div>

    <div class="tbl-container">
        <?php
            
            $gridColumns =
             [

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{send}',
                    'buttons' => [
                        'send' => function ($url, $model) {
                            return Html::CheckBox('f_n',false, array (
                                        'value'=>'on',
                                        ));
                        },
                    ]
                ],

                [
                    'attribute' => 'fullname',
                    'label' => 'FULLNAME',
                ],

                [
                    'attribute' => 'address',
                    'label' => 'ADDRESS',
                ],
                
                
                [
                    'attribute' => 'hanphone_no',
                    'label' => 'CONTACT NUMBER',
                ],

                [
                    'attribute' => 'carplate',
                    'label' => 'CAR PLATE',
                ],

                // [
                //     'attribute' => 'status',
                //     'label' => 'STATUS',
                // ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{preview}{history}{amend}{remove}{rewards}',
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
                        'rewards' => function ($url, $model) {
                            return Html::a(' <span class="icon-edit"> REWARD POINTS! </span> ', $url, [
                                        'title' => Yii::t('app', 'Rewards'),
                                ]);
                        }
                        // 'status' => function ($url, $model) {
                        //     return Html::a(' <span class="icon-copy"> Change Status </span> ', $url, [
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
                            $url ='?r=customer/view&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'amend') {
                            $url ='?r=customer/update&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'remove') {
                            $url ='?r=customer/delete-column&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'history') {
                            $url ='?r=customer/history&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'status') {
                            $url ='?r=customer/status&id='.$model->id;
                            return $url;
                        }
                        if($action === 'rewards') {
                            $url ='?r=customer/rewards&id='.$model->id;
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

        <div>
            <p><span style="font-weight: bold; font-size: 11px;">(Check a record you want to send an e-mail)</span></p>
            <p><?= Html::a('<i class=\'icon-envelope-alt\'></i> Send E-mail', ['send'], ['class' => 'form-btn btn btn-info']) ?></p>
        </div>
        <br/><br/>

    </div>   
 
 </div>

</div>
<br/>



<div style="margin-top: 50px; border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; background-color: #fff;" class="row">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
  
  <div class="dashboard_graph">

     <div class="row x_title">
   
      <div class="col-md-12">     
        
        <div>
            <?php if($msg <> ''){ ?>
                <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
                <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
                    <?php echo $msg; ?>
                </div>
            <?php } ?>
        </div>

        <div class="form-title-container">
            <span style="color: #666;" class="form-header"><h4>Customer Maintenance</h4></span>
        </div>      
    
      </div>

     </div>

    </div>

    <div class="col-md-9 col-sm-9 col-xs-12">
        <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
        <div style="width: 100%;">
            <div id="canvas_dahs" class="demo-placeholder" style="width: 100%; height:270px;"></div>
        </div>
    </div>
    
    <div class="col-md-9 col-sm-9 col-xs-12">
         <div class="form-search-container">    
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>         
    </div>


    <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
        <div class="x_title">
            <h2>Top Campaign Performance</h2>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-6">
            <div>
                <p>Facebook Campaign</p>
                <div class="">
                    <div class="progress progress_sm" style="width: 76%;">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>
                    </div>
                </div>
            </div>
            <div>
                <p>Twitter Campaign</p>
                <div class="">
                    <div class="progress progress_sm" style="width: 76%;">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-6">
            <div>
                <p>Conventional Media</p>
                <div class="">
                    <div class="progress progress_sm" style="width: 76%;">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                    </div>
                </div>
            </div>
            <div>
                <p>Bill boards</p>
                <div class="">
                    <div class="progress progress_sm" style="width: 76%;">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="clearfix"></div>
  
  </div>
 
 </div>

</div>
<br/>

<div class="form-container customer-index">


    
    

   
    <hr/><br/><br/>

    <div class="other-btns-container">
        <p>
            <?= Html::a('<i class=\'icon-plus-sign\'></i> New Customer', ['create'], ['class' => 'form-btn btn btn-success']) ?>

            <?= Html::a('<i class=\'icon-print\'></i> Export Customer List', '?r=customer/status', ['onclick' => 'return print_confirmation()', 'class' => 'form-btn btn btn-warning']) ?>
    
            <?php echo str_repeat('&nbsp;', 5); ?>
        </p>
    </div>

    <div class="tbl-container">
        <?php
            
            $gridColumns =
             [

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{send}',
                    'buttons' => [
                        'send' => function ($url, $model) {
                            return Html::CheckBox('f_n',false, array (
                                        'value'=>'on',
                                        ));
                        },
                    ]
                ],

                [
                    'attribute' => 'fullname',
                    'label' => 'FULLNAME',
                ],

                [
                    'attribute' => 'address',
                    'label' => 'ADDRESS',
                ],
                
                
                [
                    'attribute' => 'hanphone_no',
                    'label' => 'CONTACT NUMBER',
                ],

                [
                    'attribute' => 'carplate',
                    'label' => 'CAR PLATE',
                ],

                // [
                //     'attribute' => 'status',
                //     'label' => 'STATUS',
                // ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{preview}{history}{amend}{remove}{rewards}',
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
                        'rewards' => function ($url, $model) {
                            return Html::a(' <span class="icon-edit"> REWARD POINTS! </span> ', $url, [
                                        'title' => Yii::t('app', 'Rewards'),
                                ]);
                        }
                        // 'status' => function ($url, $model) {
                        //     return Html::a(' <span class="icon-copy"> Change Status </span> ', $url, [
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
                            $url ='?r=customer/view&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'amend') {
                            $url ='?r=customer/update&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'remove') {
                            $url ='?r=customer/delete-column&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'history') {
                            $url ='?r=customer/history&id='.$model->id;
                            return $url;
                        }
                        if ($action === 'status') {
                            $url ='?r=customer/status&id='.$model->id;
                            return $url;
                        }
                        if($action === 'rewards') {
                            $url ='?r=customer/rewards&id='.$model->id;
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

        <div>
            <p><span style="font-weight: bold; font-size: 11px;">(Check a record you want to send an e-mail)</span></p>
            <p><?= Html::a('<i class=\'icon-envelope-alt\'></i> Send E-mail', ['send'], ['class' => 'form-btn btn btn-info']) ?></p>
        </div>
        <br/><br/>

    </div>
</div>
<br/>

