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
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/>
 </div>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/>
 
 <div class="form-title-container">
        <span class="form-header"><h4>PRODUCT STOCKS</h4></span>
 </div>
 <br/>

 <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b>Stock-In</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false"><b>Stock-out</b></a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
    <br/>


    <?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

	<div class="row">

	    <div class="search-label-container">
	        &nbsp;
	        <span class="search-label"><li class="fa fa-edit"></li> Item Information.</span>
	    </div>
	    <br/>

	    <div class="col-md-12">

	        <table>
	        	<?php foreach($data as $key => $value): ?>
	        	<tr>
	        		<td>
	        			<label style="font-size: 12px; text-transform: uppercase;"><?php echo $value['itemName']; ?></label>
	        		</td>
	        		<td>
	        			&nbsp;
	        			<input type="text" class="qtyValue form-control" id="<?php echo $value['itemId']; ?>" />
	        		</td>
	        		<td>
	        			&nbsp;
	        			<label style="font-size: 12px;"><?php echo $value['itemQty']; ?></label>
	        		</td>
	        	</tr>
	        	<tr><td><br/></td></tr>
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

<script>
	
	$(document).ready(function () {

		if( $('.qtyValue').length ) {
			$('.qtyValue').each(function(){

				$(this).change(function(){

					console.log( $(this).val() );

				});

			});
		
		}

	});
</script>>





