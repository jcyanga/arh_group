<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table border="1" >
		<thead>
			<tr>
				<td style="background: #eee; text-align: center;" > # </td>
				<td style=" background: #eee;" > Branch </td>
				<td style=" background: #eee;" > Role </td>
				<td style=" background: #eee;" > Fullname </td>
				<td style=" background: #eee;" > username </td>
				<td style=" background: #eee;" > email </td>
				<td style=" background: #eee;" > Status </td>
				<td style=" background: #eee;" > Date Created </td>
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
				<td><?php echo $row['status']; ?></td>
				<td><?php echo $row['created_at']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>