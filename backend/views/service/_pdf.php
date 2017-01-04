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
				<td style=" background: #eee;" > Service Category </td>
				<td style=" background: #eee;" > Service Name </td>
				<td style=" background: #eee;" > Description </td>
				<td style=" background: #eee;" > Default Price </td>
				<td style=" background: #eee;" > Date Created </td>
				<td style=" background: #eee;" > Status </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['service_name']; ?></td>
				<td><?php echo $row['description']; ?></td>
				<td><?php echo $row['default_price']; ?></td>
				<td><?php echo date('m-d-Y', strtotime($row['created_at']) ); ?></td>
				<td><?php echo ( $row['status'] == 1 ) ? 'Active' : 'Inactive'; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>