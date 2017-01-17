<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table class="table table-striped">
		<thead>
			<tr>
				<td class="pdf_headBg" > Fullname </td>
				<td class="pdf_headBg" > Address </td>
				<td class="pdf_headBg" > Model </td>
				<td class="pdf_headBg" > Car-Plate </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['fullname']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['model']; ?></td>
				<td><?php echo $row['carplate']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>