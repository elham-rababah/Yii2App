<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Moderator';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
    	[
            'attribute' => 'Id',
            'format' => 'text',
            'label' => 'ID'
        ],
        [
            'attribute' => 'url',
            'format' => 'text',
            'label' => 'Image',
            'format'=>'raw',
            'value' => function ($imageUrl) {
                return Html::img(Yii::$app->thumbnailer->get($imageUrl->url));
            }
        ],
        [
            'attribute' => 'status',
            'format' => 'text',
            'label' => 'Status'
        ],
        [
            'attribute' => 'date',
            'format' => ['date', 'php:Y-m-d'],
            'label' => 'Created Date'
        ],
        // 'isactive',
        ['class' => 'yii\grid\ActionColumn'],
    ],
    ]);
    ?>
</div>
