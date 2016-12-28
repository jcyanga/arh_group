<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table class="table table-striped">
		<thead>
			<tr>
				<td>ID</td>
				<td>MODULES</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['modules']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>