<?php
use yii\helpers\Html;
$this->title = 'Обновления';

$badges = [
        '<span class="badge badge-success pull-right">Выполнено</span>',
        '<span class="badge badge-primary pull-right">В процессе</span>',
        '<span class="badge badge-warning pull-right">Запланировано</span>',
        '<span class="badge badge-secondary pull-right">Отложено</span>',
        '<span class="badge badge-danger pull-right">Пропущено</span>'

];
$i = 0;
$current = 19;
$close = '<svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <g stroke="none" stroke-width="1px" fill="none" fill-rule="evenodd" stroke-linecap="square">
        <g transform="translate(1.000000, 1.000000)" stroke="#222222">
            <path d="M0,11 L22,11"></path>
            <path d="M11,0 L11,22"></path>
        </g>
    </g>
</svg>';
?>
<style>
    .panel {
        margin-top: 0;
    }
    .badge-success{
        background-color: #28a745;
    }
    .badge-primary{
        background-color: #337ab7;
    }
    .badge-warning{
        color: #212529;
        background-color: #ffc107;
    }
    .badge-danger{
        background-color: #dc3545;
    }
</style>
<script src="../../web/js/collapse.js"></script>
<h1 class="text-center"><?= Html::encode($this->title) ?></h1>

<div class="site-update col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" id="iconContainer" href="#collapseOne_inner"> Список изменений версии alpha 0.0.2<p id="icon" class="pull-right icon"><?= $close ?></p></a>
                </h4>
            </div>
            <div id="collapseOne_inner" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>
                    1)Была добавлена страница с инструкциями по работе и контактными данными<br>
                    2)Для каждой формы были написаны валидаторы (для каждой колонки), была запрещена клиентская проверка формы, теперь все через Ajax<br>
                    3)Была переработана структура БД (Все колонки text были поменяны на varchar (255), кроме аннотации), колонки, где был varchar (255), были уменьшены до разумных размеров<br>
                    4)Были перезаписаны все модели<br>
                    5)Было исправлено множество багов, касающихся изменений или удаления в связанных таблицах<br>
                    6)Было включено кеширование схем таблиц на 10 минут<br>
                    7)Было добавлено множество проверок и транзакций при работе с бд<br>
                    8)Изменено отображение меню для каждой группы доступа<br>
                    9)Теперь удаление пользователя-аккаунта, автоматически удаляет все неактивные заявки, связанные с ним (если нет активных заявок)<br>
                    10)Теперь удаление книги, удаляет все неактивные заявки, связанные с 	ней (если нет активных заявок)<br>
                    11)Добавлены валидаторы для форм поиска (через get)<br>
                    12)Все ссылки и пути, которые конфликтовали с сервером Linux были исправлены<br>
                    13)Теперь форма регистрации выдает сообщение, если в уникальное поле было введено 	значение, которое уже используется (Логин “admin” уже используется)<br>
                    14)Была введена проверка на отправку пустой формы<br>
                    15)Были исправлены некоторые всплывающие сообщения связанные с кириллицей<br>
                    16)Yii Framework был обновлен до последней версии 2.0.38<br>
                    17)Были изменены стандартные сортировки при отображении таблиц (для удобства пользователя)<br>
                    <b class="text-primary">© Diamond</b>
                    </p>
                </div>
            </div>
        </div>
</div>

<div class="site-update col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" id="iconContainer1" href="#collapseTwo_inner">Список изменений версии alpha 0.0.3<p id="icon1" class="pull-right icon"><?= $close ?></p></a>
            </h4>
        </div>
        <div id="collapseTwo_inner" class="panel-collapse collapse">
            <div class="panel-body">
                <p>
                    <hr class="my-4">
                    <b class="col-xs-12 text-center">Страница с инструкциями</b><br>
                    <hr class="my-4">
                    1)Email теперь кликабельный<br>
                    2)После нажатия на email осуществляется перенос в почтовый клиент, в котором сразу передается шаблон с сообщением и темой<br>
                    <hr class="my-4">
                    <b class="col-xs-12 text-center">Страница профиля</b><br>
                    <hr class="my-4">
                    1)Была добавлена страница профиля с базовой информацией о пользователе и статистикой сервиса<br>
                    <hr class="my-4">
                    <b class="col-xs-12 text-center">Оформление для телефона</b><br>
                    <hr class="my-4">
                    1)Было исправлено некорректное отображение футера на мобильных устройствах<br>
                    2)Было исправлено некорректное отображение формы авторизации на мобильных устройствах<br>
                    3)Было исправлено некорректное отображение страницы с инструкциями на мобильных устройствах<br>
                    <hr class="my-4">
                    <b class="col-xs-12 text-center">Оформление для компьютера</b><br>
                    <hr class="my-4">
                    1)Было исправлено некорректное отображение страницы с инструкциями на персональных устройствах<br>
                    2)Было улучшено отображение формы авторизации на персональных устройствах<br>
                    <hr class="my-4">
                    <b class="col-xs-12 text-center">Общие улучшения</b><br>
                    <hr class="my-4">
                    1)Yii Framework был обновлен до последней версии Yii 2.0.40<br>
                    2)Были добавлены индикаторы online / Последнее время посещения, в профиле<br>
                    3)Была произведена работа по улучшению кода<br>
                    4)Была добавлена страница с историей обновлений сервиса и планами на следующие обновления сервиса<br>
                    5)Были добавлены специальные значки на страницу обновлений, при помощи которых можно отследить ход выполнения задач для следующего патча<br>
                    <hr class="my-4">
                    <b class="col-xs-12 text-center">Исправленные баги</b><br>
                    <hr class="my-4">
                    1)Был исправлен баг с некорректным отображением страницы с книгами для определенных групп пользователей<br>
                    2)Был частично исправлен баг с отображением кнопок действия на сайте, к которым у пользователя нет доступа<br>
                    3)Был исправлен баг, при помощи которого неавторизованный пользователь мог получить доступ к странице профиля<br>
                    4)Был исправлен баг, при помощи которого неавторизованный пользователь мог получить доступ к странице с книгами<br>
                    <hr class="my-4">
                    <b class="col-xs-12 text-center">База данных</b><br>
                    <hr class="my-4">
                    1)Все колонки в таблицах, которые участвуют в поиске были проиндексированы (Время выполнения запроса на поиск уменьшилось на четверть)<br>
                    <hr class="my-4">
                    <b class="text-primary">© Diamond 14.01.2021</b>
            </div>
        </div>
    </div>
</div>

<div class="site-update col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" id="iconContainer2" href="#collapseThree_inner">Список изменений версии alpha 0.0.4<p id="icon2" class="pull-right icon"><?= $close ?></p></a>
            </h4>
        </div>
        <div id="collapseThree_inner" class="panel-collapse collapse">
            <div class="panel-body">
                <p>
                <hr class="my-4">
                <b class="col-xs-12 text-center">Форма обратной связи</b><br>
                <hr class="my-4">
                1)Была добавлена контактная форма с функциями запроса аккаунта от администратора, сообщением об ошибки, связи с администрацией.<br>
                <hr class="my-4">
                <b class="col-xs-12 text-center">Интерфейс</b><br>
                <hr class="my-4">
                1)Интерфейс сервиса был переведен на русский язык.<br>
                2)Были добавлены описания для каждого поля ввода в формах.<br>
                3)Было убрано отображение того функционала, к которому у пользователя нет доступа.<br>
                4)Была добавлена кнопка просмотра подробной информации о книге, для тех, у кого уровень доступа ниже чем модератор.<br>
                5)Была добавлена ссылка на запрос аккаунта на странице авторизации.<br>
                6)Было добавлено поле ввода "Подтверждения пароля" для формы регистрации.<br>
                7)Была добавлена кнопка "Просмотреть пароль" для формы регистрации.<br>
                8)Было добавлено поле вывода информации о дате регистрации во вкладке "Аккаунты".<br>
                9)Было добавлено поле вывода информации о дате последнего посещения во вкладке "Аккаунты".<br>
                <hr class="my-4">
                <b class="col-xs-12 text-center">База данных</b><br>
                <hr class="my-4">
                1)Были добавлены поля с информацией о дате последнего посещения и о дате регистрации пользователя.<br>
                2)Было добавлено поле phone, в котором хранится номер телефона пользователя.<br>
                3)Номер пропуска/удостоверения теперь varchar а не int.<br>
                4)Все действия над БД были обернуты в транзакции.<br>
                <hr class="my-4">
                <b class="col-xs-12 text-center">Исправленные баги</b><br>
                <hr class="my-4">
                1)Было запрещено администраторам редактировать профили друг друга.<br>
                2)Было запрещено модераторам редактировать профили друг друга.<br>
                3)Был исправлен фильтр "Кафедра" во вкладке "Аккаунты".<br>
                4)Были удалены некоторые уникальные индексы в БД.<br>
                5)Была добавлена проверка на введенные пробелы в начале полей ввода.<br>
                6)Был добавлен вывод ошибок, которые случаются при выполнении транзакций в БД.<br>
                7)Вывод информации об ошибках был улучшен.<br>
                8)Были исправлены правила валидация, при которых пустое поле не заносилось в БД, как NULL.<br>
                9)Были исправлен поиск по параметрам, там где он не работал.<br>
                <hr class="my-4">
                <b class="col-xs-12 text-center">Валидация</b><br>
                <hr class="my-4">
                1)В модели таблиц были добавлены описания уникальных полей БД.<br>
                2)В модели таблицы "accounts" было добавлено провело о запрете возврата пароля и "ключа доступа" в формы авторизации и регистрации.<br>
                3)Была улучшена и оптимизирована валидация полей, которые участвуют в поиске.<br>
                <hr class="my-4">
                <b class="col-xs-12 text-center">Общие улучшения</b><br>
                <hr class="my-4">
                1)Yii Framework был обновлен до последней версии Yii 2.0.40.<br>
                2)Теперь ФИО в "Аккаунты" и "Пользователи" сохраняется всегда с заглавной буквы.<br>
                3)Была произведена оптимизация кода.<br>
                <hr class="my-4">
                <b class="text-primary">© Diamond 20.01.2021</b>
            </div>
        </div>
    </div>
</div>

<div class="site-update col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" id="iconContainer3" href="#collapseFour_inner">Планы версии alpha 0.0.5<p id="icon3" class="pull-right icon"><?= $close ?></p></a>
            </h4>
        </div>
        <div id="collapseFour_inner" class="panel-collapse collapse">
            <div class="panel-body">
                <p>
                    1)Исправить отображение контактной формы на мобильных устройствах <?= $badges[0]; ?><br>
                    2)Добавить возможность пользователям с уровнем доступа ниже модератора, просматривать детальное описание книг <?= $badges[0]; ?><br>
                    3)Исправить ошибки с путями для Linux систем <?= $badges[0]; ?><br>
                    4)Исправить отображение элементов, к которым у пользователя нет доступа <?= $badges[0]; ?><br>
                    5)Исправить доступ к разделам, к которым у пользователя нет доступа <?= $badges[0]; ?><br>
                    6)Исправить описание инструкций <?= $badges[0]; ?><br>
                    <?= '<b class="col-xs-12 text-center text-danger"> Релиз патча 6/6</b>' ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="site-update col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" id="iconContainer4" href="#collapseFive_inner">Планы версии alpha 0.0.6<p id="icon4" class="pull-right icon"><?= $close ?></p></a>
            </h4>
        </div>
        <div id="collapseFive_inner" class="panel-collapse collapse">
            <div class="panel-body">
                <p>
                    1)Добавить возможность редактирования своих данных в профиле.<?= $badges[2]; ?><br>
                    2)Добавить фотографии (аватарки) пользователей.<?= $badges[2]; ?><br>
                    3)Добавить обложки книг.<?= $badges[2]; ?><br>
                    4)Добавить раздел профиля с сообщениями из контактной формы.<?= $badges[2]; ?><br>
                    5)Улучшить кеширование.<?= $badges[2]; ?><br>
                    6)Написать тесты, фабрики.<?= $badges[2]; ?><br>
                    7)Добавить логгирование неудачных попыток удаления пользователя.<?= $badges[2]; ?><br>
                    8)Добавить шифрование данных при ajax валидации пароля.<?= $badges[2]; ?><br>
                    9)Дублировать сообщения с контактной формы на сервер <?= $badges[2]; ?><br>
                    10)Исправить отображение контактной формы на мобильных устройствах <?= $badges[2]; ?><br>
                    11)Изменить контактную форму для авторизованных пользователей(Вводить данные, которые уже есть в системе) <?= $badges[2]; ?><br>
                    12)Красиво оформить список изменений для патча 0.0.2 <?= $badges[2]; ?><br>
                    13)Сделать страницу обновлений динамической <?= $badges[2]; ?><br>
                    14)Реализовать бекап бд <?= $badges[2]; ?><br>
                    15)Переделать оформление форм изменения данных <?= $badges[2]; ?><br>
                    16)Исправить placeholder для контактной формы для мобильных устройств <?= $badges[2]; ?><br>
                    17)Добавить валидацию phone в accounts <?= $badges[2]; ?><br>
                    18)Удалить password и auth_key из сущности user <?= $badges[2]; ?><br>
                    19)Сделать addFlesh вместо setFlash, где возможно появление нескольких ошибок <?= $badges[2]; ?><br>
                    <?= '<b class="col-xs-12 text-center text-danger"> Релиз патча ' .$i.'/'. $current .'</b>' ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" id="iconContainer" href="#collapseOneMillion_inner">&nbsp</a>
        </h4>
    </div>
    <div id="collapseOneMillion_inner" class="panel-collapse collapse">
        <div class="panel-body text-warning">
            © Щецко Андрей  <span class="text-primary">lpwalker87@mail.ru</span>
        </div>
    </div>
</div>