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
				<td>SUPPLIER CODE</td>
				<td>SUPPLIER NAME</td>
				<td>ADDRESS</td>
				<td>CONTACT NUMBER</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['supplier_code']; ?></td>
				<td><?php echo $row['supplier_name']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['contact_number']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>