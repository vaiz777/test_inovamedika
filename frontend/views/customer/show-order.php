<?php

use yii\helpers\Html;
use yii\widgets\ListView;


$this->title = 'Customers';
$this->params['breadcumbs'][] = $this->title;


?>

<div class="customer-index">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php 
		foreach ($models1 as $mod) {
			
			echo "<div class='col-lg-12'>
					<p>Nama Pelanggan : ".$mod['nama']."</p>
					<p>Id Beli : ".$mod['id']."</p>";

					foreach ($models2 as $mod2 ) {
						if ($mod1['id'] == $mod['order_id']) {
							echo "<p>Item yang dibeli :".$mod2['name']." </p>";
						}
					}
					echo "</div>";
		}

	 ?>
</div>