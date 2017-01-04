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
				<td style=" background: #eee;" > Product Code </td>
				<td style=" background: #eee;" > Product Name </td>
				<td style=" background: #eee;" > Quantity </td>
				<td style=" background: #eee;" > Cost Price </td>
				<td style=" background: #eee;" > Selling Price </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr >
				<td ><?php echo $row['id']; ?></td>
				<td ><?php echo $row['supplier_code']; ?></td>
				<td ><?php echo $row['supplier_name']; ?></td>
				<td ><?php echo $row['product_code']; ?></td>
				<td ><?php echo $row['product_name']; ?></td>
				<td ><?php echo $row['quantity']; ?></td>
				<td ><?php echo $row['cost_price']; ?></td>
				<td ><?php echo $row['selling_price']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

