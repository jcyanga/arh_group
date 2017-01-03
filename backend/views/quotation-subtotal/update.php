<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\QuotationSubtotal */

$this->title = 'Update Quotation Subtotal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Quotation Subtotals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quotation-subtotal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
