<?php namespace deadline\Controls;

use deadline\Lcs;

class Home extends Controller
{
    /**
     * @param array $params
     * @return string
     */
    public function getHome($params = [])
    {
        if (empty(Lcs\user())) {
            Lcs\redirect(SITE_URL . '?action=login');
        }
        $message_id = empty($params['message_id']) ? null : (int)$params['message_id'];
        $messages = Lcs\load_messages(\deadline\Lcs\connection(), $message_id);
        $pg = Lcs\pegi();
        $per_page = 3;
        $pages = ceil($pg / $per_page);
        echo Lcs\template('../templates/home.php', [
            'messages' => $messages,
            'token' => Lcs\token(),
            'site_url' => SITE_URL,
            'message_id' => $message_id,
            'pages' => $pages,
        ]);
    }

    public function postHome($params = [])
    {
        if (empty(Lcs\user())) {
            Lcs\redirect(SITE_URL . '?action=login');
        }
        $message_id = empty($_POST['message_id']) ? null : (int)$_POST['message_id'];
        $message = empty($_POST['message']) ? null : $_POST['message'];
        if (!empty($message) && Lcs\valid_token($_POST['token'])) {
            isset($message_id)
                ? Lcs\update_message(Lcs\connection(), $message, $message_id)
                : Lcs\insert_message(Lcs\connection(), $message, 0);
        }
        Lcs\redirect(SITE_URL . "?message_id={$message_id}");
    }
}



