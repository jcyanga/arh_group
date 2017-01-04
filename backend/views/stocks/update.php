<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Inventory;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventories';

?>

<div class="row">
 	<div class="col-md-12 col-sm-12 col-xs-12"><br/></div>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/>
 
 <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-database"></i> UPDATE PARTS STOCKS</h4></span>
 </div>
 <br/>

 <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b><i class="fa fa-sign-in"></i> Stock-In</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false"><b><i class="fa fa-sign-out"></i> Stock-Out</b></a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
    <br/>


    <?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

	<div class="row">

	    <div class="col-md-8">

	        <table style="border: solid 1px #eee;" class="table table-hover table-striped" >
	        	<thead>
	        		<tr>
	        			<td style="font-weight: bold;"><i class="fa fa-cogs"></i> PARTS NAME</td>
	        			<td style="text-align: center; font-weight: bold;"><i class="fa fa-upload"></i> ADDED STOCKS</td>
	        			<td style="text-align: center; font-weight: bold;"><i class="fa fa-database"></i> QUANTITY</td>
	        		</tr>
	        	</thead>
	        	<?php foreach($data as $key => $value): ?>
	        	<tr>
	        		<td>
	        			<label style="font-size: 12px; text-transform: uppercase; margin-top: 30px;"><?php echo $value['itemName']; ?></label>
	        		</td>
	        		<td>
	        			&nbsp;
	        			<input type="text" class="qtyValue form-control" value="" id="<?php echo $value['itemId']; ?>" >
	        		</td>
	        		<td>
	        			&nbsp;
	        			<input type="text" readonly="readonly" style="text-align: center;" class="qtyS form-control" value="<?php echo $value['itemQty']; ?>" id="<?php echo $value['itemId']; ?>" >
	        		</td>
	        	</tr>
	        	<?php endforeach; ?>	
	        </table>

	    </div>
	   
	</div>
	<hr/>

	<div class="row">

	    <div class="col-md-4">
	        <button type="submit" class="form-btn btn btn-info" > <i class="fa fa-save"></i> Save Record </button>
	        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
	    </div>
	    
	    <div class="col-md-4"></div>

	    <div class="col-md-4"></div>

	</div>
	<br/><br/>

	<?php ActiveForm::end(); ?>
    <br/>

    </div>
    
 
                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip</p>
                </div>
                
 
            </div>
        </div>

 </div>

</div>
<br/>




