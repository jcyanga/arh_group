<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Gst */

$this->title = 'Create Gst';
$this->params['breadcrumbs'][] = ['label' => 'Gsts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gst-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
