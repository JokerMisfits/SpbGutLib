<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksHistory */
/* @var $book */

    $this->title = $book;
    yii\web\YiiAsset::register($this);

    $access = 0;
    if(isset(Yii::$app->user->identity->access_level)){
        $access = Yii::$app->user->identity->access_level;
    }

?>

<style>body{margin-top: 50px;}</style>

<div class="books-history-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php

        if($access == 50){
            echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }
        elseif($access == 100){
            echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::a('Удалить запись', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить данную запись?',
                    'method' => 'post',
                ],
            ]);
        }

        ?>
        <?= Html::a( 'Назад', '/admin/books-history', ['class' => 'btn btn-warning']); ?>
    </p>

    <?php try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'book_id',
                    'value' => function ($data){
                        return $data->book;
                    },
                ],
                [
                    'attribute' => 'user_id',
                    'value' => function ($data) {
                        return Html::a(Html::encode('Ссылка пользователя'), Url::to(['people/', 'PeopleSearch[id]' => $data->user_id]));
                    },
                    'format' => 'raw',
                ],
                'date_from',
                'date_end',
                'comment',
                'count',
                [
                    'attribute' => 'active',
                    'value' => function ($data){
                        if($data->active == 1){
                            $options = ['style' => ['color' => 'green']];
                            return Html::tag('span', Html::encode('Да'), $options);
                        }
                        else{
                            $options = ['style' => ['color' => 'red']];
                            return Html::tag('span', Html::encode('Нет'), $options);
                        }
                    },
                    'format' => 'raw',
                ],
            ],
        ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error',$exception->getMessage());
    }?>

</div>
