<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TransferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transfers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-index">

    <h1><?= Html::encode($this->title) ?>
        <small>
            your balance is:
            <?=Yii::$app->formatter->asCurrency(Yii::$app->user->identity->getBalance())?>
        </small></h1>

    <p>
        <?= Html::a('Send money', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'sender_id',
                'format' => 'raw',
                'value' => function (\app\models\Transfer $model) {
                    return $model->sender->username;
                },
                'filter' => false
            ],
            [
                'attribute' => 'recipient_id',
                'format' => 'raw',
                'value' => function (\app\models\Transfer $model) {
                    return $model->recipient->username;
                },
                'filter' => false
            ],
            'amount',
            'create_date',
        ],
    ]); ?>
</div>
