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
				<td style=" background: #eee;" > User-Role </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['role']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>