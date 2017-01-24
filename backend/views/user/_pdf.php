<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table class="pdfTable" >
		<thead>
			<tr>
				<td class="pdf_number" > # </td>
				<td class="pdf_headBg" > Branch </td>
				<td class="pdf_headBg" > Role </td>
				<td class="pdf_headBg" > Fullname </td>
				<td class="pdf_headBg" > Username </td>
				<td class="pdf_headBg" > Email </td>
				<td class="pdf_headBg" > Status </td>
				<td class="pdf_headBg" > Date Created </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['role']; ?></td>
				<td><?php echo $row['fullname']; ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td><?php echo ( $row['status'] == 1 )?'Active':'Inactive'; ?></td>
				<td><?php echo $row['created_at']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>