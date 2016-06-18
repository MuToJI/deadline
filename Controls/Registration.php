<?php namespace deadline\Controls;

use deadline\Lcs;

class Registration extends Controller
{

    public function postRegistration()
    {

        if (!empty(Lcs\connection())) {
            if (isset($_POST['login'])) {
                $login = $_POST['login'];
                if ($login == '') {
                    unset($login);
                }
            }
            if (isset($_POST['password'])) {
                $password = $_POST['password'];
                if ($password == '') {
                    unset($password);
                }
            }
            if (empty($login) or empty($password)) {
                header('Location:\Registration.php');
            }
            $login = trim($_POST['login']);
            $password = md5(trim($_POST['password']));

            $sql = ("INSERT INTO `users` SET `login`='" . $login . "', password='" . $password . "'");
            $result = Lcs\connection()->query($sql);

            if ($result) {
                header('Location:index.php');
            }
        }

    }
}
    

