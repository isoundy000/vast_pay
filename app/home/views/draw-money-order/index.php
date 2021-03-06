<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\DrawMoneyOrder;
use common\helper\Helper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DrawMoneyOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '提款订单列表');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="draw-money-index" >
    <h1 ><?= $this->title; ?></h1>
    <div class="box-tools">
        <?= Html::a('导出订单excel', ['export',Yii::$app->request->queryParams], ['class' => 'btn btn-primary']) ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'sys_order_id',
            'account_name',
            'account_number',
            [
                'attribute'=>'receipt_number',
                'value' => function($data) {
                    return $data->receipt_number == ''?null : $data->receipt_number;
                },
            ],

            [
                'attribute'=>'money',
                'value' => function($data) {
                    return Helper::formatMoney($data->money);
                },
            ],
            [
                'attribute'=>'status',
                'value' => function($data){
                    return DrawMoneyOrder::enumState('status', $data->status);
                },
                'filter' => DrawMoneyOrder::enumState('status'),
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'filterType' =>GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'filterType' =>GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
            ],
            [
                'attribute' => 'success_at',
                'value' => function($data) {
                    return $data->receipt_number == ''?null : $data->receipt_number;
                },
                'filterType' =>GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=> Yii::$app->params['filterDateRangeOptions'],
            ],
            [
                'header' => "操作",
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>

</div>
