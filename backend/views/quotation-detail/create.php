<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\QuotationDetail */

$this->title = 'Create Quotation Detail';
$this->params['breadcrumbs'][] = ['label' => 'Quotation Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
