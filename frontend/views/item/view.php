<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Item */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?php 
        if (Yii::$app->user->isGuest) {
            echo '<p>';
            echo '<div class="aler alert-danger" role="alert"></div>';
            echo Html::a('Login First', ['/site/login'], ['class' => 'btn btn-danger']);
            echo '</p>';
        }else{

             // if ($customer) {
             //    echo "<p>";
             //     echo Html::a('Add to Cart',['addtocart', 'id' => $model->id],['class' => 'btn btn-primary']);
             //     echo "</p>";
             // }
            echo '<p>';
            echo '<div class="aler alert-danger" role="alert">Create User First</div>';
            echo Html::a('Create Customer', ['/customer/create'], ['class' => 'btn btn-danger']);
            echo '</p>';
        }



         ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'price',
            'category_id',
        ],
    ]) ?>

</div>
