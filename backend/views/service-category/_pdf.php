<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table class="table table-striped">
		<thead>
			<tr>
				<td>NAME</td>
				<td>DESCRIPTION</td>
				<td>DATE CREATED</td>
				<td>STATUS</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['description']; ?></td>
				<td><?php echo date('m-d-Y', strtotime($row['created_at']) ); ?></td>
				<td><?php echo ( $row['status'] == 1 ) ? 'Active' : 'Inactive'; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>