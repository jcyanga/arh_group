<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\Branch;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$member_list = array('0' => 'No', '1' => 'Yes');

$datetime = date('Y-m-d h:i:s');

$userId = Yii::$app->user->identity->id;

$dataRole = ArrayHelper::map(Role::find()->where('id > 1')->all(), 'id', 'role');
$dataBranch = ArrayHelper::map(Branch::find()->all(), 'id', 'name');
?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> User Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label style="font-size: 12px;">User Role</label>
        <?= $form->field($model, 'role_id')->dropDownList($dataRole)->label(false) ?>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    
    <br/>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label style="font-size: 12px;">User Branch</label>
        <?= $form->field($model, 'branch_id')->dropDownList($dataBranch)->label(false) ?>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    
    <br/>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label style="font-size: 12px;">Fullname</label>
        <?= $form->field($model, 'fullname')->textInput(['required' => 'required', 'placeholder' => 'Fullname here...'])->label(false) ?>
    </div>
    <div class="col-md-3">
        <label style="font-size: 12px;">E-mail</label>
        <?= $form->field($model, 'email')->textInput(['required' => 'required', 'placeholder' => 'E-mail here...'])->label(false) ?>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    
    <br/>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label style="font-size: 12px;">Username</label>
        <?= $form->field($model, 'username')->textInput(['required' => 'required', 'placeholder' => 'Username here...'])->label(false) ?>
    </div>
    <div class="col-md-3">
        <label style="font-size: 12px;">Password</label>
        <?= $form->field($model, 'password')->passwordInput(['required' => 'required', 'placeholder' => 'Password here...'])->label(false) ?>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>

</div>
<hr/>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Update Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>
    
    <div class="col-md-4"></div>

    <div class="col-md-4"></div>

</div>
<br/><br/>

<?php ActiveForm::end(); ?>









