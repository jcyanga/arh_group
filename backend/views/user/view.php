<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-container user-view">
    
    <div class="form-title-container">
        <span class="form-header"><h4>View User Information</h4></span>
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
            'user_group_id',
            'role',
            'username',
            'password',
            'password_hash',
            'password_reset_token',
            'email:email',
            'photo',
            'auth_key',
            'status',
            'login',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'deleted',
        ],
        ]) ?>
        <br/>
    </div>
</div>
<br/>
