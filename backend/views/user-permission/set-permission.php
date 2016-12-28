<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create User Permission';
// $this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];

?>

<div class="row form-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span style="color: #666;" class="form-header"><h4>Create User Permission</h4></span>
    </div>

  </div>
 <hr/>

<?php $form = ActiveForm::begin(['class' => 'form-inline']); ?>
	
<div class="search-label-container">
    &nbsp;
    <span class="search-label"><li class="fa fa-edit"></li> User Permission Information.</span>
</div>
<br/>

<div class="col-md-4">
    <label style="font-size: 12px;">Controller List</label>
    <select id="controllerName" name="controllerName" class="form-control">
    	<option vale="0">Please select</option>
    	<?php foreach ( $controllerList as $cName => $cL ) {  ?>
    		<?php  $selected = $controllerNameChosen == $cName ?  'selected' : ''?>
    		<option <?= $selected ?>><?= $cName ?></option>
		<?php } ?>
		</select>
</div>

<div class="col-md-4">
	<label style="font-size: 12px;">Role List</label>
    <select id="userRole" name="userRole" class="form-control">
			<option vale="0">Please select</option>
			<?php foreach ( $userRole as $uR ) { ?>
				<?php  $selected = $userRoleId == $uR->id ?  'selected' : ''?>
				<option value="<?= $uR->id ?>" <?= $selected ?>><?= $uR->role ?></option>
			<?php } /* foreach */ ?>
		</select>
</div>

<div class="col-md-4"></div>

<?php ActiveForm::end(); ?>

<br/><br/><br/>
<hr/>

<div class="col-md-4">

<?php $form = ActiveForm::begin(); ?>

	<input type="hidden" name="controllerName" value="<?= $controllerNameLong ?>">
	<input type="hidden" name="controllerNameChosen" value="<?= $controllerNameChosen ?>">
	<input type="hidden" name="userRole" value="<?= $userRoleId ?>">
	<?php if ( $controllerActions ) {  ?>

		<?php 
			foreach ( $controllerActions as $cA ) { ?>
			<?php 
			/* if within the permission table */
			$checked = '';
			if ( in_array($cA, $permission, true) ){
				$checked = 'checked';
			}

			?>
			<input type="checkbox" name="checkBox[<?= $cA ?>]" <?= $checked ?> > <?= $cA ?> <br>
		<?php } /* foreach */ ?>
	<input type="hidden" name="controllerNameChosen" value="<?= $controllerNameChosen ?>">
	<div class=" col-sm-12 text-right">
	    <div class="form-group">
			<input type="button" id="select-all" value="Select All" class="btn btn-success">
	        <?= Html::submitButton('<i class=\'fa fa-save\'></i> Save', ['class' => 'btn btn-primary']) ?>
	    </div>
    </div>
	<?php } /* if */ ?>

<?php ActiveForm::end(); ?>

</div>

 <br/>
</div>




