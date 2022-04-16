<?php

/* @var $this yii\web\View */
/* @var $admins */
use yii\helpers\Html;

$this->title = 'Инструкции';
$this->params['breadcrumbs'][] = $this->title;

$close = '<svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <g stroke="none" stroke-width="1px" fill="none" fill-rule="evenodd" stroke-linecap="square">
        <g transform="translate(1.000000, 1.000000)" stroke="#222222">
            <path d="M0,11 L22,11"></path>
            <path d="M11,0 L11,22"></path>
        </g>
    </g>
</svg>';
?>

<style>
    .site-about{
        margin-top: 25px;
        font-size: 16px;
    }
    .panel{
        margin-top: 1px;
        margin-bottom: 0;
    }
    .text-green{
        color: green;
    }
    .text-red{
        color: red;
    }
    .icon{
        transition-duration: 0.6s;
        transition-property: transform;
        transform: translateY(-20%);
        width: 24px;
        height: 24px;
    }
    .icon:hover{
        background-color: rgba(140, 129, 129, 0.2);
        border-radius: 50%;
    }
    .icon-active{
        transition-duration: 0.6s;
        transition-property: transform;
        transform: rotate(135deg);
        width: 24px;
        height: 24px;
    }
    .icon-active:hover{
        background-color: rgba(140, 129, 129, 0.2);
        border-radius: 50%;
    }
</style>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>
<div class="site-about col-xs-12">
    <div class="col-xs-12 col-lg-10 col-md-8 col-md-offset-2 col-lg-offset-1">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer" href="#collapseOne_inner">Что нужно для регистрации? <p id="icon" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseOne_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span class="text-green"> Аккаунт можно получить у администраторов сервиса ↓ </span><br>
                    <?php
                    $count = count($admins);
                    for ($i = 0;$i < $count;$i++){
                        echo $admins[$i]['surname'] . '&nbsp' . $admins[$i]['name'] . '&nbsp' . $admins[$i]['middle_name'] . '&nbsp' . '<br>' . '<span class="text-center text-info">' . $admins[$i]['email'] . '</span>' . '<br>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer1"  href="#collapseTwo_inner">Как создать нового пользователя? <p id="icon1" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseTwo_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Управление </span><br>
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
                    <a data-toggle="collapse" id="iconContainer2" href="#collapseThird_inner">Как добавить новую книгу? <p id="icon2" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseThird_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Управление</span><br>
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
                    <a data-toggle="collapse" id="iconContainer3" href="#collapseFourth_inner">Как добавить новую категорию? <p id="icon3" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseFourth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Управление</span><br>
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
                    <a data-toggle="collapse" id="iconContainer4" href="#collapseFifth_inner">Как добавить новую тематику? <p id="icon4" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseFifth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Управление</span><br>
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
                    <a data-toggle="collapse" id="iconContainer5" href="#collapseSixth_inner">Как добавить новую запись? <p id="icon5" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseSixth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Управление</span><br>
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
                    <a data-toggle="collapse" id="iconContainer6" href="#collapseSeventh_inner">Как удалить запись? <p id="icon6" class="pull-right icon"><?= $close ?></p></a>
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
                    <a data-toggle="collapse" id="iconContainer7" href="#collapseEighth_inner">Как закрыть заявку? <p id="icon7" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseEighth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Управление</span><br>
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
                    <a data-toggle="collapse" id="iconContainer8" href="#collapseNinth_inner">Как изменить заявку с уровнем доступа "Модератор"? <p id="icon8" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseNinth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Управление</span><br>
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
                    <a data-toggle="collapse" id="iconContainer9" href="#collapseTenth_inner">Чем отличается пользователь от аккаунта? <p id="icon9" class="pull-right icon"><?= $close ?></p></a>
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
                    <a data-toggle="collapse" id="iconContainer10" href="#collapseEleven_inner">Как изменить запись? <p id="icon10" class="pull-right icon"><?= $close ?></p></a>
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
                    <a data-toggle="collapse" id="iconContainer11" href="#collapseTwelve_inner">Как посмотреть книги, которые взял пользователь? <p id="icon11" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseTwelve_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Переходим во вкладку Управление</span><br>
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
                    <a data-toggle="collapse" id="iconContainer12" href="#collapseThirteenth_inner">Почему не получается удалить некоторые категории,тематики или кафедры? <p id="icon12" class="pull-right icon"><?= $close ?></p></a>
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
                    <a data-toggle="collapse" id="iconContainer13" href="#collapseFourteenth_inner">Столкнулись с проблемами или заметили ошибку? <p id="icon13" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseFourteenth_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <span> 1.Петрова Ольга Борисовна petromay@yandex.ru</span><br>
                    <span> 2.Щецко Андрей Андреевич lpwalker87@mail.ru</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $var = 0;
    $var1 = 0;
    $var2 = 0;
    $var3 = 0;
    $var4 = 0;
    $var5 = 0;
    $var6 = 0;
    $var7 = 0;
    $var8 = 0;
    $var9 = 0;
    $var10 = 0;
    $var11 = 0;
    $var12 = 0;
    $var13 = 0;
    $( "#iconContainer" ).on( "click", function() {
        if($var %2 === 0){
            $( "#icon" ).removeClass( "icon" ).addClass( "icon-active" );
            $var++;
        }
        else{
            $( "#icon" ).removeClass( "icon-active" ).addClass( "icon" );
            $var++;
        }
    });
    $( "#iconContainer1" ).on( "click", function() {
        if($var1 %2 === 0){
            $( "#icon1" ).removeClass( "icon" ).addClass( "icon-active" );
            $var1++;
        }
        else{
            $( "#icon1" ).removeClass( "icon-active" ).addClass( "icon" );
            $var1++;
        }
    });
    $( "#iconContainer2" ).on( "click", function() {
        if($var2 %2 === 0){
            $( "#icon2" ).removeClass( "icon" ).addClass( "icon-active" );
            $var2++;
        }
        else{
            $( "#icon2" ).removeClass( "icon-active" ).addClass( "icon" );
            $var2++;
        }
    });
    $( "#iconContainer3" ).on( "click", function() {
        if($var3 %2 === 0){
            $( "#icon3" ).removeClass( "icon" ).addClass( "icon-active" );
            $var3++;
        }
        else{
            $( "#icon3" ).removeClass( "icon-active" ).addClass( "icon" );
            $var3++;
        }
    });
    $( "#iconContainer4" ).on( "click", function() {
        if($var4 %2 === 0){
            $( "#icon4" ).removeClass( "icon" ).addClass( "icon-active" );
            $var4++;
        }
        else{
            $( "#icon4" ).removeClass( "icon-active" ).addClass( "icon" );
            $var4++;
        }
    });
    $( "#iconContainer5" ).on( "click", function() {
        if($var5 %2 === 0){
            $( "#icon5" ).removeClass( "icon" ).addClass( "icon-active" );
            $var5++;
        }
        else{
            $( "#icon5" ).removeClass( "icon-active" ).addClass( "icon" );
            $var5++;
        }
    });
    $( "#iconContainer6" ).on( "click", function() {
        if($var6 %2 === 0){
            $( "#icon6" ).removeClass( "icon" ).addClass( "icon-active" );
            $var6++;
        }
        else{
            $( "#icon6" ).removeClass( "icon-active" ).addClass( "icon" );
            $var6++;
        }
    });
    $( "#iconContainer7" ).on( "click", function() {
        if($var7 %2 === 0){
            $( "#icon7" ).removeClass( "icon" ).addClass( "icon-active" );
            $var7++;
        }
        else{
            $( "#icon7" ).removeClass( "icon-active" ).addClass( "icon" );
            $var7++;
        }
    });
    $( "#iconContainer8" ).on( "click", function() {
        if($var8 %2 === 0){
            $( "#icon8" ).removeClass( "icon" ).addClass( "icon-active" );
            $var8++;
        }
        else{
            $( "#icon8" ).removeClass( "icon-active" ).addClass( "icon" );
            $var8++;
        }
    });
    $( "#iconContainer9" ).on( "click", function() {
        if($var9 %2 === 0){
            $( "#icon9" ).removeClass( "icon" ).addClass( "icon-active" );
            $var9++;
        }
        else{
            $( "#icon9" ).removeClass( "icon-active" ).addClass( "icon" );
            $var9++;
        }
    });
    $( "#iconContainer10" ).on( "click", function() {
        if($var10 %2 === 0){
            $( "#icon10" ).removeClass( "icon" ).addClass( "icon-active" );
            $var10++;
        }
        else{
            $( "#icon10" ).removeClass( "icon-active" ).addClass( "icon" );
            $var10++;
        }
    });
    $( "#iconContainer11" ).on( "click", function() {
        if($var11 %2 === 0){
            $( "#icon11" ).removeClass( "icon" ).addClass( "icon-active" );
            $var11++;
        }
        else{
            $( "#icon11" ).removeClass( "icon-active" ).addClass( "icon" );
            $var11++;
        }
    });
    $( "#iconContainer12" ).on( "click", function() {
        if($var12 %2 === 0){
            $( "#icon12" ).removeClass( "icon" ).addClass( "icon-active" );
            $var12++;
        }
        else{
            $( "#icon12" ).removeClass( "icon-active" ).addClass( "icon" );
            $var12++;
        }
    });
    $( "#iconContainer13" ).on( "click", function() {
        if($var13 %2 === 0){
            $( "#icon13" ).removeClass( "icon" ).addClass( "icon-active" );
            $var13++;
        }
        else{
            $( "#icon13" ).removeClass( "icon-active" ).addClass( "icon" );
            $var13++;
        }
    });
</script>