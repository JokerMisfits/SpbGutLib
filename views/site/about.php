<?php

/* @var $this yii\web\View */
/* @var $admins */
use yii\helpers\Html;

$this->title = 'Инструкции';
$emailForm = 'ФИО(Полностью)<br>Номер пропуска<br>Email<br>Кафедра';

$close = '<svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <g stroke="none" stroke-width="1px" fill="none" fill-rule="evenodd" stroke-linecap="square">
        <g transform="translate(1.000000, 1.000000)" stroke="#222222">
            <path d="M0,11 L22,11"></path>
            <path d="M11,0 L11,22"></path>
        </g>
    </g>
</svg>';
?>
<script src="../../web/js/collapse.js"></script>
<style>
    .site-about{
        margin-top: 0px;
        font-size: 16px;
    }
    .text-link{
        max-width: 460px;
    }
    .mt-1{
        margin-top: -15px;
    }
    .mt-2{
        margin-top: -25px;
    }
</style>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>
<div class="site-about">
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer" href="#collapseOne_inner"> <div class="text-link"> Что нужно для регистрации? </div> <p id="icon"  class="pull-right icon mt-1"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseOne_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span class="text-green"> Аккаунт можно получить у администраторов сервиса ↓ </span><br>
                    <?php
                    $count = count($admins);
                    for ($i = 0;$i < $count;$i++){
                        echo $admins[$i]['surname'] . '&nbsp' . $admins[$i]['name'] . '&nbsp' . $admins[$i]['middle_name'] . '&nbsp' . '<br>' . '<span class="text-center text-info">' . '<a href="mailto:'.$admins[$i]['email'].'?subject=LitDB Запрос на аккаунт&body='.$emailForm.'">'. $admins[$i]['email'] . '</a>' . '</span>' . '<br>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer1"  href="#collapseTwo_inner"> <div class="text-link"> Как создать нового пользователя? </div> <p id="icon1" class="pull-right icon mt-1"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseTwo_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Профиль</span><br>
                    <span> 2.Выбираем пункт меню Users->Create </span><br>
                    <span> 3.Заполняем все поля </span><br>
                    <span> 4.Нажимаем сохранить </span><br>
                    <span> 5.Готово! </span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer2" href="#collapseThird_inner"> <div class="text-link"> Как добавить новую книгу? </div> <p id="icon2" class="pull-right icon mt-1"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseThird_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Профиль</span><br>
                    <span> 2.Выбираем пункт меню Books->Books</span><br>
                    <span> 2.Нажимаем кнопку "Добавить новую книгу"</span><br>
                    <span> 3.Заполняем все поля</span><br>
                    <span> 4.Нажимаем сохранить</span><br>
                    <span> 5.Готово! </span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer3" href="#collapseFourth_inner"> <div class="text-link"> Как добавить новую категорию? </div> <p id="icon3" class="pull-right icon mt-1"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseFourth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Профиль</span><br>
                    <span> 2.Выбираем пункт меню Books->Categories</span><br>
                    <span> 2.Нажимаем кнопку "Добавить новую категорию"</span><br>
                    <span> 3.Заполняем все поля</span><br>
                    <span> 4.Нажимаем сохранить</span><br>
                    <span> 5.Готово! </span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer4" href="#collapseFifth_inner"> <div class="text-link"> Как добавить новую тематику? </div> <p id="icon4" class="pull-right icon mt-1"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseFifth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Профиль</span><br>
                    <span> 2.Выбираем пункт меню Books->Subjects</span><br>
                    <span> 2.Нажимаем кнопку "Добавить новую тематику"</span><br>
                    <span> 3.Заполняем все поля</span><br>
                    <span> 4.Нажимаем сохранить</span><br>
                    <span> 5.Готово! </span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer5" href="#collapseSixth_inner"> <div class="text-link"> Как добавить новую запись? </div> <p id="icon5" class="pull-right icon mt-1"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseSixth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Профиль</span><br>
                    <span> 2.Выбираем пункт меню Books->Tasks</span><br>
                    <span> 2.Нажимаем кнопку "Добавить новую запись"</span><br>
                    <span> 3.Заполняем все поля</span><br>
                    <span> 4.При начале ввода символов в выпадающий список активируется поиск</span><br>
                    <span> 5.Нажимаем сохранить</span><br>
                    <span> 6.Готово! </span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer6" href="#collapseSeventh_inner"> <div class="text-link"> Как удалить запись? </div> <p id="icon6" class="pull-right icon mt-1"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseSeventh_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку из которой нужно удалить запись</span><br>
                    <span> 2.Нажимаем иконку мусорного ведра</span><br>
                    <span> 3.Подтверждаем действие</span><br>
                    <span> 4.Готово! </span><br>
                    <span> 5.Удаление записи разрешено пользователям с уровнем доступа администратор! </span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer7" href="#collapseEighth_inner"> <div class="text-link"> Как закрыть заявку? </div> <p id="icon7" class="pull-right icon mt-1"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseEighth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Профиль</span><br>
                    <span> 2.Выбираем пункт меню Books->Tasks</span><br>
                    <span> 3.Нажимаем на ссылку "Закрыть заявку"</span><br>
                    <span> 4.Готово! </span><br>
                    <span> 5.Закрытие заявки возвращает то количество книг, которое было выдано! </span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer8" href="#collapseNinth_inner"> <div class="text-link"> Как изменить заявку если у вас<br>Уровень доступа "Модератор"? </div> <p id="icon8" class="pull-right icon mt-2"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseNinth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Профиль</span><br>
                    <span> 2.Выбираем пункт меню Books->Tasks</span><br>
                    <span> 3.Нажимаем на ссылку "Закрыть заявку"</span><br>
                    <span> 4.Нажимаем кнопку "Добавить новую запись"</span><br>
                    <span> 5.Заполняем все поля</span><br>
                    <span> 6.Нажимаем сохранить</span><br>
                    <span> 7.Готово! </span><br>
                    <span> 8.Закрытие заявки возвращает то количество книг, которое было выдано! </span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer9" href="#collapseTenth_inner"> <div class="text-link"> Чем отличается<br>Пользователь от аккаунта? </div> <p id="icon9" class="pull-right icon mt-2"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseTenth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Аккаунт создается для сотрудников, которые будут работать с данным сервисом</span><br>
                    <span> 2.Пользователь это клиент данного сервиса, которому предоставляют услуги</span><br>
                    <span> 3.К каждому аккаунту автоматически создается пользователь</span><br>
                    <span style="color: #f35c5c"> 4.Все данные, которые будут изменены в аккаунте, также будут автоматически изменены и в пользователе, и наоборот!</span><br>
                    <span class="text-red"> 5.Если удалить аккаунт, пользователь удалится автоматически, и наоборот!</span><br>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer10" href="#collapseEleven_inner"> <div class="text-link"> Как изменить запись? </div> <p id="icon10" class="pull-right icon mt-1"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseEleven_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку из которой нужно изменить запись</span><br>
                    <span> 2.Нажимаем иконку карандашика в нужной строчке записи</span><br>
                    <span> 3.Изменяем нужные поля</span><br>
                    <span> 3.Нажимаем сохранить</span><br>
                    <span> 4.Готово! </span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer11" href="#collapseTwelve_inner"> <div class="text-link"> Как посмотреть книги<br>Которые взял пользователь?</div> <p id="icon11" class="pull-right icon mt-2"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseTwelve_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Профиль</span><br>
                    <span> 2.Выбираем пункт меню Users->Read</span><br>
                    <span> 3.Находим нужного пользователя</span><br>
                    <span> 4.В колонке "Книги" если у него есть активные заявки на книги, будет доступна ссылка</span><br>
                    <span> 5.Переходим по данной ссылке</span><br>
                    <span> 6.Готово!</span><br>
                    <span> 7.Чтобы увидеть закрытые заявки измените фильтр "Активные" на "Все заявки"</span><br>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer12" href="#collapseThirteenth_inner"> <div class="text-link">Почему не получается удалить:<br>Категории,тематики или кафедры?</div> <p id="icon12" class="pull-right icon mt-2"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseThirteenth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.У вас недостаточно прав доступа</span><br>
                    <span> 2.Эта категория,тематика или кафедра, уже используется,вам нужно изменить данные параметр в тех записях в которой он присутствует и повторить попытку снова!</span>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer13" href="#collapseFourteenth_inner"> <div class="text-link"> Столкнулись с проблемами?<br>Свяжитесь с нами!</div> <p id="icon13" class="pull-right icon mt-2"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseFourteenth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Петрова Ольга Борисовна <span class="text-info"><a href="mailto:petromay@yandex.ru?subject=LitDB bug report&body=Опишите вашу проблему">petromay@yandex.ru</a></span></span><br>
                    <span> 2.Щецко Андрей Андреевич <span class="text-info"><a href="mailto:lpwalker87@mail.ru?subject=LitDB bug report&body=Опишите вашу проблему">lpwalker87@mail.ru</a></span></span>
                </div>
            </div>
        </div>

    </div>
</div>