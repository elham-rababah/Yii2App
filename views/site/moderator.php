<?php

/* @var $this yii\web\View */
//https://stackoverflow.com/questions/22838511/bulk-action-in-yii-grid-view
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;



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
         [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'Action', 
            'headerOptions' => ['width' => '80'],
            'template' => '{approve} {reject}',
            'buttons' => [
                'approve' => function ($url,$model) {
                    return Html::a(
                        '<span 
                        	onclick="approveAction()"
                        	title="approve"
                        	class="glyphicon
                        	glyphicon-thumbs-up">
                       	</span>', 
                       	$url);
                },
                'reject' => function ($url,$model,$key) {
                    return Html::a(
                    	'<span 
                    		onclick="rejectAction()"
                    		title="reject" 
                    		class="glyphicon
                    		glyphicon-thumbs-down">
                    		</span>',
                    		 $url);
                },
	        ],
        ],
    ],
    ]);
    ?>
</div>
<script>
    function approveAction() {
        window.location.href='<?php echo Url::to(['SiteController/actionApprove']); ?>';

    }
    function rejectAction() {
        window.location.href='<?php echo Url::to(['SiteController/actionReject']); ?>';

    }
</script>
