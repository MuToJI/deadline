<?php namespace deadline\Controls;
use deadline\Lcs;
class Login extends Controller
{
    public function getLogin()
    {
        if (!empty(Lcs\user())) {
            Lcs\redirect(SITE_URL);
        }
        echo Lcs\template('templates\aut.php', [
            'token' => Lcs\token(),
            'login' => empty($_POST['login']) ? '' : $_POST['login'],
            'site_url' => SITE_URL,
        ]);
    }

    public function postLogin()
    {
        $login = empty($_POST['login']) ? null : $_POST['login'];
        $password = empty($_POST['password']) ? null : $_POST['password'];
        if (!empty($_POST['token']) && Lcs\valid_token($_POST['token'])) {
            Lcs\user(Lcs\connection(), $login, $password);
        }
        if (!empty(Lcs\user())) {
            Lcs\redirect(SITE_URL);
        }
        Lcs\redirect(SITE_URL . '?action=login');
    }
}