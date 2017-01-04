<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table border="1" >
		<thead>
			<tr >
				<td style="background: #eee; text-align: center;" > # </td>
				<td style=" background: #eee;" > Supplier Code </td>
				<td style=" background: #eee;" > Supplier Name </td>
				<td style=" background: #eee;" > Address </td>
				<td style=" background: #eee;" > Contact Number </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr >
				<td ><?php echo $row['id']; ?></td>
				<td ><?php echo $row['supplier_code']; ?></td>
				<td ><?php echo $row['supplier_name']; ?></td>
				<td ><?php echo $row['address']; ?></td>
				<td ><?php echo $row['contact_number']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

