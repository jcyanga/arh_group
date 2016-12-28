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
				<td>ROLE</td>
				<td>FULLNAME</td>
				<td>USERNAME</td>
				<td>EMAIL</td>
				<td>STATUS</td>
				<td>DATE CREATED</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
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