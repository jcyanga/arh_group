<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\QuotationSubtotal */

$this->title = 'Create Quotation Subtotal';
$this->params['breadcrumbs'][] = ['label' => 'Quotation Subtotals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-subtotal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
