<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Role';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-container role-view">
    
    <div class="form-title-container">
        <span class="form-header"><h4>View Role Information</h4></span>
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
            'role',
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

    
