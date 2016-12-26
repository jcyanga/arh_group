<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];

?>

<div class="form-container product-create">

<?php if($msg <> ''){ ?>
    <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
          <?php echo $msg; ?>
    </div>
<?php } ?>

    <div class="form-title-container">
        <span class="form-header"><h4>Create Product</h4></span>
    </div>      
    <hr/>
    
    <div>
        <p>
            &nbsp;
            <?= Html::button('<i class=\'icon-arrow-left\'></i> Back to Previous Page', ['name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','class'=>'uibutton loading confirm form-btn btn btn-default ']) ?>
        </p>
    </div>
    <br/>

    <div class="form-crud-container">
        <?= $this->render('_form', ['model' => $model,]) ?>
    </div>
</div>

<!-- <div class="user-create">

   <h3>
    Create User -->
    <!-- <?= Html::encode($this->title) ?> -->      
    <!-- </h3>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> -->

