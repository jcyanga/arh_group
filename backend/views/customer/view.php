<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-container customer-view">
    
    <div class="form-title-container">
        <span class="form-header"><h4>View Customer Information</h4></span>
    </div>      
    <hr/>
    
    <div>
        <p>
            &nbsp;
            <?= Html::button('<i class=\'icon-arrow-left\'></i> Back to Previous Page', ['name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','class'=>'uibutton loading confirm form-btn btn btn-default ']) ?>
        </p>
    </div>
    <br/>

    <div class="tbl-container">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fullname',
            'race',
            'carplate',
            'address:ntext',
            'hanphone_no',
            'office_no',
            'email:email',
            'make',
            'model',
            'tyre_size',
            'batteries',
            'belt',
            'is_blacklist',
            'is_member',
            'points',
            'member_expiry',
            'status',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
        ],
        ]) ?>
        <br/>
    </div>
</div>
<br/>

<!-- <div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fullname',
            'race',
            'carplate',
            'address:ntext',
            'hanphone_no',
            'office_no',
            'email:email',
            'make',
            'model',
            'tyre_size',
            'batteries',
            'belt',
            'is_blacklist',
            'is_member',
            'points',
            'member_expiry',
            'status',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
        ],
    ]) ?>

</div> -->
