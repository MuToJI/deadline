<!DOCTYPE html>
<html>
<head>
    <title>Авторизация пользователей</title>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
    <link href="stylo.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form action="<?= $site_url ?>?action=login" method="post">
    <div class="row">
        <label for="login">Ваш логин:</label>
        <input type="text" class="text" name="login" id="login">
    </div>
    <div class="row">
        <label for="password">Ваш пароль:</label>
        <input type="password" class="text" name="password" id="password">
    </div>
    <div class="row">
        <input type="submit" name="submit" id="btn-submit" value="Авторизоваться" />
        <input type="hidden" name="token" value="<?= $token ?>">
    </div>
</form>
<p class="to_reg"><a href="registr.php">Регистрация</a>.</p>
</body>
</html>