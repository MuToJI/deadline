<!DOCTYPE html>
<html>
<head>
    <title>Регистрация пользователей</title>
    <link href="stylo.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form action="index.php?action=reg" method="post">
    <div class="row">
        <label for="login">Укажите ваш логин:</label>
        <input type="text" class="text" name="login" value=""  />
    </div>
    <div class="row">
        <label for="password">Напишите ваш пароль:</label>
        <input type="password" class="text" name="password" value="" />
    </div>
    <div class="row">
        <label for="password_again">Повторите введенный пароль:</label>
        <input type="password" class="text" name="password_again" id="password_again" value="" />
    </div>
    <div class="row">

        <input type="submit" name="submit" id="btn-submit" value="Зарегистрироваться" />

        <input type="reset" name="reset" id="btn-reset" value="Очистить" />
    </div>
</form>
</body>
</html>
