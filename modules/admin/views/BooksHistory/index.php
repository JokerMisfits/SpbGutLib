<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BooksHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Books History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'book_id',
            'user_id',
            'date',
            'date_end',
            //'comment:ntext',
            //'active',
            //'count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
