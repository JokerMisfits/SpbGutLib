<?php
/* @var $access */
/* @var $task */
/* @var $books */
/* @var $people */
/* @var $tasks */
/* @var $depart */
/* @var $email */
/* @var $pass */
/* @var $username */
/* @var $comment */
/* @var $categories */
/* @var $subjects */
/* @var $registration */
/* @var $status */
/* @var $online */
?>

<style>
@import "../../../../web/css/profile.css";
</style>

<script>
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
</script>

<div class="wrapper">

    <nav id="sidebar">
        <div class="sidebar-header text-center">
            <h3><?= Yii::$app->user->identity->surname . ' ' . Yii::$app->user->identity->name?></h3>
        </div>

        <ul class="list-unstyled components">
            <p class="sidebar-text">
                <?php
                if($access == 'Administrator'){
                    echo 'Уровень доступа:' . '<span class="text-danger pull-right">' . $access . '</span>';
                }
                elseif($access == 'Moderator'){
                    echo 'Уровень доступа:' . '<span class="text-success pull-right">' . $access . '</span>';
                }
                elseif($access == 'Professor'){
                    echo 'Уровень доступа:' . '<span class="text-warning pull-right">' . $access . '</span>';
                }
                else{
                    echo 'Уровень доступа:' . '<span class="text-primary pull-right">' . $access . '</span>';
                }
                ?>
            </p>
            <li class="active">
                <a href="/admin">Профиль</a>
            </li>
            <li>
                <a href="#">Статистика<span class="text-danger">(В разработке)</span></a>
            </li>
            <li>
                <a href="#">Настройки<span class="text-danger">(В разработке)</span></a>
            </li>
            <li>
                <a href="#">Поддержка<span class="text-danger">(В разработке)</span></a>
            </li>
                        <li>
                            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Сервисы<span class="text-danger">(В разработке)</span></a>
                            <ul class="collapse list-unstyled" id="pageSubmenuDELETEME"> <!-- DELETE DELETEME!! -->
                                <li>
                                    <a href="#">Сменить пароль<span class="text-danger">(В разработке)</span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="text-danger">(В разработке)</span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="text-danger">(В разработке)</span></a>
                                </li>
                            </ul>
                        </li>
        </ul>
    </nav>

    <!-- Page Toggle -->
    <div id="content" class="col-xs-1 page-toggle-container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-toggle btn-toggle-color" style="color: #6d7fcc;background-color: #0e1c3e;">
                        <span class="text-toggle">Свернуть</span>
                    </button>

                </div>
            </nav>
    </div>
    <!-- Page Toggle End -->

    <!-- Page Content -->
    <div class="container-fluid col-xs-12 text-center content">
        <div class="row">
            <div class="col-xs-12 col-lg-4 profile-image-container">
                    <img class="container-fluid col-xs-12 profile-image " src="../../../../web/images/logo_sut.png" alt="" title="SutLogo">
            </div>
            <div class="col-xs-12 col-lg-8 profile-info-container">
                <div class="row">
                    <div class="col-xs-12 profile-info-full-name">
                        <h1><?= Yii::$app->user->identity->surname . ' ' . Yii::$app->user->identity->name . ' ' . Yii::$app->user->identity->middle_name ?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12 col-lg-6 profile-info-container-personal-popup">
                                Здесь будут отображаться ваши персональные уведомления<br>
                                <b class="text-danger">(В разработке)</b>

                            </div>
                            <div class="col-xs-12 col-lg-6 profile-info-container-personal-admin">
                                Функционал только для администрации<br>
                                <b class="text-danger">(В разработке)</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-4 text-justify profile-info-basic">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h3>Общая информация</h3>
                            <hr class="my-4">
                        </div>
                        <div class="col-xs-12">
                            Кафедра: <?= $depart ?>
                        </div>
                        <div class="col-xs-12">
                            Номер удостоверения: <?= $pass ?>
                        </div>
                        <div class="col-xs-12">
                            Email: <?= $email ?>
                        </div>
                        <div class="col-xs-12">
                            Имя пользователя: <?= $username ?>
                        </div>
                        <div class="col-xs-12">
                            Дата регистрации: <?php echo date("d.m.Y H:i:s",$registration); ?>
                        </div>
                        <div class="col-xs-12">
                            Последняя активность: <?= $status ?>
                        </div>
                    </div>

            </div>
            <div class="col-xs-12 col-lg-8 text-justify profile-info-manage-container">
                <div class="row">
                    <div class="col-xs-12 col-lg-6 profile-info-manage">
                        <div class="row">
                               <div class="col-xs-12 text-center">
                                   <h3>Управление профилем</h3>
                                   <hr class="my-4">
                               </div>
                               <div class="col-xs-12 text-center">
                                   <b class="text-danger">(В разработке)</b>
                               </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6 profile-info-manage-stats">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h3>Статистика сервиса</h3>
                                <hr class="my-4">
                            </div>
                            <div class="col-xs-12">
                                Количество книг: <?= $books ?>
                            </div>
                            <div class="col-xs-12">
                                Количество категорий книг: <?= $categories ?>
                            </div>
                            <div class="col-xs-12">
                                Количество тематик книг: <?= $subjects ?>
                            </div>
                            <div class="col-xs-12">
                                Количество пользователей: <?= $people ?>
                            </div>
                            <div class="col-xs-12">
                                Пользователей онлайн: <?= $online ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
















































<!--<style>-->
<!--    .admin-default-index-profile{-->
<!--        margin-left: auto;-->
<!--        margin-right: auto;-->
<!--        margin-bottom: 0!important;-->
<!--        padding-bottom: 0!important;-->
<!--    }-->
<!--    .admin-default-index{-->
<!--        margin-top: -20px!important;-->
<!--        margin-bottom: 0 !important;-->
<!--        padding-bottom: 0!important;-->
<!---->
<!--        background-color: #e1e0e0;-->
<!--    }-->
<!--    .admin-default-index-sidebar-content{-->
<!--        margin-top: 70px;-->
<!--        margin-bottom: 0!important;-->
<!--        padding-bottom: 0!important;-->
<!--        font-size: 18px;-->
<!---->
<!--    }-->
<!--    .admin-default-index-stats-content{-->
<!--        margin-bottom: 0!important;-->
<!--        padding-bottom: 0!important;-->
<!--    }-->
<!--    .admin-default-index-stats{-->
<!--        border-left: 1px solid black;-->
<!--    }-->
<!--</style>-->
<!--<div class="admin-default-index">-->
<!--    <div class="admin-default-index-profile col-xs-2" >-->
<!--        <div class="admin-default-index-sidebar-content">-->
<!--            <div class="row">-->
<!--                <div class="col-xs-8"> <p>Здравствуйте,<br>--><?//= Yii::$app->user->identity->surname . ' ' . Yii::$app->user->identity->name?><!--</p></div>-->
<!--                <div class="col-xs-4 text-center">ФОТО</div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-xs-12">-->
<!--                    <p>-->
<!--                        --><?php
//                        if($access == 'Administrator'){
//                            echo 'Уровень доступа:' . '<span class="text-danger pull-right">' . $access . '</span>';
//                        }
//                        elseif($access == 'Moderator'){
//                            echo 'Уровень доступа:' . '<span class="text-success pull-right">' . $access . '</span>';
//                        }
//                        elseif($access == 'Professor'){
//                            echo 'Уровень доступа:' . '<span class="text-warning pull-right">' . $access . '</span>';
//                        }
//                        else{
//                            echo 'Уровень доступа:' . '<span class="text-primary pull-right">' . $access . '</span>';
//                        }
//                        ?>
<!--                    </p>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <p>-->
<!--                --><?php
//                    if($task > 0 && Yii::$app->user->identity->access_level >= 50){
//                        echo Html::a(Html::encode('Ваши активные заявки: '.$task), Url::to(['books-history/', 'BooksHistorySearch[user_id]' => Yii::$app->user->identity->parent_id,'BooksHistorySearch[active]' => 1]));
//                    }
//                ?>
<!--            </p>-->
<!--        </div>-->
<!---->
<!--    </div>-->
<!--    <div class="admin-default-index-stats col-xs-10 text-center">-->
<!--        <div class="admin-default-index-stats-content">-->
<!--                <div class="jumbotron">-->
<!--                    <h1>Статистика сервиса</h1>-->
<!--                    <p>--><?//= 'Количество книг: '.$books ?><!--</p>-->
<!--                    --><?php
//                        if(Yii::$app->user->identity->access_level >= 50){
//                            echo '<p>Количество пользователей: '.$people.'</p>';
//                            echo '<p>Количество заявок: '.$tasks.'</p>';
//                        }
//                    ?>
<!--                </div>-->
<!--        </div>-->
<!---->
<!--    </div>-->
<!--</div>-->
