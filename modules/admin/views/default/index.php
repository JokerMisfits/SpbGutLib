<?php
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $access */
/* @var $task */
/* @var $books */
/* @var $people */
/* @var $tasks */
?>
<style>
    .admin-default-index-profile{
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 0!important;
        padding-bottom: 0!important;
    }
    .admin-default-index{
        margin-top: -20px!important;
        margin-bottom: 0 !important;
        padding-bottom: 0!important;
        background-color: #eee;
    }
    .admin-default-index-sidebar-content{
        margin-top: 70px;
        margin-bottom: 0!important;
        padding-bottom: 0!important;
        font-size: 18px;
    }
    .admin-default-index-stats-content{
        margin-bottom: 0!important;
        padding-bottom: 0!important;
    }
    .admin-default-index-stats{
        border-left: 1px solid black;
    }
</style>
<div class="admin-default-index col-xs-12" >
    <div class="admin-default-index-profile col-xs-3 text-center" >
        <div class="admin-default-index-sidebar-content">
            <p><?= Yii::$app->user->identity->surname . ' ' . Yii::$app->user->identity->name . ' ' . Yii::$app->user->identity->middle_name ?></p>
            <p>
                <?php
                    if($access == 'Administrator'){
                        echo 'Уровень доступа:  ' . '<span class="text-danger">' . $access . '</span>';
                    }
                    elseif($access == 'Moderator'){
                        echo 'Уровень доступа:  ' . '<span class="text-success">' . $access . '</span>';
                    }
                    elseif($access == 'Professor'){
                        echo 'Уровень доступа:  ' . '<span class="text-warning">' . $access . '</span>';
                    }
                    else{
                        echo 'Уровень доступа:  ' . '<span class="text-primary">' . $access . '</span>';
                    }
                ?>
            </p>
            <p>
                <?php
                    if($task > 0 && Yii::$app->user->identity->access_level >= 50){
                        echo Html::a(Html::encode('Ваши активные заявки: '.$task), Url::to(['books-history/', 'BooksHistorySearch[user_id]' => Yii::$app->user->identity->parent_id,'BooksHistorySearch[active]' => 1]));
                    }
                ?>
            </p>
        </div>

    </div>
    <div class="admin-default-index-stats col-xs-9 text-center">
        <div class="admin-default-index-stats-content">
                <div class="jumbotron">
                    <h1>Статистика сервиса</h1>
                    <p>Этот сервис сделан для демонстрации функционала, весь дизайн может быть изменен</p>
                    <p><?= 'Количество книг: '.$books ?></p>
                    <?php
                        if(Yii::$app->user->identity->access_level >= 50){
                            echo '<p>Количество пользователей: '.$people.'</p>';
                            echo '<p>Количество заявок: '.$tasks.'</p>';
                        }
                    ?>
                </div>
        </div>

    </div>
</div>
