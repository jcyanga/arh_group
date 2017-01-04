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
				<td style=" background: #eee;" > Parts-Category </td>
				<td style=" background: #eee;" > Product Code </td>
				<td style=" background: #eee;" > Product Name </td>
				<td style=" background: #eee;" > Unit of Measure </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr >
				<td ><?php echo $row['id']; ?></td>
				<td ><?php echo $row['category']; ?></td>
				<td ><?php echo $row['product_code']; ?></td>
				<td ><?php echo $row['product_name']; ?></td>
				<td ><?php echo $row['unit_of_measure']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

