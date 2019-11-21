<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PesananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pesanan Anda';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pesanan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('CheckOut', ['checkout'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Clear', ['clear'], ['class' => 'btn btn-primary']) ?>


    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'date',
            //'customer_id',
            'name',
            'price',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
