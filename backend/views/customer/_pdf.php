<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table class="pdfTable" >
		<thead>
			<tr>
				<td class="pdf_headBg" > Fullname </td>
				<td class="pdf_headBg" > Address </td>
				<td class="pdf_headBg" > Contact Number </td>
				<td class="pdf_headBg" > Car Model </td>
				<td class="pdf_headBg" > Car-Plate </td>
				<td class="pdf_headBg" > Expiry Date </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['fullname']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['hanphone_no']; ?></td>
				<td><?php echo $row['model']; ?></td>
				<td><?php echo $row['carplate']; ?></td>
				<td><?php echo date('m-d-Y', strtotime($row['member_expiry'])); ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>